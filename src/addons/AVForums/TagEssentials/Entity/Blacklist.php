<?php

namespace AVForums\TagEssentials\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int|null blacklist_id
 * @property string tag
 * @property bool regex
 * @property int blacklisted_date
 * @property int user_id
 *
 * RELATIONS
 * @property \XF\Entity\User User
 */
class Blacklist extends Entity
{
    /**
     * @param Structure $structure
     *
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_tagess_blacklist';
        $structure->shortName = 'AVForums\TagEssentials:Blacklist';
        $structure->primaryKey = 'blacklist_id';
        $structure->columns = [
            'blacklist_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true,
                'unique' => 'avForumsTagEss_tag_is_already_blacklisted'
            ],
            'tag' => ['type' => self::STR, 'required' => true],
            'regex' => ['type' => self::BOOL, 'default' => 0],
            'blacklisted_date' => ['type' => self::UINT, 'default' => \XF::$time],
            'user_id' => ['type' => self::UINT, 'default' => \XF::visitor()->user_id, 'required' => true]
        ];
        $structure->relations = [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
                'primary' => true
            ]
        ];

        return $structure;
    }

    protected function _preSave()
    {
        /** @var \AVForums\TagEssentials\Repository\Blacklist $blacklistRepo */
        $blacklistRepo = $this->repository('AVForums\TagEssentials:Blacklist');
        if (!$blacklistRepo->canBlackListTag($this->tag))
        {
            $this->error(\XF::phrase('avForumsTagEss_tag_is_already_blacklisted'));
        }
    }
}