<?php

namespace FS\DisableBbCodes\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class DisableBbCodes extends AbstractController
{
    public function actionIndex(ParameterBag $params)
    {
        $finder = $this->finder('FS\DisableBbCodes:DisableBbCodes')->order('id', 'DESC');

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

        return $this->view('FS\DisableBbCodes:DisableBbCodes\Index', 'fs_disable_bb_code_index', $viewParams);
    }

    public function actionPermissions(ParameterBag $params)
    {
        /** @var \FS\DisableBbCodes\Entity\DisableBbCodes $bbCode */

        $bbCode = $this->assertDataExists($params['id']);
        return $this->permissionsAddEdit($bbCode);
    }

    public function permissionsAddEdit(\FS\DisableBbCodes\Entity\DisableBbCodes $bbCode)
    {
        $viewParams = [
            'bbCode' => $bbCode,
            'userGroups' => $this->getUserGroupRepo()->findUserGroupsForList()->fetch(),
        ];
        return $this->view('FS\DisableBbCodes:DisableBbCodes\PermissionsAddEdit', 'fs_dis_permissions_add_edit', $viewParams);
    }

    public function actionPermissionsSave(ParameterBag $params)
    {
        $bbCode = $this->assertDataExists($params['id']);

        if (!$bbCode) {
            return $this->noPermission();
        }

        $input = $this->filter([
            'usergroup_ids' => 'array',
        ]);

        $bbCode->fastUpdate("usergroup_ids", $input["usergroup_ids"]);

        return $this->redirect($this->buildLink('dis-bb-codes'));
    }

    /**
     * @return \XF\Repository\UserGroup
     */
    protected function getUserGroupRepo()
    {
        return $this->repository('XF:UserGroup');
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\UpgradeUserGroup\Entity\UpgradeUserGroup
     */
    protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\DisableBbCodes:DisableBbCodes', $id, $extraWith, $phraseKey);
    }
}
