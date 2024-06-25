<?php

namespace NF\GiftUpgrades\XF\Purchasable;

use NF\GiftUpgrades\Globals;
use XF\Payment\CallbackState;
use XF\Repository\User as UserRepo;

/**
 * Extends \XF\Purchasable\UserUpgrade
 */
class UserUpgrade extends XFCP_UserUpgrade
{
    protected $canPurchaseErrors = [];

    /**
     * @param \XF\Http\Request $request
     * @param \XF\Entity\User  $purchaser
     * @param null             $error
     *
     * @return bool|\XF\Purchasable\Purchase
     */
    public function getPurchaseFromRequest(\XF\Http\Request $request, \XF\Entity\User $purchaser, &$error = null)
    {
        if (Globals::$isGift = $request->filter('gift', 'bool'))
        {
            $visitor = \XF::visitor();
            $username = $request->filter('username', 'str');

            /** @var UserRepo $userRepo */
            $userRepo = \XF::repository('XF:User');
            $user = $userRepo->getUserByNameOrEmail($username);
            if (!$user)
            {
                $error = \XF::phrase('requested_user_not_found');
                return false;
            }

            if ($user->user_id === $visitor->user_id)
            {
                $error = \XF::phrase('nf_giftupgrades_you_cannot_gift_yourself');
                return false;
            }

            Globals::$giftToUserId = $user->user_id;
            Globals::$giftToUsername = $user->username;
            Globals::$isAnonymous = $request->filter('anonymous', 'bool');
            Globals::$payUserId = $visitor->user_id;
            Globals::$payUsername = $visitor->username;
            Globals::$contentId = $request->filter('content_id', 'int');
            Globals::$contentType = $request->filter('content_type', 'str');
        }

        return parent::getPurchaseFromRequest($request, $purchaser, $error);
    }

    /**
     * @param array                     $extraData
     * @param \XF\Entity\PaymentProfile $paymentProfile
     * @param \XF\Entity\User           $purchaser
     * @param null                      $error
     *
     * @return bool|\XF\Purchasable\Purchase
     */
    public function getPurchaseFromExtraData(array $extraData, \XF\Entity\PaymentProfile $paymentProfile, \XF\Entity\User $purchaser, &$error = null)
    {
        if (array_key_exists('is_gift', $extraData))
        {
            Globals::$isGift = $extraData['is_gift'];
        }

        return parent::getPurchaseFromExtraData($extraData, $paymentProfile, $purchaser, $error);
    }

    /**
     * @param \XF\Entity\PaymentProfile $paymentProfile
     * @param \XF\Entity\UserUpgrade    $purchasable
     * @param \XF\Entity\User           $purchaser
     *
     * @return \XF\Purchasable\Purchase
     */
    public function getPurchaseObject(\XF\Entity\PaymentProfile $paymentProfile, $purchasable, \XF\Entity\User $purchaser)
    {
        $parent = parent::getPurchaseObject($paymentProfile, $purchasable, $purchaser);

        try
        {
            if (Globals::$isGift)
            {
				$parent->recurring = false;

                $extraData = $parent->extraData;

                $parent->title = (string)\XF::phrase('nf_giftupgrades_line_item', [
                    'account_upgrade' => \XF::phrase('account_upgrade'),
                    'title' => $purchasable->title,
                    'giftToUsername' => Globals::$giftToUsername,
                    'payUsername' => Globals::$payUsername,
                ]);

                $extraData['is_gift'] = Globals::$isGift;
                $extraData['is_anonymous'] = Globals::$isAnonymous;
                $extraData['giftTo'] = Globals::$giftToUsername;
                $extraData['giftToId'] = Globals::$giftToUserId;
                $extraData['payUser'] = [
                    'user_id' => Globals::$payUserId,
                    'username' => Globals::$payUsername
                ];

                if (Globals::$contentId && Globals::$contentType)
                {
                    $extraData['content_id'] = Globals::$contentId;
                    $extraData['content_type'] = Globals::$contentType;
                }

                $parent->extraData = $extraData;
            }
        }
        finally
        {
            Globals::$giftToUsername = null;
            Globals::$giftToUserId = null;
            Globals::$isGift = null;
            Globals::$isAnonymous = null;
            Globals::$payUserId = null;
            Globals::$payUsername = null;
        }

        return $parent;
    }

    public function sendPaymentReceipt(CallbackState $state)
    {
        $payingUserId = (int)($state->purchaseRequest->extra_data['payUser']['user_id'] ?? 0);
        if ($payingUserId === 0)
        {
            parent::sendPaymentReceipt($state);
            return;
        }

        $user = \XF::em()->find('XF:User', $payingUserId);
        if (!($user instanceof \XF\Entity\User))
        {
            return;
        }

        $receivingUser = $state->getPurchaser();
        if (!($receivingUser instanceof \XF\Entity\User))
        {
            return;
        }

        $state->purchaser = $user;
        $purchaseRequest = $state->purchaseRequest;
        $purchaseRequest->hydrateRelation('User', $user);
        try
        {
            \XF::asVisitor($user, function() use ($state) {
                parent::sendPaymentReceipt($state);
            }, true);
        }
        finally
        {
            $state->purchaser = $receivingUser;
            $purchaseRequest->hydrateRelation('User', $receivingUser);
        }
    }
}