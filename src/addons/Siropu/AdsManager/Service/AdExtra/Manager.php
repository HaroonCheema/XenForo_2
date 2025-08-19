<?php

namespace Siropu\AdsManager\Service\AdExtra;

class Manager extends \XF\Service\AbstractService
{
	protected $ad;
     protected $extra;

	public function __construct(\XF\App $app, \Siropu\AdsManager\Entity\Ad $ad)
	{
		parent::__construct($app);

		if ($ad->Extra)
		{
			$this->extra = $ad->Extra;
		}
		else
		{
			$this->extra = $this->em()->create('Siropu\AdsManager:AdExtra');
			$this->extra->set('ad_id', $ad->ad_id);
		}

		$this->ad = $ad;
		$this->setDefaults();
	}
     public function set($key, $val)
	{
		$this->extra->set($key, $val);
	}
	public function bulkSet(array $data)
	{
		$this->extra->bulkSet($data);
	}
	public function setDefaults()
	{
          if ($this->ad->hasChanges())
          {
               $this->extra->last_change = \XF::$time;
          }

          if ($this->ad->isChanged('status'))
          {
               $this->extra->active_since = $this->ad->isActive() ? \XF::$time : 0;

               if ($this->ad->getPreviousValue('status') == 'active' && !$this->ad->isInsert())
               {
                    $lastActive = \XF::$time;
               }
               else
               {
                    $lastActive = $this->ad->isActive() ? 0 : $this->extra->last_active;
               }

               $this->extra->last_active = $lastActive;

               if (!$this->extra->isInsert())
     		{
     			$this->setPrevStatus();
     		}
          }
	}
	public function setPrevStatus()
	{
          $prevStatus = $this->ad->getPreviousValue('status');

          if (!$this->ad->isPending())
          {
               $prevStatus = '';
          }

		$this->extra->prev_status = $prevStatus;
	}
	public function setRejectReason($rejectReason)
	{
		$this->extra->reject_reason = $rejectReason;
	}
	public function setPurchase($purchase = 1)
	{
		$this->extra->purchase = $this->getValidPurchaseValue($purchase);
	}
	public function setPromoCode($promoCode = '')
	{
		$this->extra->promo_code = $promoCode;
	}
     public function setPrefixId($prefixId)
	{
		$this->extra->prefix_id = $prefixId;
	}
     public function setCustomFields(array $customFields)
     {
          $this->extra->custom_fields = $customFields;
     }
     public function setIsSticky($isSticky = 0)
	{
		$this->extra->is_sticky = $isSticky;
	}
	public function setExclusiveUse($exclusiveUse = 0)
	{
		$this->extra->exclusive_use = $exclusiveUse;
	}
	public function save()
	{
		$this->extra->saveIfChanged($saved, false);
	}
	public function getEntity()
	{
		return $this->extra;
	}
	public function getPurchase()
	{
		return $this->extra->purchase;
	}
	protected function getValidPurchaseValue($purchase)
	{
          $package = $this->ad->Package;

          if ($package)
          {
               if ($purchase < $package->min_purchase)
     		{
     			$purchase = $package->min_purchase;
     		}
     		else if ($purchase > $package->max_purchase)
     		{
     			$purchase = $package->max_purchase;
     		}
          }

		return $purchase;
	}
}
