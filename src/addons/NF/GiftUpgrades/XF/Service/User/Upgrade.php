<?php

namespace NF\GiftUpgrades\XF\Service\User;

use NF\GiftUpgrades\XF\Entity\UserUpgradeActive as ExtendedUserUpgradeActiveEntity;
use XF\Entity\PurchaseRequest as PurchaseRequestEntity;
use NF\GiftUpgrades\Entity\GiftUpgrade as GiftUpgradeEntity;

/**
 * Extends \XF\Service\User\Upgrade
 *
 * @property ExtendedUserUpgradeActiveEntity $activeUpgrade
 * @method ExtendedUserUpgradeActiveEntity getActiveUpgrade()
 */
class Upgrade extends XFCP_Upgrade
{
    /**
     * @var PurchaseRequestEntity
     */
    protected $purchaseRequest;

    /**
     * @var null|GiftUpgradeEntity
     */
    protected $giftUpgrade = null;

    /**
     * @param string $purchaseRequestKey
     */
    public function setPurchaseRequestKey($purchaseRequestKey)
    {
        parent::setPurchaseRequestKey($purchaseRequestKey);

        /** @var PurchaseRequestEntity $purchaseRequest */
        $purchaseRequest = $this->em()->findOne('XF:PurchaseRequest', ['request_key' => $purchaseRequestKey]);

        $this->setPurchaseRequest($purchaseRequest);
    }

    /**
     * @since 2.30
     *
     * @param int $payUserId
     * @param string $contentType
     * @param int $contentId
     * @param bool $isAnonymous
     * @param bool $isFree
     *
     * @return $this
     */
    public function markAsGifted(
        int $payUserId,
        string $contentType, int $contentId,
        bool $isAnonymous = false,
        bool $isFree = false
    ) : self
    {
        $activeUpgrade = $this->getActiveUpgrade();
        $activeUpgrade->pay_user_id = $payUserId;
        $activeUpgrade->is_gift = true;
        $activeUpgrade->nf_was_gifted_for_free = $isFree;

        /** @var GiftUpgradeEntity $giftUpgrade */
        $giftUpgrade = $this->em()->create('NF\GiftUpgrades:GiftUpgrade');
        $giftUpgrade->user_upgrade_record_id = $activeUpgrade->em()->getDeferredValue(function() use($activeUpgrade)
        {
            return $activeUpgrade->user_upgrade_record_id;
        }, 'save');
        $giftUpgrade->content_type = $contentType;
        $giftUpgrade->content_id = $contentId;
        $giftUpgrade->content_user_id = $this->getUser()->user_id;
        $giftUpgrade->gift_user_id = $payUserId;
        $giftUpgrade->is_anonymous = $isAnonymous;
        $giftUpgrade->setOption('log_stat_for_upgrade_id', $activeUpgrade->user_upgrade_id);

        $this->giftUpgrade = $giftUpgrade;

        return $this;
    }

    /**
     * @since 2.3.0
     *
     * @param PurchaseRequestEntity $purchaseRequest
     *
     * @return $this
     */
    public function markAsGiftedFromPurchaseRequest(
        PurchaseRequestEntity $purchaseRequest
    ) : self
    {
        $payUserId = $purchaseRequest->extra_data['payUser']['user_id'];
        $contentType = 'user';
        $contentId = $this->user->user_id;

        if (isset($purchaseRequest->extra_data['content_type']))
        {
            $contentType = $purchaseRequest->extra_data['content_type'];
            $contentId = $purchaseRequest->extra_data['content_id'];
        }

        $isAnonymous = (bool)($purchaseRequest->extra_data['is_anonymous'] ?? false);

        return $this->markAsGifted(
            $payUserId,
            $contentType, $contentId,
            $isAnonymous
        );
    }

    public function getGiftUpgrade(): ?GiftUpgradeEntity
    {
        return $this->giftUpgrade;
    }

    /**
     * @since 2.3.0
     *
     * @param PurchaseRequestEntity|null $purchaseRequest
     */
    protected function setPurchaseRequest(PurchaseRequestEntity $purchaseRequest = null)
    {
        $this->purchaseRequest = $purchaseRequest;

        if ($purchaseRequest && !empty($purchaseRequest->extra_data['is_gift']))
        {
            /** @var \XF\Entity\User $user */
            if (isset($purchaseRequest->extra_data['giftToId']))
            {
                $user = $this->em()->findOne('XF:User', ['user_id' => $purchaseRequest->extra_data['giftToId']]);
            }
            else
            {
                $user = $this->em()->findOne('XF:User', ['username' => $purchaseRequest->extra_data['giftTo']]);
            }
            if (!$user)
            {
                // processed as a normal upgrade so this request isn't dropped on the floor after we accept money
                return;
            }
            $this->user = $user;

            /** @var \XF\Entity\UserUpgrade $userUpgrade */
            $userUpgrade = \XF::em()->find('XF:UserUpgrade', $this->userUpgrade->user_upgrade_id, 'Active|' . $user->user_id);

            // initialize activeUpgrade under the right user
            $this->setUpgrade($userUpgrade);
            $this->markAsGiftedFromPurchaseRequest($purchaseRequest);
        }
    }

    /**
     * @return null|PurchaseRequestEntity
     */
    public function getPurchaseRequest()
    {
        return $this->purchaseRequest;
    }

    /**
     * @since 2.3.0
     */
    protected function finalizeGiftUpgrade() : void
    {
        $giftUpgrade = $this->getGiftUpgrade();

        // Expiring User Upgrades, disable duplicate notification of upgrades
        $purchaseRequest = $this->getPurchaseRequest();
        if ($purchaseRequest && $giftUpgrade && !empty($options->exup_notify_purchase))
        {
            $options->exup_notify_purchase = false;
        }

        // convert from a gift to non-gift upgrade
        if (!$giftUpgrade && $this->activeUpgrade->is_gift)
        {
            $this->activeUpgrade->is_gift = false;
        }
    }

    /**
     * @since 2.3.0
     *
     * @throws \XF\PrintableException
     */
    protected function saveGiftUpgrade() : void
    {
        $giftUpgrade = $this->getGiftUpgrade();
        if (!$giftUpgrade)
        {
            return;
        }

        $giftUpgrade->save(true, false);
        $user = $this->getUser();

        if ($giftUpgrade->is_anonymous)
        {
            $senderId = $user->user_id;
            $senderName = $user->username;
            $action = 'upgrade_gifted_anon';
        }
        else
        {
            $senderId = $giftUpgrade->gift_user_id;
            $senderName = $giftUpgrade->User->username ?? \XF::phrase('Guest')->render('raw');
            $action = 'upgrade_gifted';
        }

        /** @var \XF\Repository\UserAlert $alertRepo */
        $alertRepo = $this->repository('XF:UserAlert');
        $alertRepo->alert(
            $user,
            $senderId,
            $senderName,
            'user',
            $user->user_id,
            $action
        );
    }

    /**
     * @return bool|\XF\Entity\UserUpgradeActive
     * @throws \XF\PrintableException
     */
    public function upgrade()
    {
        $this->db()->beginTransaction();

        $this->finalizeGiftUpgrade();

        /** @var ExtendedUserUpgradeActiveEntity|bool $active */
        $active = parent::upgrade();

        if ($active)
        {
            $this->saveGiftUpgrade();
        }

        $this->db()->commit();

        return $active;
    }
}