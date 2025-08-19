<?php

namespace Siropu\AdsManager\Service\Invoice;

class Manager extends \XF\Service\AbstractService
{
	protected $ad;
	protected $invoice;
	protected $generateAlert = true;

	public function __construct(\XF\App $app, \Siropu\AdsManager\Entity\Ad $ad, \Siropu\AdsManager\Entity\Invoice $invoice = null)
	{
		parent::__construct($app);

		if ($invoice)
		{
			$this->invoice = $invoice;
		}
		else
		{
			$this->invoice = $this->em()->create('Siropu\AdsManager:Invoice');
		}

		$this->ad = $ad;
	}
	public function generate()
	{
          if (!$this->ad->Package || $this->ad->isFree())
          {
               return;
          }

		$this->invoice->bulkSet([
			'ad_id'         => $this->ad->ad_id,
			'user_id'       => $this->ad->user_id,
			'username'      => $this->ad->username,
			'cost_amount'   => $this->ad->getCost()['costDiscounted'],
			'cost_currency' => $this->ad->Package->cost_currency,
			'length_amount' => $this->ad->Extra->purchase,
			'length_unit'   => $this->ad->Package->cost_per,
			'promo_code'    => $this->ad->Extra->promo_code
		]);
		$this->invoice->save();

		if ($this->generateAlert)
		{
			$this->repository('XF:UserAlert')->alert(
				$this->ad->User,
				$this->ad->user_id,
				$this->ad->username,
				'siropu_ads_manager_inv',
				$this->invoice->invoice_id,
				'new'
			);
		}
	}
	public function setGenerateAlert($state)
	{
		$this->generateAlert = $state;
	}
	public function getInvoice()
	{
		return $this->invoice;
	}
}
