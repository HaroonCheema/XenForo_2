<?php

namespace FS\BatchProfile\XF\Entity;

class User extends XFCP_User
{
    public function getBatchLists()
    {
        $finder = $this->finder('FS\UserGroupBatch:Batch')->where("allow_profile", "=", 1)->fetch();

        return count($finder) ? $finder : '';
    }
}
