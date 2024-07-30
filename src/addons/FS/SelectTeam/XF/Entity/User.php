<?php

namespace FS\SelectTeam\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['team_ids'] =  [
            'type' => self::LIST_COMMA,
            'list' => ['type' => 'posint', 'sort' => SORT_NUMERIC], 'default' => []
        ];

        return $structure;
    }

    public function getImageUrl($id)
    {
        $app = \xf::app();

        $record = $app->em()->find('FS\SelectTeam:Team', $id);

        if ($record) {
            return $record->getImgUrl();
        }

        return '';
    }
}
