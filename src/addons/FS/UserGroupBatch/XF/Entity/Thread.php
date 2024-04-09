<?php

namespace FS\UserGroupBatch\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->relations += [
            'UserPost' => [
                'entity' => 'XF:ThreadUserPost',
                'type' => self::TO_ONE,
                'conditions' => 'thread_id',
                'key' => 'user_id'
            ],
        ];

        return $structure;
    }

    public function getBatchLists()
    {
        $finder = $this->finder('FS\UserGroupBatch:Batch')->fetch();

        return count($finder) ? $finder : '';
    }

    public function getBatchDetails($batch)
    {
        $visitor = \XF::visitor();

        if ($visitor->isMemberOf($batch->usergroup_ids)) {
            $size = $batch->type_repeat;
            $imgRepeat = [];

            // Generate the array
            for ($i = 0; $i < $size; $i++) {
                $imgRepeat[$i] = $i + 1;
            }

            return count($imgRepeat) ? $imgRepeat : '';
        }

        return '';
    }
}
