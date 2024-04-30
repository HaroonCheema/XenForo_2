<?php

namespace FS\DisableBbCodes\XF\Admin\Controller;

use XF\Mvc\ParameterBag;

class BbCode extends XFCP_BbCode
{
    public function actionPermissions(ParameterBag $params)
    {
        $bbCode = $this->assertBbCodeExists($params['bb_code_id']);
        return $this->permissionsAddEdit($bbCode);
    }

    public function permissionsAddEdit(\XF\Entity\BbCode $bbCode)
    {
        $viewParams = [
            'bbCode' => $bbCode,
            'userGroups' => $this->getUserGroupRepo()->findUserGroupsForList()->fetch(),
        ];
        return $this->view('XF:BbCode\PermissionsAddEdit', 'permissions_add_edit', $viewParams);
    }

    public function actionPermissionsSave(ParameterBag $params)
    {
        $bbCode = $this->assertBbCodeExists($params['bb_code_id']);

        if (!$bbCode) {
            return $this->noPermission();
        }

        $input = $this->filter([
            'usergroup_ids' => 'array',
        ]);

        $bbCode->fastUpdate("usergroup_ids", $input["usergroup_ids"]);

        return $this->redirect($this->buildLink('bb-codes'));
    }

    /**
     * @return \XF\Repository\UserGroup
     */
    protected function getUserGroupRepo()
    {
        return $this->repository('XF:UserGroup');
    }
}
