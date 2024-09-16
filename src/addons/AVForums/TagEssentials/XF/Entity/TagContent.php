<?php

namespace AVForums\TagEssentials\XF\Entity;

use XF\Mvc\Entity\Structure;

/**
 * Class TagContent
 *
 * Extends \XF\Entity\TagContent
 *
 * @package AVForums\TagEssentials\XF\Entity
 *
 * RELATIONS
 * @property \XF\Entity\User AddUser
 */
class TagContent extends XFCP_TagContent
{
    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->relations['AddUser'] = [
            'entity' => 'XF:User',
            'type' => self::TO_ONE,
            'conditions' => [
                ['user_id', '=', '$add_user_id']
            ],
            'primary' => true
        ];

        return $structure;
    }
}