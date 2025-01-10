<?php

namespace BS\AIBots\Bot;

use BS\AIBots\Entity\Bot;

abstract class AbstractBot implements IBot
{
    /**
     * @var \XF\App
     */
    protected $app;

    protected Bot $bot;

    public function __construct(\XF\App $app, Bot $bot)
    {
        $this->app = $app;
        $this->bot = $bot;
        $this->setup();
    }

    protected function setup(): void
    {
    }

    public function verifyGeneral(array &$general): void
    {
    }

    public function verifyRestrictions(array &$restrictions): void
    {
    }

    public function verifyTriggers(array &$triggers): void
    {
    }

    public function getTabs(): array
    {
        return [];
    }

    public function renderTabPanes(): string
    {
        $extend = $this->getTabPanesTemplateData();
        if (empty($extend)) {
            return '';
        }

        $this->appendDefaultsToExtendTemplate($extend);

        return $this->app->templater()->renderTemplate(
            $extend['template'],
            $extend['params']
        );
    }

    public function getTabPanesTemplateData(): array
    {
        return [];
    }

    protected function appendDefaultsToExtendTemplate(array &$extend)
    {
        // Add template type for templater
        if (0 !== strpos($extend['template'], 'admin:')) {
            $extend['template'] = 'admin:'.$extend['template'];
        }

        $extend['params']['bot'] = $this->bot;
    }

    public function setupDefaults(): void
    {
    }

    /**
     * @return \XF\Db\AbstractAdapter
     */
    protected function db()
    {
        return $this->app->db();
    }

    /**
     * @return \XF\Mvc\Entity\Manager
     */
    protected function em()
    {
        return $this->app->em();
    }

    /**
     * @param string $repository
     *
     * @return \XF\Mvc\Entity\Repository
     */
    protected function repository($repository)
    {
        return $this->app->repository($repository);
    }

    /**
     * @param $finder
     *
     * @return \XF\Mvc\Entity\Finder
     */
    protected function finder($finder)
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
    protected function findOne($finder, array $where, $with = null)
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

    /**
     * @return \ArrayObject
     */
    public function options()
    {
        return $this->app->options();
    }
}