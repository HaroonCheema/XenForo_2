<?php

namespace FS\GameReviews\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class Game extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\GameReviews:Game')->order('game_id', 'DESC');

        $page = $params->page;
        $perPage = 15;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'data' => $finder->fetch(),

            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),

            'totalReturn' => count($finder->fetch()),
        ];

        return $this->view('FS\GameReviews:Game\Index', 'fs_game_index', $viewParams);
    }

    public function actionAdd()
    {
        $emptyData = $this->em()->create('FS\GameReviews:Game');
        return $this->actionAddEdit($emptyData);
    }

    public function actionEdit(ParameterBag $params)
    {
        /** @var \FS\GameReviews\Entity\game $data */
        $data = $this->assertDataExists($params->game_id);

        return $this->actionAddEdit($data);
    }

    public function actionAddEdit(\FS\GameReviews\Entity\game $data)
    {

        $viewParams = [
            'data' => $data,
        ];

        return $this->view('FS\GameReviews:Game\Add', 'fs_game_add_edit', $viewParams);
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->game_id) {
            $dataEditAdd = $this->assertDataExists($params->game_id);
        } else {
            $dataEditAdd = $this->em()->create('FS\GameReviews:Game');
        }

        $this->dataSaveProcess($dataEditAdd)->run();

        return $this->redirect($this->buildLink('game'));
    }

    protected function dataSaveProcess(\FS\GameReviews\Entity\game $data)
    {
        $input = $this->filterInputs();

        $form = $this->formAction();
        $form->basicEntitySave($data, $input);

        return $form;
    }

    protected function filterInputs()
    {
        $input = $this->filter([
            'title' => 'str',
            'description' => 'str',
        ]);

        if ($input['title'] == '') {
            throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
        }

        return $input;
    }

    public function actionDelete(ParameterBag $params)
    {
        $replyExists = $this->assertDataExists($params->game_id);

        /** @var \XF\ControllerPlugin\Delete $plugin */
        $plugin = $this->plugin('XF:Delete');
        return $plugin->actionDelete(
            $replyExists,
            $this->buildLink('game/delete', $replyExists),
            null,
            $this->buildLink('game'),
            "{$replyExists->title}"
        );
    }

    /**
     * @param string $game_id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\GameReviews\Entity\Game
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\GameReviews:Game', $id, $extraWith, $phraseKey);
    }
}
