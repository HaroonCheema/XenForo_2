<?php

namespace FS\HideUsernames\Job;

use XF\Job\AbstractRebuildJob;

class RandomUsername extends AbstractRebuildJob
{
    protected $rebuildDefaultData = [
            'steps' => 0,
            'start' => 0,
            'batch' => 1000,
    ];
    
    
    
    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();
     
        return $db->fetchAllColumn($db->limit("
                SELECT user_id
                FROM xf_user
                WHERE user_id > ?
                ORDER BY user_id
            ", $batch
        ), $start);
    }

    protected function rebuildById($id)
    {
        $user = $this->app->em()->find('XF:User', $id);

        if ($user)
        {
            $length = rand(4, 6); // Generate a random length between 4 and 6

            $randomName = ucwords(substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, $length));

            $user->fastUpdate('random_name', $randomName);
        }
    }

    protected function getStatusType()
    {
        return \XF::phrase('hs_update_random_username_for_users');
    }
    
   
}