<?php

namespace FS\BatchProfile\XF\Entity;

class Thread extends XFCP_Thread
{
    public function getBatchLists()
    {
        $finder = $this->finder('FS\UserGroupBatch:Batch')->where("allow_thread", "=", 1)->fetch();

        return count($finder) ? $finder : '';
    }
}
