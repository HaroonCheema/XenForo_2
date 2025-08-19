<?php

namespace Siropu\AdsManager\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use XF\Payment\AbstractProvider;

class Invoice extends Entity
{
     public static function getStructure(Structure $structure)
	{
          $structure->table      = 'xf_siropu_ads_manager_invoice';
          $structure->shortName  = 'AdsManager:Invoice';
          $structure->primaryKey = 'invoice_id';

          $structure->columns = [
               'invoice_id'         => ['type' => self::UINT, 'autoIncrement' => true],
               'child_ids'          => ['type' => self::LIST_COMMA, 'default' => [],
                    'list' => ['type' => 'posint', 'unique' => true, 'sort' => SORT_NUMERIC]
               ],
               'ad_id'              => ['type' => self::UINT, 'default' => 0],
               'user_id'            => ['type' => self::UINT, 'default' => \XF::visitor()->user_id],
               'username'           => ['type' => self::STR, 'default' => \XF::visitor()->username],
               'cost_amount'        => ['type' => self::FLOAT, 'default' => 0],
               'cost_currency'      => ['type' => self::STR, 'default' => 'USD'],
               'length_amount'      => ['type' => self::UINT, 'default' => 1],
			'length_unit'        => ['type' => self::STR, 'default' => '',
                    'allowedValues' => ['day', 'week', 'month', 'year', 'cpm', 'cpc', '']],
               'promo_code'         => ['type' => self::STR, 'default' => ''],
               'create_date'        => ['type' => self::UINT, 'default' => \XF::$time],
               'complete_date'      => ['type' => self::UINT, 'default' => 0],
               'payment_profile_id' => ['type' => self::STR, 'default' => 0],
               'recurring'          => ['type' => self::UINT, 'default' => 0],
               'marked_as_paid'     => ['type' => self::UINT, 'default' => 0],
               'invoice_file'       => ['type' => self::STR, 'default' => ''],
               'status'             => ['type' => self::STR, 'default' => 'pending']
          ];

          $structure->getters = [
               'cost_phrase' => true,
               'purchasable_type_id' => true
          ];

          $structure->relations   = [
               'Ad' => [
                    'entity'     => 'Siropu\AdsManager:Ad',
                    'type'       => self::TO_ONE,
                    'conditions' => 'ad_id'
               ],
               'PaymentProfile' => [
                    'entity'     => 'XF:PaymentProfile',
                    'type'       => self::TO_ONE,
                    'conditions' => 'payment_profile_id'
               ],
               'User' => [
                    'entity'     => 'XF:User',
                    'type'       => self::TO_ONE,
                    'conditions' => 'user_id'
               ],
               'PromoCode' => [
                    'entity'     => 'Siropu\AdsManager:PromoCode',
                    'type'       => self::TO_ONE,
                    'conditions' => 'promo_code'
               ]
          ];

          $structure->options = [
               'admin_edit' => false
          ];

          $structure->defaultWith = [];

          return $structure;
     }
     public function isPending()
     {
          return $this->status == 'pending';
     }
     public function isCompleted()
     {
          return $this->status == 'completed';
     }
     public function isCancelled()
     {
          return $this->status == 'cancelled';
     }
     public function canPay()
     {
          return $this->user_id == \XF::visitor()->user_id;
     }
     public function getCostPhrase()
     {
          return $this->app()->data('XF:Currency')->languageFormat($this->cost_amount, $this->cost_currency);
     }
     public function getBreadcrumbs()
	{
          return [
               [
                    'href'  => $this->app()->router()->buildLink('ads-manager/invoices'),
                    'value' => \XF::phrase('siropu_ads_manager_invoices')
               ]
          ];
     }
     public function getPurchasableTypeId()
     {
          return 'advertising';
     }
     public function getInvoiceFilePath()
     {
          return "data://siropu/am/invoice/{$this->invoice_id}/{$this->invoice_file}";
     }
     public function getChildList()
     {
          return $this->finder('Siropu\AdsManager:Invoice')->where('invoice_id', $this->child_ids)->fetch();
     }
     protected function _preSave()
     {
          if ($this->isChanged('status'))
          {
               switch ($this->status)
               {
                    case 'completed':
                         $this->complete_date = \XF::$time;
                         break;
                    case 'pending':
                    case 'cancelled':
                         $this->complete_date = 0;
                         break;
               }

               $this->marked_as_paid = 0;
          }
     }
     protected function _postSave()
     {
          if ($this->isChanged('status'))
          {
               if ($this->Ad)
               {
                    $pendingChanges = $this->Ad->Extra->pending_changes;

                    if (!empty($pendingChanges))
                    {
                         $extraData = [
                              'exclusive_use' => $this->isCompleted()
                                   ? $pendingChanges['exclusive_use']['new_value']
                                   : $pendingChanges['exclusive_use']['old_value'],
                              'is_sticky'     => $this->isCompleted()
                                   ? $pendingChanges['is_sticky']['new_value']
                                   : $pendingChanges['is_sticky']['old_value'],
                         ];

                         $this->Ad->updateExtraData($extraData + ['pending_changes' => []]);
                    }

                    switch ($this->status)
                    {
                         case 'completed':
                              if ($this->Ad->isQueuedInvoice())
                              {
                                   $this->Ad->status = 'queued';
                                   $this->Ad->save();
                              }
                              else
                              {
                                   $this->Ad->activate();
                              }
                              break;
                         case 'cancelled':
                              if (!$this->Ad->isActive() || $this->getOption('admin_edit'))
                              {
                                   $this->Ad->deactivate();
                              }
                              else if (!empty($pendingChanges))
                              {
                                   $this->Ad->save();
                              }
                              break;
                         case 'pending':
                              break;
                    }
               }
               else if ($this->child_ids)
               {
                    foreach ($this->getChildList() as $invoice)
                    {
                         $invoice->status = $this->status;
                         $invoice->save();
                    }
               }
          }
     }
     protected function _postDelete()
     {
          if ($this->invoice_file && !$this->child_ids)
          {
               \XF\Util\File::deleteAbstractedDirectory("data://siropu/am/invoice/{$this->invoice_id}/");
          }

          $alertRepo = $this->repository('XF:UserAlert');
          $alertRepo->fastDeleteAlertsForContent('siropu_ads_manager_inv', $this->invoice_id);
     }
}
