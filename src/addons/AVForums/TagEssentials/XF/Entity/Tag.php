<?php

namespace AVForums\TagEssentials\XF\Entity;

use AVForums\TagEssentials\Entity\TagSynonym;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property string tagess_wiki_description
 * @property string tagess_wiki_tagline
 * @property int[] allowed_node_ids
 * @property string tagess_category_id
 * @property int tagess_wiki_last_edit_date
 * @property int tagess_wiki_last_edit_user_id
 * @property int tagess_wiki_edit_count
 *
 * RELATIONS
 * @property \AVForums\TagEssentials\Entity\TagCategory TagCategory
 * @property \AVForums\TagEssentials\Entity\TagSynonym SynonymOf
 * @property ArrayCollection|\AVForums\TagEssentials\Entity\TagSynonym[] Synonyms
 */
class Tag extends XFCP_Tag
{
    /**
     * @param null $error
     *
     * @return bool
     */
    public function canView(/** @noinspection PhpUnusedParameterInspection */&$error = null)
    {
        return true;
    }

    /**
     * @param null $error
     *
     * @return bool
     */
    public function canEdit(/** @noinspection PhpUnusedParameterInspection */&$error = null)
    {
        return $this->canEditWiki() || $this->canEditCategory();
    }

    /**
     * @param null $error
     *
     * @return bool
     */
    public function canEditWiki(&$error = null)
    {
        /** @var \AVForums\TagEssentials\XF\Entity\User $visitor */
        $visitor = \XF::visitor();
        return $visitor->canEditTagWiki($error);
    }

    /**
     * @param null $error
     *
     * @return bool
     */
    public function canWatch(&$error = null)
    {
        /** @var \AVForums\TagEssentials\XF\Entity\User $visitor */
        $visitor = \XF::visitor();
        return $visitor->canWatchTag($error);
    }

    /**
     * @param null $error
     *
     * @return bool
     */
    public function canViewUsers(&$error = null)
    {
        /** @var \AVForums\TagEssentials\XF\Entity\User $visitor */
        $visitor = \XF::visitor();
        return $visitor->canViewTagUsers($error);
    }

    /**
     * @param null $error
     *
     * @return bool
     */
    public function canEditCategory(&$error = null)
    {
        /** @var \AVForums\TagEssentials\XF\Entity\User $visitor */
        $visitor = \XF::visitor();
        return $visitor->canEditTagCategory($error);
    }

    /**
     * @param null $error
     *
     * @return bool
     */
    public function canViewHistory(&$error = null)
    {
        /** @var \AVForums\TagEssentials\XF\Entity\User $visitor */
        $visitor = \XF::visitor();
        return $visitor->canViewTagWikiHistory($error);
    }

    /**
     * @param bool   $includeSelf
     * @param string $linkType
     *
     * @return array
     */
    public function getBreadcrumbs($includeSelf = true, $linkType = 'public')
    {
        $output = [];
        /** @var \XF\Mvc\Router $router */
        $router = $this->app()->container('router.' . $linkType);

        if ($includeSelf)
        {
            $output[] = [
                'value' => $this->tag,
                'href' => $router->buildLink($this)
            ];
        }

        return $output;
    }

    protected function _preSave()
    {
        parent::_preSave();

        if ($this->isInsert())
        {
            /** @var \AVForums\TagEssentials\Repository\Blacklist $blacklistRepo */
            $blacklistRepo = $this->repository('AVForums\TagEssentials:Blacklist');
            if ($blacklistRepo->isTagBlacklisted($this, null))
            {
                $this->error(\XF::phrase('avForumsTagEss_tag_is_blacklisted', ['tag' => $this->tag]));
            }
        }

        if ($this->hasErrors())
        {
            return;
        }

        if (($this->tagess_wiki_description === null || $this->tagess_wiki_description === '') && $this->app()->options()->tagessPullFromWikipedia)
        {
            /** @var \AVForums\TagEssentials\XF\Repository\Tag $tagRepo */
            $tagRepo = $this->repository('XF:Tag');
            if ($description = $tagRepo->getWikiDescriptionByFuzzyTitle($this->tag))
            {
                $this->tagess_wiki_description = $description;
            }
            else
            {
                $this->tagess_wiki_description = \XF::phrase('avForumsTagEss_no_wikipedia_entry_exists')->render();
            }
        }
    }

    /**
     * @throws \XF\PrintableException
     */
    protected function _postSave()
    {
        // do this in the post save so it is inside a transaction
        $synonyms = $this->getOption('synonyms');
        $this->setOption('synonyms', null);
        if ($synonyms !== null)
        {
            $this->_processSynonym($synonyms);
        }

        if ($this->isUpdate() && !$this->isChanged(['tag', 'tag_url']) && $this->isChanged('tagess_category_id'))
        {
            $this->app()->jobManager()->enqueueUnique('tagUpdate' . $this->tag_id, 'XF:TagRecache', [
                'tagId' => $this->tag_id
            ]);
        }

        parent::_postSave();
    }

    protected function _postDelete()
    {
        parent::_postDelete();
        $db = $this->db();
        $tagId = $this->tag_id;
        $db->query('delete from xf_tagess_tag_watch where tag_id = ?', $tagId);
        $db->query('delete from xf_tagess_synonym where tag_id = ?', $tagId);
        $db->query('delete from xf_tagess_synonym where parent_tag_id = ?', $tagId);
    }

    /**
     * @param string[] $synonyms
     * @throws \XF\PrintableException
     */
    protected function _processSynonym(array $synonyms)
    {
        $synonyms = \array_unique($synonyms);
        $existingTags = null;
        $tagessSynonymRewrite = \XF::options()->tagessSynonymRewrite;
        $tagIdsToRewrite = [];
        $db = $this->db();
        /** @var \AVForums\TagEssentials\XF\Repository\Tag $tagRepo */
        $tagRepo = $this->repository('XF:Tag');

        $existingSynonyms = $this->Synonyms;
        $synonymsToDelete = new ArrayCollection($existingSynonyms->toArray());

        if ($synonyms)
        {
            $existingTags = $this->finder('XF:Tag')
                                 ->where('tag', $synonyms)
                                 ->with('SynonymOf.ParentTag')
                                 ->keyedBy('tag')
                                 ->fetch();

            foreach ($synonyms as $synonym)
            {
                /** @var \AVForums\TagEssentials\XF\Entity\Tag $synonymTag */
                $synonymTag = isset($existingTags[$synonym]) ? $existingTags[$synonym] : null;
                if (!$synonymTag)
                {
                    if ($tagRepo->isValidTag($synonym))
                    {
                        $this->error(\XF::phrase('avForumsTagEss_please_enter_valid_tag', ['tag' => $synonym]));
                    }

                    $synonymTag = $this->em()->create('XF:Tag');
                    $synonymTag->tag = $synonym;
                    $synonymTag->permanent = true;
                    $synonymTag->save(true, false);
                }
                else if ($synonymTag->tag_id === $this->tag_id)
                {
                    $this->error(\XF::phrase('avForumsTagEss_tag_cannot_be_a_synonym_of_itself', ['tag' => $synonym]));
                }
                else if ($synonymTag->SynonymOf)
                {
                    if ($synonymTag->SynonymOf->parent_tag_id === $this->tag_id)
                    {
                        $id = $synonymTag->SynonymOf->getIdentifier();
                        unset($synonymsToDelete[$id]);

                        continue;
                    }
                    $this->error(\XF::phrase('avForumsTagEss_x_tag_is_already_synonym_of_y_tag', ['tag' => $synonym, 'existingParent' => $synonymTag->SynonymOf->ParentTag->tag]));
                }
                else
                {
                    $synonymTag->permanent = true;
                    $synonymTag->saveIfChanged($saved, true, false);
                }

                /** @var TagSynonym $synonym */
                $synonym = $this->em()->create('AVForums\TagEssentials:TagSynonym');
                $synonym->tag_id = $synonymTag->tag_id;
                $synonym->parent_tag_id = $this->tag_id;
                // composite primary key structure is weird
                $id = $synonym->getIdentifier();
                // ensure we delist this synonym requiring being deleted
                unset($synonymsToDelete[$id]);
                // create if required
                if (empty($existingSynonyms[$id]))
                {
                    $synonym->save(true, false);

                    if ($tagessSynonymRewrite)
                    {
                        $tagIdsToRewrite[$synonym->tag_id] = $synonymTag;
                    }
                }
            }
        }

        if (!$this->hasErrors())
        {
            foreach ($synonymsToDelete as $synonym)
            {
                /** @var TagSynonym $synonym */
                $synonym->delete();
            }

            if ($tagIdsToRewrite)
            {
                $tagIds = array_keys($tagIdsToRewrite);
                foreach ($tagIds as $tagId)
                {
                    // Have to switch the tag within all the content.
                    $db->query("
                        UPDATE IGNORE xf_tag_content
                        SET tag_id = ?
                        WHERE tag_id = ?
                    ", [$this->tag_id, $tagId]);
                    $db->query("DELETE FROM xf_tag_result_cache WHERE tag_id = ?", $tagId);

                    // this handles cases where the content already had the target tag
                    $db->query("DELETE FROM xf_tag_content WHERE tag_id = ?", $tagId);
                    /** @var \XF\Entity\Tag $tag */
                    $tag = $tagIdsToRewrite[$tagId];
                    $tag->fastUpdate('use_count', 0);
                    $tag->fastUpdate('permanent', 1);
                }

                $tagRepo->recalculateTagUsageCache($tagIds);
            }
        }
    }

    /**
     * @return string
     */
    public function getSynonymsForInput()
    {
        $input = [];

        /** @var \AVForums\TagEssentials\Entity\TagSynonym $synonym */
        foreach ($this->Synonyms AS $synonym)
        {
            $input[] = $synonym->Tag->tag;
        }

        return implode(',', $input);
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['tagess_wiki_description'] = ['type' => self::STR, 'default' => null, 'nullable' => true];
        $structure->columns['tagess_wiki_tagline'] = ['type' => self::STR, 'default' => null, 'nullable' => true];
        $structure->columns['allowed_node_ids'] = ['type' => self::LIST_COMMA, 'default' => [],
            'list' => ['type' => 'posint', 'unique' => true, 'sort' => SORT_NUMERIC]
        ];
        $structure->columns['tagess_category_id'] = ['type' => self::STR, 'default' => '', 'maxLength' => 25];
        $structure->columns['tagess_wiki_last_edit_date'] = ['type' => self::INT, 'default' => 0];
        $structure->columns['tagess_wiki_last_edit_user_id'] = ['type' => self::INT, 'default' => 0];
        $structure->columns['tagess_wiki_last_edit_count'] = ['type' => self::INT, 'default' => 0];

        $structure->getters['TopUsers'] = true;
        $structure->getters['SynonymsForInput'] = false;

        $structure->relations['TagCategory'] = [
            'entity' => 'AVForums\TagEssentials:TagCategory',
            'type' => self::TO_ONE,
            'conditions' => [
                ['category_id', '=', '$tagess_category_id']
            ]
        ];

        $structure->relations['SynonymOf'] = [
            'entity' => 'AVForums\TagEssentials:TagSynonym',
            'type' => self::TO_ONE,
            'conditions' => 'tag_id',
            'with' => ['Tag']
        ];

        $structure->relations['Synonyms'] = [
            'entity' => 'AVForums\TagEssentials:TagSynonym',
            'type' => self::TO_MANY,
            'conditions' => [
                ['parent_tag_id', '=', '$tag_id']
            ],
            'with' => ['Tag']
        ];

        $structure->options['synonyms'] = null;
        $structure->defaultWith[] = 'SynonymOf';

        return $structure;
    }
}