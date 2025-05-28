<?php

namespace Siropu\ReferralSystem\XF\Entity;

class Post extends XFCP_Post
{
     protected function adjustUserMessageCountIfNeeded($amount)
     {
          parent::adjustUserMessageCountIfNeeded($amount);

          $minimumPosts = \XF::options()->siropuReferralSystemRewardMinPosts;

          if ($this->user_id
               && $this->User
               && $minimumPosts
               && !empty($this->Thread->Forum->count_messages)
               && $this->Thread->discussion_state == 'visible'
               && $this->User->siropu_rs_referrer_id
               && !$this->User->siropu_rs_referrer_credit
               && $this->User->message_count + 1 >= $minimumPosts
               && $this->User->SRS_Referrer
               && $this->User->SRS_Referrer->hasPermission('siropuReferralSystem', 'referralRegRewardAmount') > 0)
          {
               $this->getReferrerRepo()->creditReferrerIfValidReferral($this->User->SRS_Referrer, $this->User);
          }
     }
     public function getReferrerRepo()
     {
          return $this->repository('Siropu\ReferralSystem:Referrer');
     }
}
