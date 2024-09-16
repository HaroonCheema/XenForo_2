<?php

namespace AVForums\TagEssentials\XF\Admin\Controller;

use XF\Mvc\Entity\Finder;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\Redirect;
use XF\Mvc\Reply\View;

/**
 * Class Tag
 *
 * @package AVForums\TagEssentials\XF\Admin\Controller
 */
class Tag extends XFCP_Tag
{
    /**
     * @param ParameterBag $params
     *
     * @return \XF\Mvc\Reply\View
     * @throws \XF\PrintableException
     */
    public function actionIndex(ParameterBag $params)
    {
        if ($this->isPost())
        {
            $state = $this->filter('state', 'str');
            $tagIds = $this->filter('selected_tags', 'array-uint');
            if ($tagIds)
            {
                switch ($state)
                {
                    case 'delete':
                        $tagFinder = $this->finder('XF:Tag');
                        $tags = $tagFinder->where('tag_id', $tagIds)->fetch();

                        $db = $this->app->db();

                        $db->beginTransaction();

                        /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
                        foreach ($tags AS $tag)
                        {
                            $tag->delete(true, false);
                        }

                        $db->commit();
                        break;
                    case 'blacklist_tags':
                        $tagFinder = $this->finder('XF:Tag');
                        $tags = $tagFinder->where('tag_id', $tagIds)->fetch();

                        $db = $this->app->db();

                        $db->beginTransaction();

                        /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
                        foreach ($tags AS $tag)
                        {
                            /** @var \AVForums\TagEssentials\Entity\Blacklist $blacklist */
                            $blacklist = $this->em()->create('AVForums\TagEssentials:Blacklist');
                            $blacklist->tag = $tag->tag;
                            $blacklist->save();

                            $tag->delete(true, false);
                        }

                        $db->commit();
                        break;
                }
            }
        }

        return parent::actionIndex($params);
    }

    /**
     * @param \XF\Entity\Tag $tag
     *
     * @return View
     */
    public function tagAddEdit(\XF\Entity\Tag $tag)
    {
        $response = parent::tagAddEdit($tag);

        if ($response instanceof View)
        {
            /** @var \XF\Repository\Node $nodeRepo */
            $nodeRepo = \XF::repository('XF:Node');
            $nodeTree = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());

            /** @var \AVForums\TagEssentials\Repository\TagCategory $categoryRepo */
            $categoryRepo = $this->repository('AVForums\TagEssentials:TagCategory');
            $categories = $categoryRepo->getCategoryTitlePairs();

            $response->setParams([
                'categories' => $categories,
                'nodeTree' => $nodeTree
            ]);
        }

        return $response;
    }

    /**
     * @param \XF\Entity\Tag|\AVForums\TagEssentials\XF\Entity\Tag $tag
     *
     * @return \XF\Mvc\FormAction
     */
    protected function tagSaveProcess(\XF\Entity\Tag $tag)
    {
        $form = parent::tagSaveProcess($tag);

        /** @var \AVForums\TagEssentials\Repository\TagCategory $categoryRepo */
        $categoryRepo = $this->repository('AVForums\TagEssentials:TagCategory');
        $categories = $categoryRepo->getCategoryTitlePairs();

        $input = $this->filter([
            'tagess_category_id' => 'str',
            'apply_node_ids' => 'bool',
            'allowed_node_ids' => 'array-uint',
            'synonyms' => 'str'
        ]);

        if (empty($input['tagess_category_id']))
        {
            unset($input['tagess_category_id']);
        }
        else
        {
            if (!isset($categories[$input['tagess_category_id']]))
            {
                return $this->notFound(\XF::phrase('avForumsTagEss_requested_tag_category_not_found'));
            }
        }

        if (!$input['apply_node_ids'])
        {
            unset($input['allowed_node_ids']);
        }
        $synonyms = $input['synonyms'];
        unset($input['apply_node_ids'], $input['synonyms']);

        /** @var \AVForums\TagEssentials\XF\Repository\Tag $tagRepo */
        $tagRepo = $this->repository('XF:Tag');
        $synonyms = $tagRepo->splitTagList($synonyms);
        $tag->setOption('synonyms', $synonyms);

        $form->setupEntityInput($tag, $input);

        return $form;
    }

    public function actionDelete(ParameterBag $params)
    {
        $response = parent::actionDelete($params);
        if ($response instanceof Redirect)
        {
            $response->setUrl($this->getDynamicRedirect($response->getUrl()));
        }

        return $response;
    }

    public function actionMerge(ParameterBag $params)
    {
        $response = parent::actionMerge($params);
        if ($response instanceof Redirect)
        {
            $response->setUrl($this->getDynamicRedirect($response->getUrl()));
        }

        return $response;
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\PrintableException
     */
    public function actionWiki(ParameterBag $parameterBag)
    {
        $tag = $this->assertTagExists($parameterBag->get('tag_id'));

        if ($this->isPost())
        {
            $input = $this->filter([
                'tagess_wiki_tagline' => 'str'
            ]);

            /** @var \XF\ControllerPlugin\Editor $editorPlugin */
            $editorPlugin = $this->plugin('XF:Editor');
            $input['tagess_wiki_description'] = $editorPlugin->fromInput('tagess_wiki_description');

            $tag->bulkSet($input);
            $tag->save();

            return $this->redirect($this->buildLink('tags'), \XF::phrase('avForumsTagEss_wiki_changes_saved_successfully'));
        }

        $viewParams = [
            'tag' => $tag
        ];
        return $this->view('AVForums\TagEssentials\XF:Tag\Wiki', 'avForumsTagEss_wiki', $viewParams);
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return \XF\Mvc\Reply\Error|\XF\Mvc\Reply\Redirect|View
     * @throws \XF\PrintableException
     */
    public function actionBlacklist(/** @noinspection PhpUnusedParameterInspection */ParameterBag $parameterBag)
    {
        /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
        $tag = null;
        $isRegex = $this->filter('isRegex', 'bool');
        $tagName = $this->filter('new_tag', 'str');
        $existingTagId = $this->filter('existing_tag_id', 'uint');
        if ($existingTagId)
        {
            $tag = $this->em()->find('XF:Tag', $existingTagId);
            if ($tag)
            {
                $tagName = $tag->tag;
            }
        }
        else if ($tagName)
        {
            $tag = $this->app->finder('XF:Tag')
                             ->where('tag', $tagName)
                             ->fetchOne();
        }

        if ($this->isPost())
        {
            \XF::db()->beginTransaction();

            /** @var \AVForums\TagEssentials\Entity\Blacklist $blacklist */
            $blacklist = $this->em()->create('AVForums\TagEssentials:Blacklist');
            $blacklist->tag = $tagName;
            $blacklist->regex = $isRegex;
            $blacklist->save(true, false);

            if ($tag && $tag->exists())
            {
                $tag->delete(true, false);
            }

            \XF::db()->commit();

            return $this->redirect($this->buildLink('tags/blacklisted'), \XF::phrase('avForumsTagEss_tag_added_to_blacklist_successfully'));
        }
        if (!$tag)
        {
            $tag = $this->em()->create('XF:Tag');
            $tag->tag = $tagName;
            $tag->setReadOnly(true);
        }

        $viewParams = [
            'tag'     => $tag,
            'tagName' => $tagName,
            'isRegex' => $isRegex,
        ];

        return $this->view('AVForums\TagEssentials\XF:Tag\Blacklist', 'avForumsTagEss_blacklist', $viewParams);
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return \XF\Mvc\Reply\View
     */
    public function actionCategories(/** @noinspection PhpUnusedParameterInspection */ParameterBag $parameterBag)
    {
        /** @var \AVForums\TagEssentials\Repository\TagCategory $tagCategoryRepo */
        $tagCategoryRepo = $this->repository('AVForums\TagEssentials:TagCategory');
        $tagCategories = $tagCategoryRepo->getCategoryTitlePairs();

        $viewParams = [
            'tagCategories' => $tagCategories
        ];
        return $this->view('AVForums\TagEssentials\XF:Tag\CategoryList', 'avForumsTagEss_category_list', $viewParams);
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return \XF\Mvc\Reply\View
     */
    public function actionAddCategory(/** @noinspection PhpUnusedParameterInspection */ParameterBag $parameterBag)
    {
        /** @var \AVForums\TagEssentials\Entity\TagCategory $tagCategory */
        $tagCategory = $this->em()->create('AVForums\TagEssentials:TagCategory');
        return $this->tagCategoryAddEdit($tagCategory);
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return \XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionEditCategory(/** @noinspection PhpUnusedParameterInspection */ParameterBag $parameterBag)
    {
        $categoryId = $this->filter('category_id', 'str');

        /** @var \AVForums\TagEssentials\Entity\TagCategory $tagCategory */
        $tagCategory = $this->assertTagCategoryExists($categoryId);
        return $this->tagCategoryAddEdit($tagCategory);
    }

    /**
     * @param \AVForums\TagEssentials\Entity\TagCategory $tagCategory
     *
     * @return \XF\Mvc\Reply\View
     */
    protected function tagCategoryAddEdit(\AVForums\TagEssentials\Entity\TagCategory $tagCategory)
    {
        $viewParams = [
            'tagCategory' => $tagCategory
        ];
        return $this->view('AVForums\TagEssentials\XF:Tag\EditCategory', 'avForumsTagEss_category_edit', $viewParams);
    }

    /**
     * @param \AVForums\TagEssentials\Entity\TagCategory $tagCategory
     *
     * @return \XF\Mvc\FormAction
     */
    protected function tagCategorySaveProcess(\AVForums\TagEssentials\Entity\TagCategory $tagCategory)
    {
        $entityInput = $this->filter([
            'category_id' => 'str',
            'title' => 'str'
        ]);

        $form = $this->formAction();
        $form->basicEntitySave($tagCategory, $entityInput);

        return $form;
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return \XF\Mvc\Reply\Redirect
     * @throws \XF\Mvc\Reply\Exception
     * @throws \XF\PrintableException
     */
    public function actionSaveCategory(/** @noinspection PhpUnusedParameterInspection */ParameterBag $parameterBag)
    {
        $this->assertPostOnly();

        $categoryId = $this->filter('existing_category_id', 'str');

        /** @var \AVForums\TagEssentials\Entity\TagCategory $tagCategory */
        if ($categoryId)
        {
            $tagCategory = $this->assertTagCategoryExists($categoryId);
        }
        else
        {
            $tagCategory = $this->em()->create('AVForums\TagEssentials:TagCategory');
        }

        $this->tagCategorySaveProcess($tagCategory)->run();

        return $this->redirect($this->buildLink('tags/categories'));
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     * @throws \XF\PrintableException
     */
    public function actionDeleteCategory(/** @noinspection PhpUnusedParameterInspection */ParameterBag $parameterBag)
    {
        $categoryId = $this->filter('category_id', 'str');
        $tagCategory = $this->assertTagCategoryExists($categoryId);

        if ($this->isPost())
        {
            $tagCategory->delete();
            return $this->redirect($this->getDynamicRedirect($this->buildLink('tags/categories')));
        }

        $viewParams = [
            'tagCategory' => $tagCategory
        ];
        return $this->view('AVForums\TagEssentials\XF:Tag\DeleteCategory', 'avForumsTagEss_category_delete', $viewParams);
    }

    /**
     * @param      $id
     * @param null $with
     * @param null $phraseKey
     *
     * @return \XF\Mvc\Entity\Entity
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function assertTagCategoryExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('AVForums\TagEssentials:TagCategory', $id, $with, $phraseKey);
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return View
     * @throws \XF\Mvc\Reply\Exception
     */
    public function actionBlacklisted(/** @noinspection PhpUnusedParameterInspection */ParameterBag $parameterBag)
    {
        if ($this->isPost())
        {
            $state = $this->filter('state', 'str');
            $tagIds = $this->filter('selected_tags', 'array-uint');
            if ($tagIds)
            {
                switch ($state)
                {
                    case 'delete':
                        $tagFinder = $this->finder('AVForums\TagEssentials:Blacklist');
                        $tags = $tagFinder->where('blacklist_id', $tagIds)->fetch();

                        $db = $this->app->db();

                        $db->beginTransaction();

                        /** @var \AVForums\TagEssentials\Entity\Blacklist $tag */
                        foreach ($tags AS $tag)
                        {
                            $tag->delete(true, false);
                        }

                        $db->commit();
                        break;
                }
            }
        }

        $page = $this->filterPage();
        $perPage = 100;

        $blacklistedTagFinder = $this->finder('AVForums\TagEssentials:Blacklist')
            ->with('User')
            ->limitByPage($page, $perPage);

        $this->applyBlacklistTagListFilters($blacklistedTagFinder, $filters);

        $total = $blacklistedTagFinder->total();
        $this->assertValidPage($page, $perPage, $total, 'tags/blacklisted');

        $blacklistedTagFinder->limitByPage($page, $perPage);

        $viewParams = [
            'blacklistedTags' => $blacklistedTagFinder->fetch(),
            'filters' => $filters,

            'page' => $page,
            'perPage' => $perPage,
            'total' => $total
        ];
        return $this->view('AVForums\TagEssentials\XF:Tag\Blacklisted', 'avForumsTagEss_blacklisted_tags', $viewParams);
    }

    /**
     * @param Finder $finder
     * @param        $filters
     */
    protected function applyBlacklistTagListFilters(Finder $finder, &$filters)
    {
        $filters = [];

        $containing = $this->filter('containing', 'str');
        if ($containing !== '')
        {
            $finder->where('tag', 'LIKE', $finder->escapeLike($containing, '%?%'));
            $filters['containing'] = $containing;
        }

        $order = $this->filter('order', 'str');
        switch ($order)
        {
            default:
                $finder->order('tag');
        }
    }

    /**
     * @param      $id
     * @param null $with
     * @param null $phraseKey
     *
     * @return \XF\Mvc\Entity\Entity
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function assertBlacklistExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('AVForums\TagEssentials:Blacklist', $id, $with, $phraseKey);
    }

    /**
     * @param ParameterBag $parameterBag
     *
     * @return \XF\Mvc\Reply\Redirect|\XF\Mvc\Reply\View
     * @throws \XF\Mvc\Reply\Exception
     * @throws \XF\PrintableException
     */
    public function actionDeleteBlacklist(/** @noinspection PhpUnusedParameterInspection */ParameterBag $parameterBag)
    {
        $blacklistId = $this->filter('blacklist_id', 'uint');
        $blacklist = $this->assertBlacklistExists($blacklistId);

        if ($this->isPost())
        {
            $blacklist->delete();

            return $this->redirect($this->getDynamicRedirect($this->buildLink('tags/blacklisted')));
        }

        $viewParams = [
            'blacklist' => $blacklist
        ];
        return $this->view('AVForums\TagEssentials\XF:Tag\DeleteBlacklist', 'avForumsTagEss_blacklist_delete', $viewParams);
    }
}