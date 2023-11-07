<?php

namespace FS\HideUsernames\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{

    public function getUsername()
    {
        $username = $this->username_;
        $user_id = $this->user_id_;
        $randomName = $this->random_name_;

            // return $username;

        $visitor = \XF::visitor();

        if (!$visitor->user_id) {
            return $randomName;
        }

        if ($visitor->user_id == $user_id) {
            return $username;
        }

        if (!\xf::visitor()->hasPermission('fs_user_names', 'hide')) {
            return $username;
        }

        $options = $this->app()->options();

        $userIds = explode(",", $options->fs_unhide_user_ids);

        if (in_array($visitor->user_id, $userIds)) {
            return $username;
        }

        return $randomName;
    }

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['random_name'] =  ['type' => self::STR, 'default' => null];

        $structure->getters += [
            'username' => ['getter' => 'getUsername', 'cache' => false],
        ];

        return $structure;
    }
}
