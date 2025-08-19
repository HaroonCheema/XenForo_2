<?php

namespace Siropu\AdsManager\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class PromoCode extends Entity
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_ads_manager_promo_code';
          $structure->shortName  = 'AdsManager:PromoCode';
          $structure->primaryKey = 'promo_code';

          $structure->columns = [
               'promo_code'        => ['type' => self::STR, 'maxLength' => 50, 'required' => 'siropu_ads_manager_promo_code_required', 'unique' => 'siropu_ads_manager_promo_code_must_be_unique', 'match' => 'alphanumeric'],
               'value'             => ['type' => self::FLOAT, 'default' => 0],
               'type'              => ['type' => self::STR, 'default' => 'percent'],
               'package'           => ['type' => self::JSON_ARRAY, 'default' => []],
               'invoice_amount'    => ['type' => self::FLOAT, 'default' => 0],
               'active_date'       => ['type' => self::UINT, 'default' => 0],
               'expire_date'       => ['type' => self::UINT, 'default' => 0],
               'user_usage_limit'  => ['type' => self::UINT, 'default' => 0],
               'total_usage_limit' => ['type' => self::UINT, 'default' => 0],
               'user_criteria'     => ['type' => self::JSON_ARRAY, 'default' => []],
               'create_date'       => ['type' => self::UINT, 'default' => \XF::$time],
               'usage_count'       => ['type' => self::UINT, 'default' => 0],
               'enabled'           => ['type' => self::UINT, 'default' => 1]
          ];

          $structure->getters     = [];
          $structure->relations   = [];
          $structure->defaultWith = [];

          return $structure;
     }
     public function canApply($packageId = 0, $amount = 0, &$error = null)
     {
          if (!$this->matchesUserCriteria())
          {
               $error = \XF::phraseDeferred('siropu_ads_manager_promo_code_cannot_be_used_by_you');
               return false;
          }

          if (!$this->enabled || $this->expire_date && $this->expire_date < \XF::$time)
          {
               $error = \XF::phraseDeferred('siropu_ads_manager_promo_code_expired');
               return false;
          }

          if ($this->active_date && $this->active_date > \XF::$time)
          {
               $error = \XF::phraseDeferred('siropu_ads_manager_promo_code_active_on_x',
                    ['date' => \XF::language()->dateTime($this->active_date)]);
               return false;
          }

          if ($this->package && $packageId && !in_array($packageId, $this->package))
          {
               $error = \XF::phraseDeferred('siropu_ads_manager_promo_code_not_applies_to_package');
               return false;
          }

          if ($amount && $this->invoice_amount > $amount)
          {
               $error = \XF::phraseDeferred('siropu_ads_manager_promo_code_not_applicable_for_purchases_less_than_x',
                    ['amount' => $this->getLanguageFormat()]);

               return false;
          }

          if ($this->user_usage_limit)
          {
               $userUsageCount = $this->repository('Siropu\AdsManager:Invoice')
                    ->findInvoicesForList()
                    ->forUser(\XF::visitor()->user_id)
                    ->withPromoCode($this->promo_code)
                    ->total();

               if ($userUsageCount >= $this->user_usage_limit)
               {
                    $error = \XF::phraseDeferred('siropu_ads_manager_promo_code_user_usage_limit_reached',
                         ['limit' => $this->user_usage_limit]);

                    return false;
               }
          }

          return true;
     }
     public function matchesUserCriteria()
     {
          $visitor = \XF::visitor();

          if ($this->app()->criteria('XF:User', $this->user_criteria)->isMatched($visitor))
          {
               return true;
          }
     }
     public function isFree()
     {
          return $this->type == 'percent' && $this->value == 100;
     }
     public function getLanguageFormat()
     {
          $options = \XF::options();
          return \XF::app()->data('XF:Currency')->languageFormat($this->invoice_amount, $options->siropuAdsManagerPreferredCurrency);
     }
     public function getBreadcrumbs($includeSelf = true)
	{
          $breadcrumbs = [
               [
                    'href'  => $this->app()->router()->buildLink('ads-manager/promo-codes'),
                    'value' => \XF::phrase('siropu_ads_manager_promo_codes')
               ]
          ];

          if ($includeSelf)
          {
               $breadcrumbs[] = [
				'href'  => $this->app()->router()->buildLink('ads-manager//promo-codes/edit', $this),
				'value' => $this->promo_code
			];
          }

          return $breadcrumbs;
     }
     protected function _preSave()
     {
          if ($this->total_usage_limit && $this->usage_count >= $this->total_usage_limit)
          {
               $this->enabled = 0;
          }
     }
     protected function verifyValue(&$value)
     {
          if ($this->type == 'percent' && $value > 100)
          {
               $value = 100;
          }

          return true;
     }
     protected function verifyUserCriteria(&$criteria)
     {
          $userCriteria = $this->app()->criteria('XF:User', $criteria);
          $criteria = $userCriteria->getCriteria();
          return true;
     }
}
