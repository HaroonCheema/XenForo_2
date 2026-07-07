<?php

namespace FS\TagPermissions\XF\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;

class Tag extends XFCP_Tag
{

    public function tagAddEdit(\XF\Entity\Tag $tag)
    {
        $parent = parent::tagAddEdit($tag);

        $userGroups = $this->getUserGroupRepo()->findUserGroupsForList()->fetch();

        $parent->setParam('userGroups', $userGroups);

        return $parent;
    }


    protected function tagSaveProcess(\XF\Entity\Tag $tag)
    {
        $parent = parent::tagSaveProcess($tag);

        $forumInput = $this->filter([
            'fs_usergroup_ids' => 'array',
        ]);

        $parent->complete(function () use ($tag, $forumInput) {
            $tag->fastUpdate('fs_usergroup_ids', $forumInput['fs_usergroup_ids']);
        });

        return $parent;
    }

    protected function getUserGroupRepo()
    {
        return $this->repository('XF:UserGroup');
    }
}
