<?php

namespace FS\ExtendThreadCredits\Admin\View\Purchase;

// use XF\Entity\User;
use ThemeHouse\ThreadCredits\Entity\CreditPackage as CreditPackageEntity;
use ThemeHouse\ThreadCredits\Entity\UserCreditPackage;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\View;

// use function in_array;

class ExportListing extends View
{
	public function renderRaw()
	{
		// var_dump("asdf");exit;
		$this->response
			->contentType('text/csv', 'utf-8')
			->setDownloadFileName($this->getCsvFileName());

		$fp = fopen('php://memory', 'r+');

		$fields = $this->getPurchaseDataFieldsForExport();
		
		fputcsv($fp, array_keys($fields));
		// echo"<pre>";
		// var_dump();exit;
		/** @var UserCreditPackage $purchase */
		foreach ($this->params['purchases'] AS $purchase)
		// var_dump($purchases);exit;
		{
			$purchaseData = $this->getPurchaseDataForExport($purchase, $fields);
			// var_dump($purchaseData);exit;

			fputcsv($fp, $purchaseData);
		}

		rewind($fp);
		$csv = stream_get_contents($fp);
		fclose($fp);

		return $csv;
	}

	/**
	 * Extend this method to change the exported fields.
	 *
	 * Format is [field_name] => [option] where [option] can be either true to export the raw field value from the User entity
	 * or a callback to return formatted or manipulated data
	 *
	 * @return array
	 */
	// protected function getUserDataFieldsForExport()
	// {
	// 	return [
	// 		'username' => true,
	// 	];
	// }
	protected function getPurchaseDataFieldsForExport()
{
	// var_dump('hello');exit;
    return [
        // 'username' => true, 
		'Username' => function ($purchase) {
            return $purchase->User ? $purchase->User->username : 'Unknown user'; // Safely access the related User entity
        },
		'Payment Title' => function ($purchase) {
            return $purchase->PurchaseRequest && $purchase->PurchaseRequest->PaymentProfile
                ? $purchase->PurchaseRequest->PaymentProfile->title
                : 'Manually granted';
        },
        'Date Time' => function ($purchase) {
            return gmdate('d F Y H:i:s', $purchase->purchased_at);
        }
    ];
}


	protected function getPurchaseDataForExport(UserCreditPackage $purchase, array $fields)
		{
			$output = [];

			foreach ($fields AS $fieldName => $action)
			{
				if (is_callable($action))
				{
					// Call the function to get the custom value (like formatted date or payment profile title)
					$output[] = $action($purchase);
				}
				else
				{
					// Otherwise, directly use the field from the $purchases object
					$output[] = $purchase->$fieldName;
				}
			}

			return $output;
		}

	protected function getCsvFileName()
	{
		return sprintf("XenForo Purchases_Log %s.csv", gmdate('Y-m-d', \XF::$time));
	}
}