<?php

namespace Siropu\ReferralSystem\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class RewardType extends Entity
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_referral_system_reward_type';
          $structure->shortName  = 'ReferralSystem:RewardType';
          $structure->primaryKey = 'reward_type_id';

          $structure->columns = [
               'reward_type_id' => ['type' => self::UINT, 'autoIncrement' => true],
               'name'           => ['type' => self::STR, 'required' => 'please_enter_valid_name'],
               'type'           => ['type' => self::STR, 'default' => 'trophy_points'],
               'currency'       => ['type' => self::STR, 'default' => '']
          ];

          $structure->options = [
               'reward_amount' => 0
          ];

          $structure->getters = [
               'type_phrase' => true
          ];

          return $structure;
     }
     public function getTypePhrase()
     {
          return \XF::phrase('siropu_referral_system_reward_type.' . $this->type);
     }
     public function isTrophyPoints()
     {
          return $this->type == 'trophy_points';
     }
     public function isDbTechCredits()
     {
          return $this->type == 'dbtech_credits';
     }
     public function applyTrophyPoints($user, $action = 'siropu_rs_referral_reg_reward')
     {
          $rewardAmount    = $this->getOption('reward_amount');
          $rewardsReceived = $user->siropu_rs_referral_rewards;

          $rewardsReceived[$this->reward_type_id] = $rewardAmount;

          $user->fastUpdate([
               'trophy_points'              => $user->trophy_points + $rewardAmount,
               'siropu_rs_referral_rewards' => $rewardsReceived
          ]);

          $this->repository('XF:UserAlert')->alert(
               $user,
               $user->user_id,
               $user->username,
               'user',
               $user->user_id,
               $action,
               [
                    'trophyPoints' => $rewardAmount
               ]
          );
     }
     public function applyDbTechCredits($user, $phrase = 'siropu_referral_system_reward_for_referring_new_member')
     {
          $addon = $this->em()->find('XF:AddOn', 'DBTech/Credits');

          if (!$addon)
          {
               return;
          }

          $message         = \XF::phrase($phrase)->render();
          $rewardAmount    = $this->getOption('reward_amount');
          $rewardsReceived = $user->siropu_rs_referral_rewards;

          $rewardsReceived[$this->reward_type_id] = $rewardAmount;

          if ($addon->version_id >= 905010031)
          {
               $admin = \XF::finder('XF:Admin')
                    ->where('is_super_admin', 1)
                    ->fetchOne();

               $eventTriggerRepo = \XF::repository('DBTech\Credits:EventTrigger');
               $adjustHandler = $eventTriggerRepo->getHandler('adjust');
               $adjustHandler->apply($user->user_id, [
                    'currency_id' 	  => $this->currency,
                    'multiplier' 	  => $rewardAmount,
                    'message'        => $message,
                    'source_user_id' => $admin->user_id,
               ], $user);
          }
          else
          {
               $adjust = \DBTech\Credits\Application\App::em()->findOne('DBTech\Credits:EventTrigger', 'adjust');
               $adjustEvent = $adjust->getClass();
               $adjustEvent->apply(
                    $user->user_id,
                    $this->currency,
                    $rewardAmount,
                    $message,
                    \XF::visitor()->user_id
               );
          }

          $user->fastUpdate('siropu_rs_referral_rewards', $rewardsReceived);
     }
}
