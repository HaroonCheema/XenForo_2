<?php

namespace BS\AIBots\Admin\Controller;

use BS\AIBots\Service\Bot\Creator;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class Bot extends AbstractController
{
    public function actionIndex()
    {
        $page = $this->filterPage();
        $perPage = 25;

        /** @var \BS\AIBots\Repository\Bot $botRepo */
        $botRepo = $this->repository('BS\AIBots:Bot');
        $botFinder = $botRepo->findBots()
            ->limitByPage($page, $perPage);
        $total = $botFinder->total();

        $this->assertValidPage($page, $perPage, $total, 'ai-bots');

        $bots = $botFinder->fetch();
        $groupedBots = $bots->groupBy('bot_class');
        $handlers = $botRepo->getBotHandlers();

        $viewParams = compact('bots', 'groupedBots', 'handlers', 'page', 'perPage', 'total');
        return $this->view('BS\AIBots:Bot\List', 'bs_ai_bot_list', $viewParams);
    }

    protected function botAddEdit(\BS\AIBots\Entity\Bot $bot)
    {
        $userGroups = $this->repository('XF:UserGroup')->getUserGroupTitlePairs();
        $handlers = $this->repository('BS\AIBots:Bot')->getBotHandlers();
        $viewParams = compact('bot', 'userGroups', 'handlers');
        return $this->view('BS\AIBots:Bot\Edit', 'bs_ai_bot_edit', $viewParams);
    }

    public function actionAdd()
    {
        $bot = $this->em()->create('BS\AIBots:Bot');
        return $this->botAddEdit($bot);
    }

    public function actionEdit(ParameterBag $params)
    {
        $bot = $this->assertBotExists($params->bot_id);
        return $this->botAddEdit($bot);
    }

    protected function setupBotCreate()
    {
        /** @var \BS\AIBots\Service\Bot\Creator $creator */
        $creator = $this->service('BS\AIBots:Bot\Creator');
        $this->setupBotCreatorEditor($creator, true);
        return $creator;
    }

    protected function setupBotEdit(\BS\AIBots\Entity\Bot $bot)
    {
        /** @var \BS\AIBots\Service\Bot\Creator $editor */
        $editor = $this->service('BS\AIBots:Bot\Editor', $bot);
        $this->setupBotCreatorEditor($editor);
        return $editor;
    }

    protected function setupBotCreatorEditor(
        Creator $creatorEditor,
        bool $createMode = false
    ) {
        $input = $this->botInput($createMode);
        $creatorEditor->setIsActive($input['is_active'])
            ->setExtraUserGroupIds($input['extra_user_group_ids'])
            ->setBotClass($input['bot_class'])
            ->setRestrictions($input['restrictions'])
            ->setTriggers($input['triggers'])
            ->setGeneral($input['general']);

        if ($createMode) {
            $creatorEditor->setUsername($input['username']);
        }

        return $creatorEditor;
    }

    protected function botInput(bool $createMode = false): array
    {
        $filter = [
            'is_active' => 'bool',
            'extra_user_group_ids' => 'array-uint',
            'general' => 'array',
            'triggers' => 'array',
            'restrictions' => 'array',
            'bot_class' => 'str',
        ];

        if ($createMode) {
            $filter['username'] = 'str';
        }

        return $this->filter($filter);
    }

    public function actionSave(ParameterBag $params)
    {
        $this->assertPostOnly();

        /** @var \BS\AIBots\Entity\Bot $bot */
        $bot = $params->bot_id
            ? $this->assertBotExists($params->bot_id)
            : $this->em()->create('BS\AIBots:Bot');

        $creatorEditor = $bot->isInsert()
            ? $this->setupBotCreate()
            : $this->setupBotEdit($bot);

        if (! $creatorEditor->validate($errors)) {
            return $this->error($errors);
        }

        $creatorEditor->save();

        return $this->redirect($this->buildLink('ai-bots'));
    }

    public function actionDelete(ParameterBag $params)
    {
        $bot = $this->assertBotExists($params->bot_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $bot,
            $this->buildLink('ai-bots/delete', $bot),
            $this->buildLink('ai-bots/edit', $bot),
            $this->buildLink('ai-bots'),
            $bot->username
        );
    }

    public function actionToggle()
    {
        $plugin = $this->plugin('XF:Toggle');
        return $plugin->actionToggle('BS\AIBots:Bot', 'is_active');
    }

    public function actionTabs(ParameterBag $params)
    {
        $botRepo = $this->getBotRepo();

        $class = $this->filter('bot_class', 'str');
        if (! $botRepo->isValidBotClass($class)) {
            return $this->notFound();
        }

        /** @var \BS\AIBots\Entity\Bot $bot */
        $bot = $params->bot_id
            ? $this->assertBotExists($params->bot_id)
            : $this->em()->create('BS\AIBots:Bot');

        $handler = $bot->getHandler($class);
        if (!$handler) {
            return $this->notFound();
        }

        $handler->setupDefaults();

        $templateData = $handler->getTabPanesTemplateData();

        if (empty($templateData)) {
            return $this->view('BS\AIBots:Bot\Template', '');
        }

        $viewParams = array_merge([
            'bot' => $bot,
        ], $templateData['params']);

        $view = $this->view('BS\AIBots:Bot\Template', $templateData['template'], $viewParams);
        $view->setJsonParam('tabs', $handler->getTabs());
        return $view;
    }

    /**
     * @param $id
     * @param $with
     * @param $phraseKey
     * @return \XF\Mvc\Entity\Entity|\BS\AIBots\Entity\Bot
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function assertBotExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('BS\AIBots:Bot', $id, $with, $phraseKey);
    }

    /**
     * @return \BS\AIBots\Repository\Bot
     */
    protected function getBotRepo()
    {
        return $this->repository('BS\AIBots:Bot');
    }
}