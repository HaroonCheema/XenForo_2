<?php

namespace AVForums\TagEssentials\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int user_id
 * @property int tag_id
 * @property bool send_alert
 * @property bool send_email
 *
 * RELATIONS
 * @property \XF\Entity\User|\AVForums\TagEssentials\XF\Entity\User User
 * @property \XF\Entity\Tag Tag
 */
class TagWatch extends Entity
{
    public function canView()
    {
        return $this->User->canWatchTag();
    }

    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_tagess_tag_watch';
        $structure->shortName = 'AVForums\TagEssentials:TagWatch';
        $structure->primaryKey = ['user_id', 'tag_id'];
        $structure->columns = [
            'user_id' => ['type' => self::UINT, 'required' => true],
            'tag_id' => ['type' => self::UINT, 'required' => true],
            'send_alert' => ['type' => self::BOOL, 'default' => false],
            'send_email' => ['type' => self::BOOL, 'default' => false]
        ];
        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true
            ],
            'Tag' => [
                'entity' => 'XF:Tag',
                'type' => self::TO_ONE,
                'conditions' => 'tag_id',
                'primary' => true
            ]
        ];

        return $structure;
    }
}