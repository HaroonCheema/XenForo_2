<?php

namespace XenGenTr\XGTForumistatistik\Widget;

use XF\App;

abstract class AbstractForumIstatistik
{
	/**
	 * @var App
	 */
    protected $app;

	/**
	 * @var WidgetConfig
	 */
    protected $forumIstatistik;
    protected $config;

    protected $contextParams = [];

    protected $options;
    protected $defaultOptions = [];

    abstract public function render();

    public function __construct(App $app, \XenGenTr\XGTForumistatistik\Entity\ForumIstatistik $forumIstatistik, array $contextParams = [])
    {
        $this->app = $app;
        $this->forumIstatistik = $forumIstatistik;
        $this->config = $forumIstatistik->options;
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
        return 'admin:xgt_forumistatistik_acp_opsiyon_' . $this->forumIstatistik->icerik_id;
    }

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        return true;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function findThreadsWithLatestPosts()
    {
        $threadRepo = $this->repository('XF:Thread');
        return $this->finder('XF:Thread')
            ->with(['Forum', 'User'])
            ->where('Forum.find_new', true)
            ->where('discussion_state', 'visible')
            ->where('discussion_type', '<>', 'redirect')
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