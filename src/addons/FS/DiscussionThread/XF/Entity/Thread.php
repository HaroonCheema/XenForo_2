<?php

namespace FS\DiscussionThread\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['disc_thread_id'] = ['type' => self::UINT, 'default' => 0];
        $structure->columns['main_thread_ids'] = ['type' => self::LIST_COMMA];

        $structure->relations['DiscThread'] = [
            'entity' => 'XF:Thread',
            'type' => self::TO_ONE,
            'conditions' => [
                ['thread_id', '=', '$disc_thread_id']
            ]
        ];

        return $structure;
    }

    public function canCommentDiscussion()
    {
        if ($this->DiscThread && in_array($this->node_id, \XF::options()->dt_applicable_forums_discussion)) {
            return true;
        }

        return false;
    }
}
