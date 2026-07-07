<?php

namespace FS\TagPermissions\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public function getTags()
    {
        if (!$this->tags) {
            return $this->tags;
        }

        $visitor = \XF::visitor();

        // if ($visitor->user_id == 0) {
        //     return [];
        // }

        if ($visitor->user_id == $this->user_id || $visitor->is_admin || $visitor->is_moderator) {
            return $this->tags;
        }

        $newTags = [];

        foreach ($this->tags as $key => $tag) {

            $fetchTag = $this->em()->find('XF:Tag', $key);

            if ($fetchTag && $fetchTag->fs_usergroup_ids) {
                if ($visitor->isMemberOf($fetchTag->fs_usergroup_ids)) {
                    $newTags[$key] = $tag;
                }
            }
        }

        return $newTags;
    }
}
