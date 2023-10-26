<?php

namespace DBTech\eCommerce\ThreadType;

use XF\Entity\Thread;
use XF\Http\Request;
use XF\ThreadType\AbstractHandler;

/**
 * Class Download
 *
 * @package DBTech\eCommerce\ThreadType
 */
class Download extends AbstractHandler
{
	/**
	 * @return string
	 */
	public function getTypeIconClass(): string
	{
		return '';
	}

	/**
	 * @param \XF\Entity\Thread $thread
	 *
	 * @return string[]
	 */
	public function getThreadViewAndTemplate(Thread $thread): array
	{
		// Use the product template ssince we're gonna add the view param
		return ['DBTech\eCommerce:Thread\ViewTypeDownload', 'dbtech_ecommerce_thread_view_type_product'];
	}

	/**
	 * @param \XF\Entity\Thread $thread
	 * @param array $viewParams
	 * @param \XF\Http\Request $request
	 *
	 * @return array
	 */
	public function adjustThreadViewParams(Thread $thread, array $viewParams, Request $request): array
	{
		$thread = $viewParams['thread'] ?? null;
		if ($thread)
		{
			/** @var \DBTech\eCommerce\Entity\Download $download */
			$download = \XF::repository('DBTech\eCommerce:Download')
				->findDownloadForThread($thread)
				->fetchOne()
			;
			if ($download && $download->canView())
			{
				$viewParams['product'] = $download->Product;
			}

			$showCheckout = false;
			if (\XF::options()->dbtechEcommerceEnableCheckoutProductPage)
			{
				/** @var \DBTech\eCommerce\Repository\Order $orderRepo */
				$orderRepo = \XF::repository('DBTech\eCommerce:Order');

				if (\XF::visitor()->user_id)
				{
					/** @var \DBTech\eCommerce\Entity\Order $order */
					$order = $orderRepo->findCurrentOrderForUser()->fetchOne();
				}
				else
				{
					/** @var \DBTech\eCommerce\Entity\Order $order */
					$order = $orderRepo->findCurrentOrderForGuest()->fetchOne();
				}

				if ($order)
				{
					/** @var \DBTech\eCommerce\Entity\OrderItem $orderItem */
					foreach ($order->Items as $orderItem)
					{
						if ($orderItem->product_id == $download->product_id)
						{
							$showCheckout = true;
						}
					}
				}
			}

			$viewParams['showCheckout'] = $showCheckout;
		}

		return $viewParams;
	}

	/**
	 * @return bool
	 */
	public function allowExternalCreation(): bool
	{
		return false;
	}

	/**
	 * @param \XF\Entity\Thread $thread
	 *
	 * @return bool
	 */
	public function canThreadTypeBeChanged(Thread $thread): bool
	{
		return false;
	}

	/**
	 * @param bool $isBulk
	 *
	 * @return bool
	 */
	public function canConvertThreadToType(bool $isBulk): bool
	{
		return false;
	}
}