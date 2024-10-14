<?php

namespace ThemeHouse\ThreadCredits\Service\CreditPackage;

use ThemeHouse\ThreadCredits\Entity\CreditPackage;
use ThemeHouse\ThreadCredits\Entity\UserCreditPackage;
use XF\Entity\User;
use XF\Repository\UserAlert;
use XF\Service\AbstractService;
use XF\Service\User\UserGroupChange;

class Purchase extends AbstractService
{
    /** @var CreditPackage */
    protected $creditPackage;
    /** @var User */
    protected $user;
    /** @var array */
    protected $extraData = [];
    /** @var string */
    protected $purchaseRequestKey;
    /** @var bool */
    protected $finalSetup = false;
    /** @var UserCreditPackage */
    protected $userCreditPackage;
    /** @var int */
    protected $endDate;
    /** @var bool */
    protected $ignoreUnpurchasable = false;

    public function __construct(\XF\App $app, CreditPackage $creditPackage, User $user)
    {
        parent::__construct($app);

        $this->creditPackage = $creditPackage;
        $this->user = $user;

        /** @var UserCreditPackage $userCreditPackage */
        $userCreditPackage = $this->em()->create('ThemeHouse\ThreadCredits:UserCreditPackage');
        $userCreditPackage->credit_package_id = $creditPackage->credit_package_id;
        $userCreditPackage->user_id = $user->user_id;
        $this->userCreditPackage = $userCreditPackage;
    }

    protected $notifyUser = false;

    public function notifyUser(bool $notify): void
    {
        $this->notifyUser = $notify;
    }

    public function setExtraData(array $extraData)
    {
        $this->extraData = $extraData;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setPurchaseRequestKey($purchaseRequestKey)
    {
        $this->purchaseRequestKey = $purchaseRequestKey;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = intval($endDate);
    }

    public function ignoreUnpurchasable($ignoreUnpurchsable)
    {
        $this->ignoreUnpurchasable = $ignoreUnpurchsable;
    }

    protected function finalSetup()
    {
        $this->finalSetup = true;

        $userCreditPackage = $this->userCreditPackage;
        $creditPackage = $this->creditPackage;

        $endDate = $this->endDate;

        if ($endDate === null) {
            if (!$creditPackage->length_unit) {
                $endDate = 0;
            } else {
                $endDate = strtotime('+' . $creditPackage->length_amount . ' ' . $creditPackage->length_unit);
            }
        }

        $userCreditPackage->total_credits = $creditPackage->credits;
        $userCreditPackage->remaining_credits = $creditPackage->credits;
        $userCreditPackage->extra = array_merge([
            'cost_amount' => $creditPackage->cost_amount,
            'cost_currency' => $creditPackage->cost_currency,
            'length_amount' => $creditPackage->length_amount,
            'length_unit' => $creditPackage->length_unit
        ], $this->extraData);

        $userCreditPackage->expires_at = $endDate;

        if ($this->purchaseRequestKey) {
            $requestKey = $this->purchaseRequestKey;
            if (strlen($requestKey) > 32) {
                $requestKey = substr($requestKey, 0, 29) . '...';
            }

            $userCreditPackage->purchase_request_key = $requestKey;
        }
    }

    public function purchase()
    {
        if (!$this->finalSetup) {
            $this->finalSetup();
        }

        $userCreditPackage = $this->userCreditPackage;
        $creditPackage = $this->creditPackage;
        $user = $this->user;

        // no need to check canPurchase -- if we have a payment, we should process the purchase
        $db = $this->db();
        $db->beginTransaction();

        if (!$userCreditPackage->save(true, false)) {
            $db->rollback();
            return false;
        }

        /** @var UserGroupChange $userGroupChange */
        $userGroupChange = $this->service('XF:User\UserGroupChange');
        $userGroupChange->addUserGroupChange(
            $user->user_id, 'thtcCreditPackage-' . $creditPackage->credit_package_id, $creditPackage->extra_group_ids
        );
        $db->commit();

        if ($this->notifyUser) {
            /** @var UserAlert $repo */
            $repo = $this->repository('XF:UserAlert');
            $repo->alert(
                $userCreditPackage->User,
                0, '',
                'user', $userCreditPackage->user_id,
                'thtc_purchase',
                [
                    'credits' => $userCreditPackage->total_credits,
                    'purchase_user_id' => \XF::visitor()->user_id
                ] + $this->extraData,
//                [
//                    'dependsOnAddOnId' => 'Themehouse/ThreadCredits',
//                ]
            );
        }

        return $userCreditPackage;
    }
}