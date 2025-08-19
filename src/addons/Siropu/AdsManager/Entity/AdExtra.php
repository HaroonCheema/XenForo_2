<?php

namespace Siropu\AdsManager\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class AdExtra extends Entity
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_ads_manager_ad_extra';
          $structure->shortName  = 'AdsManager:AdExtra';
          $structure->primaryKey = 'ad_id';

          $structure->columns = [
               'ad_id'              => ['type' => self::UINT],
               'active_since'       => ['type' => self::UINT, 'default' => 0],
               'last_change'        => ['type' => self::UINT, 'default' => \XF::$time],
               'last_active'        => ['type' => self::UINT, 'default' => 0],
               'is_placeholder'     => ['type' => self::UINT, 'default' => 0],
               'count_exclude'      => ['type' => self::UINT, 'default' => 0],
               'exclusive_use'      => ['type' => self::BOOL, 'default' => false],
               'is_sticky'          => ['type' => self::BOOL, 'default' => false],
               'purchase'           => ['type' => self::UINT, 'default' => 0],
               'prefix_id'          => ['type' => self::UINT, 'default' => 0],
               'custom_fields'      => ['type' => self::JSON_ARRAY, 'default' => []],
               'promo_code'         => ['type' => self::STR, 'default' => ''],
               'email_notification' => ['type' => self::UINT, 'default' => 0],
               'alert_notification' => ['type' => self::UINT, 'default' => 0],
               'notes'              => ['type' => self::STR, 'default' => ''],
               'pending_changes'    => ['type' => self::JSON_ARRAY, 'default' => []],
               'notice_sent'        => ['type' => self::UINT, 'default' => 0],
               'reject_reason'      => ['type' => self::STR, 'default' => ''],
               'prev_status'        => ['type' => self::STR, 'default' => ''],
               'prev_prefix'        => ['type' => self::UINT, 'default' => 0],
               'advertiser_list'    => ['type' => self::UINT, 'default' => 0]
          ];

          $structure->getters   = [];

          $structure->relations = [
               'Ad' => [
                    'entity'     => 'Siropu\AdsManager:Ad',
                    'type'       => self::TO_ONE,
                    'conditions' => 'ad_id',
                    'primary'    => true
               ],
               'PromoCode' => [
                    'entity'     => 'Siropu\AdsManager:PromoCode',
                    'type'       => self::TO_ONE,
                    'conditions' => 'promo_code'
               ],
               'ThreadPrefix' => [
                    'entity'     => 'XF:ThreadPrefix',
                    'type'       => self::TO_ONE,
                    'conditions' => 'prefix_id'
               ]
          ];

          $structure->defaultWith = [];

          return $structure;
     }
     public function isOfPrevStatus(array $status)
     {
          return in_array($this->prev_status, $status);
     }
     public function hasEmailNotification()
     {
          return $this->email_notification == 1;
     }
     public function hasAlertNotification()
     {
          return $this->alert_notification == 1;
     }
     public function togglePromoThreadOptions()
     {
          if (!$this->Ad->Thread)
          {
               return;
          }

          $threadEditor = \XF::service('XF:Thread\Editor', $this->Ad->Thread);
          $threadEditor->setPrefix($this->Ad->isActive() ? $this->prefix_id : 0);
          $threadEditor->setCustomFields($this->custom_fields);
          $threadEditor->setSticky($this->Ad->isActive() ? $this->is_sticky : 0);
          $threadEditor->setPerformValidations(false);
          $threadEditor->save();
     }
     public function togglePromoThreadForum()
     {
          $expiredThreadForum = \XF::options()->siropuAdsManagerExpiredPromoThreadForum;

          if (!($expiredThreadForum && $this->Ad->Thread))
          {
               return;
          }

          if ($this->Ad->isActive())
          {
               $forum = $this->Ad->Forum;
          }
          else
          {
               $forum = $this->em()->find('XF:Forum', $expiredThreadForum);
          }

          if ($this->Ad->Thread->node_id != $forum->node_id)
          {
               $threadMover = \XF::service('XF:Thread\Mover', $this->Ad->Thread);
               $threadMover->move($forum);
          }
     }
     public function validatePromoCode()
     {
          if ($this->promo_code && !$this->getPromoCodeRepo()->canApplyPromoCode($this->Ad, $this))
          {
               $this->promo_code = '';
          }
     }
     public function validatePromoThread(&$error = null)
     {
          if ($this->Ad->Forum)
          {
               $threadCreator = \XF::service('XF:Thread\Creator', $this->Ad->Forum);
               $threadCreator->setContent($this->Ad->content_2, $this->Ad->content_3);
               $threadCreator->setPrefix($this->prefix_id);
               $threadCreator->setCustomFields($this->custom_fields);
               $threadCreator->setSticky($this->is_sticky);
               $threadCreator->setIsAutomated();

               if (!$threadCreator->validate($error))
               {
                    return false;
               }
          }

          return true;
     }
     public function getCustomFields()
	{
		$fieldDefinitions = $this->app()->container('customFields.threads');
		return new \XF\CustomField\Set($fieldDefinitions, $this);
	}
     protected function verifyCustomFields(&$customFields)
     {
          $customFields = array_filter($customFields);
          return true;
     }
     protected function _preSave()
     {
          if ($this->isChanged('promo_code'))
          {
               $this->validatePromoCode();
          }
     }
     protected function _postSave()
     {
          if ($this->isChanged('promo_code') && $this->promo_code && $this->PromoCode)
          {
               $this->PromoCode->usage_count++;
               $this->PromoCode->save();
          }

          if ($this->isChanged('count_exclude') && $this->count_exclude)
          {
               $this->getPackageRepo()->updateEmptySlotCount($this->Ad->package_id);
          }

          if ($this->Ad->isThread())
          {
               $promoThreadService = \XF::service('Siropu\AdsManager:Ad\PromoThreadManager', $this->Ad);
               $promoThreadService->setPrefix($this->prefix_id);
               $promoThreadService->setCustomFields($this->custom_fields);
               $promoThreadService->setSticky($this->is_sticky);
               $promoThreadService->save();
          }
     }
     protected function _postDelete()
     {
          if ($this->Ad->isThread())
          {
               $this->togglePromoThreadForum();
               $this->togglePromoThreadOptions();
          }
     }
     public function getAdRepo()
     {
          return $this->repository('Siropu\AdsManager:Ad');
     }
     public function getPackageRepo()
     {
          return $this->repository('Siropu\AdsManager:Package');
     }
     public function getPromoCodeRepo()
     {
          return $this->repository('Siropu\AdsManager:PromoCode');
     }
}
