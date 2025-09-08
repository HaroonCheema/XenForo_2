<?php

namespace XenGenTr\XGTForumistatistik\XF\Entity;

class Thread extends XFCP_Thread
{
    public function getLastPostCache()
    {
        $cache = parent::getLastPostCache();

        $userRepo = $this->getUserRepo();

        $user = $this->em()->find('XF:User', $cache['user_id']);

        $cache['display_style_group_id'] = $user['display_style_group_id'];

        return $cache;
    }

    protected function getUserRepo()
    {
        return $this->repository('XF:User');
    }
}
