<?php

namespace AddonFlare\ForumStats\ForumStat;

use XF\App;

abstract class AbstractForumStat
{
    protected $app;

    protected $forumStat;
    protected $config;

    protected $contextParams = [];

    protected $options;
    protected $defaultOptions = [];

    abstract public function render();

    public function __construct(App $app, \AddonFlare\ForumStats\Entity\ForumStat $forumStat, array $contextParams = [])
    {
        $this->app = $app;
        $this->forumStat = $forumStat;
        $this->config = $forumStat->options;

        $this->contextParams = $contextParams;
        $this->options = $this->setupOptions($this->config);
    }

    protected function setupOptions(array $options)
    {
        return array_replace($this->defaultOptions, $options);
    }

    public function renderOptions()
    {
        $templateName = $this->getOptionsTemplate();
        if (!$templateName)
        {
            return '';
        }
        return $this->app->templater()->renderTemplate(
            $templateName, $this->getDefaultTemplateParams('options')
        );
    }

    /**
     * @return string|null
     */
    public function getOptionsTemplate()
    {
        return 'admin:af_forumstats_def_options_' . $this->forumStat->definition_id;
    }

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        return true;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getCutOffFromDays($days)
    {
        return \XF::$time - $days * 86400;
    }

    /**
     * @return \XF\Finder\Thread
     */
    public function findThreadsWithLatestPosts($cutoff = 0)
    {
        $threadRepo = $this->repository('XF:Thread');

        // same code as \XF\Repository\Thread::findThreadsWithLatestPosts()
        // except we can specifiy the cutoff (defaults to the read marking cutoff)

        return $this->finder('XF:Thread')
            ->with(['Forum', 'User'])
            ->where('Forum.find_new', true)
            ->where('discussion_state', 'visible')
            ->where('discussion_type', '<>', 'redirect')
            ->where('last_post_date', '>', $cutoff > 0 ? $this->getCutOffFromDays($cutoff) : $threadRepo->getReadMarkingCutOff())
            ->order('last_post_date', 'DESC')
            ->indexHint('FORCE', 'last_post_date');
    }

    public function renderer($templateName = '', array $viewParams = [])
    {
        if (!$templateName)
        {
            return '';
        }

        $viewParams = array_replace($this->getDefaultTemplateParams('render'), $viewParams);
        return $this->app->templater->renderTemplate('public:' . $templateName, $viewParams);
    }

    protected function getDefaultTemplateParams($context)
    {
        $config = $this->config;
        return [
            'context' => $this->contextParams,
            'options' => $this->options
        ];
    }

    public function postDelete()
    {
        return;
    }

    public function isAddonActive($addonId)
    {
        $addOns = $this->app()->container('addon.cache');

        return array_key_exists($addonId, $addOns);
    }

    public function ignoreContentAddonIsIgnored(\XF\Mvc\Entity\Entity $entity)
    {
        if (
            $this->ignoreContentAddonIsIgnoredTruonglvIgnoreContent($entity)
            || $this->ignoreContentAddonIsIgnoredThemeHouseIgnoreMore($entity)
        )
        {
            return true;
        }

        return false;
    }

    public function performSafeAddonIsIgnoredCheck(\Closure $check)
    {
        // wrap in try/catch block incase author changes something in their add-on that breaks our code
        try
        {
            if ($check() === true)
            {
                return true;
            }
        }
        catch(\Throwable $t)
        {
            // Executed only in PHP 7, will not match in PHP 5
        }
        catch(\Exception $e)
        {
            // Executed only in PHP 5, will not be reached in PHP 7
        }

        return false;
    }

    public function ignoreContentAddonIsIgnoredTruonglvIgnoreContent(\XF\Mvc\Entity\Entity $entity)
    {
        static $isActive = null;

        if (!isset($isActive))
        {
            $isActive = $this->isAddonActive('Truonglv/IgnoreContent');
        }

        if (!$isActive)
        {
            return false;
        }

        // combine both the Thread and Forum checks here since they just need the node_id
        if (($entity instanceof \XF\Entity\Thread) || ($entity instanceof \XF\Entity\Forum))
        {
            $nodeId = $entity->node_id;

            return $this->performSafeAddonIsIgnoredCheck(function() use ($nodeId)
            {
                if
                (
                    !\Truonglv\IgnoreContent\Listener::isDisabledNode($nodeId) &&
                    \Truonglv\IgnoreContent\Listener::ignoreListData()->isIgnored(\Truonglv\IgnoreContent\Listener::CONTENT_TYPE_FORUM, $nodeId)
                )
                {
                    return true;
                }

                return false;
            });
        }
        else if ($entity instanceof \XFRM\Entity\ResourceItem)
        {

        }

        return false;
    }

    public function ignoreContentAddonIsIgnoredThemeHouseIgnoreMore(\XF\Mvc\Entity\Entity $entity)
    {
        static $isActive = null;

        if (!isset($isActive))
        {
            $isActive = $this->isAddonActive('ThemeHouse/IgnoreMore');
        }

        if (!$isActive)
        {
            return false;
        }

        if (method_exists($entity, 'isThIgnoreMoreIgnoredOnNewsFeed'))
        {
            return $entity->isThIgnoreMoreIgnoredOnNewsFeed();
        }

        return false;
    }

    /**
     * @return App
     */
    public function app()
    {
        return $this->app;
    }

    /**
     * @return \XF\Db\AbstractAdapter
     */
    public function db()
    {
        return $this->app->db();
    }

    /**
     * @return \XF\Mvc\Entity\Manager
     */
    public function em()
    {
        return $this->app->em();
    }

    /**
     * @param string $repository
     *
     * @return \XF\Mvc\Entity\Repository
     */
    public function repository($repository)
    {
        return $this->app->repository($repository);
    }

    /**
     * @param $finder
     *
     * @return \XF\Mvc\Entity\Finder
     */
    public function finder($finder)
    {
        return $this->app->finder($finder);
    }

    /**
     * @param string $finder
     * @param array $where
     * @param string|array $with
     *
     * @return null|\XF\Mvc\Entity\Entity
     */
    public function findOne($finder, array $where, $with = null)
    {
        return $this->app->em()->findOne($finder, $where, $with);
    }

    /**
     * @param string $class
     *
     * @return \XF\Service\AbstractService
     */
    public function service($class)
    {
        return call_user_func_array([$this->app, 'service'], func_get_args());
    }
}