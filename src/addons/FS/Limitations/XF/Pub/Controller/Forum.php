<?php

namespace FS\Limitations\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Forum extends XFCP_Forum
{
    public function actionPostThread(ParameterBag $params)
    {
        $visitor = \XF::visitor();
        
        $visitorDailyDiscussionCount = $visitor->daily_discussion_count;
        $dailyDiscussionLimit = $visitor->hasPermission('fs_limitations', 'fs_dailyDiscussiontLimit');
       
        // -------------------------- Check Daily Post Limits --------------------------

        if ( ($dailyDiscussionLimit >= 0) && $visitorDailyDiscussionCount >= $dailyDiscussionLimit)
        {
            
            $accountType = $visitor->account_type;
            
            if($accountType == 1)
            {
                $upgradeUrl = $this->buildLink('account-upgrade/admirer');
            }
            elseif($accountType == 2) 
            {
                $upgradeUrl = $this->buildLink('account-upgrade/companion');
            }
            else
            {
                $upgradeUrl = $this->buildLink('account-upgrade');
            }
            
            
            
            if($dailyDiscussionLimit == 0)
                throw $this->exception($this->notFound(\XF::phrase('fs_l_discussion_not_allowed_please_upgrade',['upgradeUrl'=> $upgradeUrl])));
            
            $params = [
                'visitorDailyDiscussionCount' => $visitorDailyDiscussionCount,
                'dailyDiscussionLimit'   => $dailyDiscussionLimit,
                'upgradeUrl' => $upgradeUrl
            ];

            throw $this->exception($this->notFound(\XF::phrase('fs_l_daily_discussion_limit_reached_please_upgrade',$params)));
        }
        
        return parent::actionPostThread($params);
    }
}
