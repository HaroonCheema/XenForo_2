<?php

namespace Siropu\AdsManager\Cron;

class Invoice
{
	public static function processExpiredInvoices()
	{
		$options  = \XF::options();

		$dateTime = new \DateTime('now', new \DateTimeZone($options->guestTimeZone));
		$dateTime->modify("-{$options->siropuAdsManagerInvoicePayTimeLimit} hours");

	     $invoices = self::getInvoiceRepo()
			->findInvoicesForList()
			->ofStatus('pending')
			->where('create_date', '<=', $dateTime->format('U'))
			->fetch();

		foreach ($invoices as $invoice)
		{
			$invoice->status = 'cancelled';
			$invoice->save();
		}
	}
	/**
      * @return \Siropu\AdsManager\Repository\Invoice
      */
     private static function getInvoiceRepo()
     {
          return \XF::app()->repository('Siropu\AdsManager:Invoice');
     }
}
