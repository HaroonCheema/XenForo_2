<?php

namespace Siropu\ReferralSystem\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
     protected $referralMonitor = false;

     public static function getStructure(Structure $structure)
	{
		$structure = parent::getStructure($structure);

          $structure->columns['siropu_rs_referrer_id'] = ['type' => self::UINT, 'default' => 0, 'changeLog' => false];
		$structure->columns['siropu_rs_referral_count'] = ['type' => self::UINT, 'default' => 0, 'forced' => true, 'changeLog' => false];
          $structure->columns['siropu_rs_referral_rewards'] = [
               'type' => self::JSON_ARRAY, 'default' => [], 'nullable' => true, 'changeLog' => false];
		$structure->columns['siropu_rs_referrer_credit'] = ['type' => self::UINT, 'default'  => 0, 'changeLog' => false];

		$structure->relations['SRS_Referrer'] = [
			'entity'     => 'XF:User',
			'type'       => self::TO_ONE,
			'conditions' => [['user_id', '=', '$siropu_rs_referrer_id']]
		];

          $structure->relations['SRS_Referrals'] = [
			'entity'     => 'XF:User',
			'type'       => self::TO_MANY,
			'conditions' => [['siropu_rs_referrer_id', '=', '$user_id']],
               'key'        => 'user_id'
		];

          $structure->options['SRS_ActionInit'] = false;

          return $structure;
     }
     public function getReferralRewardTypeIfValid($rewardTypeId, $rewardAmount)
     {
          $rewardLimit = $this->hasPermission('siropuReferralSystem', 'referralRewardLimit');
          $typeLimit   = !empty($this->siropu_rs_referral_rewards[$rewardTypeId]) ? $this->siropu_rs_referral_rewards[$rewardTypeId] : 0;

          if ($rewardLimit > 0 && $typeLimit >= $rewardLimit)
          {
               return;
          }

          if ($rewardTypeId)
          {
               $rewardType = $this->em()->find('Siropu\ReferralSystem:RewardType', $rewardTypeId);

               if ($rewardType)
               {
                    $rewardType->setOption('reward_amount', $rewardAmount);
               }

               return $rewardType;
          }
     }
     public function getReferralRegistrationReward()
     {
          $rewardAmount = $this->hasPermission('siropuReferralSystem', 'referralRegRewardAmount');

          if ($rewardAmount > 0)
          {
               $rewardTypeId = \XF::options()->siropuReferralSystemReferralRegistrationReward;
               return $this->getReferralRewardTypeIfValid($rewardTypeId, $rewardAmount);
          }
     }
     public function getReferralUpgradeReward()
     {
          $rewardAmount = $this->hasPermission('siropuReferralSystem', 'referralUpgRewardAmount');

          if ($rewardAmount > 0)
          {
               $rewardTypeId = \XF::options()->siropuReferralSystemReferralUpgradeReward;
               return $this->getReferralRewardTypeIfValid($rewardTypeId, $rewardAmount);
          }
     }
     public function updateReferralCountAndNotify(\XF\Entity\User $referral)
     {
          $this->fastUpdate('siropu_rs_referral_count', $this->siropu_rs_referral_count + 1);

          $this->repository('XF:UserAlert')->alert(
               $this,
               $referral->user_id,
               $referral->username,
               'user',
               $referral->user_id,
               'siropu_rs_new_referral'
          );
     }
     protected function _preSave()
     {
          parent::_preSave();

          if ($this->isInsert())
          {
               $referrer = $this->getReferrerRepo()->getValidReferrer();

               if ($referrer)
               {
                    $this->siropu_rs_referrer_id = $referrer->user_id;
               }
          }
     }
     protected function _postSave()
     {
          parent::_postSave();

          if ($this->siropu_rs_referrer_id && !$this->getOption('SRS_ActionInit'))
          {
               $this->setOption('SRS_ActionInit', true);

               $referrer = $this->SRS_Referrer;

               if ($this->isInsert())
               {
                    \XF::app()->response()->setCookie('referrer_id', false);

                    /** @var \XF\Repository\Ip $ipRepo */
                    $ipRepo = \XF::repository('XF:Ip');
                    $parsed = \XF\Util\Ip::parseIpRangeString(\XF::app()->request()->getIp(true));

                    if ($parsed)
                    {
                         $ips = $ipRepo->getUsersByIp($parsed['startRange']);

                         if (isset($ips[$referrer->user_id]))
                         {
                              $superAdmins = \XF::finder('XF:Admin')
                                   ->where('is_super_admin', 1)
                                   ->fetch();

                              foreach ($superAdmins as $admin)
                              {
                                   $this->repository('XF:UserAlert')->alert(
                                        $admin->User,
                                        $this->user_id,
                                        $this->username,
                                        'user',
                                        $this->user_id,
                                        'siropu_rs_referral_dupe',
                                        [
                                             'referrer' => [
                                                  'username' => $referrer->username,
                                                  'user_id'  => $referrer->user_id
                                             ]
                                        ]
                                   );
                              }
                         }
                    }
               }

               if ($this->user_state == 'valid'
                    && ($this->isInsert() || in_array($this->getPreviousValue('user_state'), ['email_confirm', 'moderated'])))
               {
                    $this->getReferrerRepo()->creditReferrerIfValidReferral($referrer, $this, true);

                    $this->followReferrer($referrer);
               }
          }
     }
     protected function _postDelete()
     {
          parent::_postDelete();

          $referrer = $this->SRS_Referrer;

          if ($referrer && $referrer->siropu_rs_referral_count > 0)
          {
               $referrer->fastUpdate('siropu_rs_referral_count', $referrer->siropu_rs_referral_count - 1);
          }

          if ($this->siropu_rs_referral_count)
          {
               $this->db()->update('xf_user', ['siropu_rs_referrer_id' => 0], 'siropu_rs_referrer_id = ?', $this->user_id);
          }
     }
     public function followReferrer(\XF\Entity\User $followUser)
	{
          $options = \XF::options();

          if ($options->siropuReferralSystemReferrerAutoFollow && !$this->isFollowing($followUser))
          {
               \XF::service('XF:User\Follow', $followUser, $this)->follow();
          }
	}
     public function getReferrerRepo()
     {
          return $this->repository('Siropu\ReferralSystem:Referrer');
     }
}
