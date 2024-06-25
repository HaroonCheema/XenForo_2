<?php

namespace NF\GiftUpgrades\XF\Pub\Controller;

use NF\GiftUpgrades\XF\Entity\User;
use NF\GiftUpgrades\XF\Entity\UserUpgrade;
use XF\Mvc\ParameterBag;
use XF\Mvc\Entity\Entity;
use NF\GiftUpgrades\Entity\IGiftable;
use NF\GiftUpgrades\Repository\GiftUpgrade as GiftUpgradeRepo;
use NF\GiftUpgrades\XF\Service\User\Upgrade as ExtendedUserUpgradeSvc;

/**
 * Extends \XF\Pub\Controller\Purchase
 */
class Purchase extends XFCP_Purchase
{
	/**
	 * @param ParameterBag $params
	 *
     * @return \XF\Mvc\Reply\AbstractReply
	 *
	 * @throws \XF\Mvc\Reply\Exception
	 * @throws \XF\PrintableException
	 */
	public function actionIndex(ParameterBag $params)
	{
		$isGift = $this->filter('gift', 'bool');
		$profileId = $this->filter('payment_profile_id', 'uint');
		$isConfirmed = $this->filter('confirmed', 'bool');
		$isGiftingForFree = $this->filter('gift_for_free', 'bool');

		$contentType = $this->filter('content_type', 'str');

        /** @noinspection PhpUndefinedFieldInspection */
		if ($isGift && $params->purchasable_type_id === 'user_upgrade')
		{
			/** @var UserUpgrade $userUpgrade */
			$userUpgrade = $this->assertRecordExists(
				'XF:UserUpgrade',
				$this->filter('user_upgrade_id', 'int'),
				null,
				'nf_giftupgrades_requested_user_upgrade_not_found'
			);

			if ($isConfirmed && $isGiftingForFree)
			{
				/** @var User $visitor */
				$visitor = \XF::visitor();
				if (!$visitor->canGiftForFree())
				{
					throw $this->exception($this->noPermission(\XF::phrase('sorry_dave')));
				}

				if ($contentType)
				{
					$contentId = $this->filter('content_id', 'int');
                    /** @var \XF\Entity\User $user */
					$user = $this->em()->findOne('XF:User', ['user_id' => $this->filter('gift_to_user_id', 'int')]);
				}
				else
				{
                    /** @var \XF\Entity\User $user */
					$user = $this->em()->findOne('XF:User', ['username' => $this->filter('username', 'str')]);
					$contentType = 'user';
					$contentId = $user->user_id;
				}

				if (!$user)
				{
					throw $this->exception($this->error(\XF::phrase('requested_user_not_found')));
				}

				$giftUpgradeHandler = GiftUpgradeRepo::get()->getGiftHandler($contentType, \XF::$developmentMode);
				if (!$giftUpgradeHandler) // will return false if handler does not exist AND not in dev mode
				{
					throw $this->exception($this->noPermission());
				}

				/** @var Entity|IGiftable $content */
				$content = $giftUpgradeHandler->getContent($contentId);
				if (!$content)
				{
					throw $this->exception($this->notFound());
				}

				if (!$content->canGiftTo($error))
				{
					throw $this->exception($this->noPermission($error));
				}

				/** @var ExtendedUserUpgradeSvc $upgradeService */
				$upgradeService = $this->service(\XF\Service\User\Upgrade::class, $userUpgrade, $user);
				$upgradeService->ignoreUnpurchasable(true);
				$upgradeService->markAsGifted(\XF::visitor()->user_id, $contentType, $contentId, $this->filter('anonymous', 'bool'), true);
				$upgradeService->upgrade();

				return $this->redirect($giftUpgradeHandler->getContentUrl($content));
			}
			else if (!$isConfirmed && !$isGiftingForFree)
			{
				/** @var \XF\Entity\PaymentProfile $paymentProfile */
				$paymentProfile = \XF::em()->find('XF:PaymentProfile', $profileId);
				if (!$paymentProfile || !$paymentProfile->active)
				{
					$error = \XF::phrase('please_choose_valid_payment_profile_to_continue_with_your_purchase');
					throw $this->exception($this->error($error));
				}

				/** @noinspection PhpUndefinedFieldInspection */
				$purchasable = $this->assertPurchasableExists($params->purchasable_type_id);
				$addOns = \XF::app()->container('addon.cache');
				$costAmountString = (string)$userUpgrade->cost_amount;
				if ($costAmountString === '0.00')
				{
					if (isset($addOns['SV/UserEssentials']))
					{
						$userUpgrade->cost_amount = round($this->filter('cost_amount', 'unum'), 2);
						$userUpgrade->setReadOnly(true);
					}
				}

				$coupon = false;
				if (isset($addOns['NF/Coupons']))
				{
				    /** @var \NF\Coupons\Repository\Coupon $couponRepo */
                    $couponRepo = \XF::repository('NF\Coupons:Coupon');
					$couponValid = $couponRepo->checkCouponUse($this->request, $userUpgrade, $newCost, $hasCoupon, $coupon, $couponError);

					if ($couponValid === true)
					{
						$userUpgrade->cost_amount = $newCost;
						$userUpgrade->setReadOnly(true);
						$coupon = $coupon->coupon;
					}
				}

				$viewParams = [
					'purchasable' => $purchasable,
					'upgrade' => $userUpgrade,
					'profileId' => $profileId,
					'coupon' => $coupon,
				];

				return $this->view(
					'NF\GiftUpgrades:Purchase\Gift',
					'nf_giftupgrades_account_upgrades_gift',
					$viewParams
				);
			}
		}

		return parent::actionIndex($params);
	}
}