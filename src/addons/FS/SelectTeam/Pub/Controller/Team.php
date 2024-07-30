<?php

namespace FS\SelectTeam\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class Team extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        $visitor = \XF::visitor();

        if (!$visitor->user_id) {
            throw $this->noPermission();
        }

        $data = $this->Finder('FS\SelectTeam:Team')->fetch();

        $viewpParams = [
            'pageSelected' => 'team/',
            'data' => $data,
        ];

        return $this->view('FS\SelectTeam:Index', 'fs_team_index', $viewpParams);
    }

    public function actionSave()
    {
        $options = \XF::options();
        $visitor = \XF::visitor();

        if (!$visitor->user_id) {
            throw $this->noPermission();
        }

        $input = $this->filter([
            'team_ids' => 'array',
        ]);

        if (count($input['team_ids']) > intval($options->fs_teams_total) || !count($input['team_ids'])) {
            throw $this->exception($this->error(\XF::phrase('fs_teams_you_can_select', ['count_teams' => $options->fs_teams_total])));
        }

        $visitor->fastUpdate("team_ids", $input["team_ids"]);

        return $this->redirect($this->buildLink('team/'));
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\SelectTeam\Entity\Team
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\SelectTeam:Team', $id, $extraWith, $phraseKey);
    }
}
