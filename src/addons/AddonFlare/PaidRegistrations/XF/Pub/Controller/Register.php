<?php

namespace AddonFlare\PaidRegistrations\XF\Pub\Controller;

use XF\ConnectedAccount\Provider\AbstractProvider;
use XF\ConnectedAccount\ProviderData\AbstractProviderData;
use XF\Mvc\ParameterBag;

class Register extends XFCP_Register
{
    public function checkCsrfIfNeeded($action, ParameterBag $params)
    {
        if (in_array($action, ['Index', 'AccountType'])) return;

        parent::checkCsrfIfNeeded($action, $params);
    }

    public function actionIndex()
    {
        if (!$this->options()->af_paidregistrations_guest)
        {
            return parent::actionIndex();
        }

        $accountTypeId = $this->filter('accountType', 'uint');

        if (($purchaseRequestKey = $this->filter('custom', 'str')) || ($purchaseRequestKey = $this->filter('cm', 'str')) || ($purchaseRequestKey = $this->filter('prk', 'str')))
        {
            $purchaseRequest = $this->em()->findOne('XF:PurchaseRequest', [
                'request_key' => $purchaseRequestKey,
                'user_id'     => 0,
                'purchasable_type_id' => 'user_upgrade',
            ]);

            if ($purchaseRequest)
            {
                $userUpgrade = $this->em()->find('XF:UserUpgrade', $purchaseRequest->extra_data['user_upgrade_id']);

                if ($userUpgrade && $userUpgrade->can_purchase)
                {
                    // fix for chrome 97+ Same Site cookie issue when the register form is redirected via an external site ex. paypal
                    $isValidReferrer = function($referrer)
                    {
                        if (!$referrer)
                        {
                            return true;
                        }

                        $referrerParts = @parse_url($referrer);
                        if (!$referrerParts || empty($referrerParts['host']))
                        {
                            return true;
                        }

                        $requestParts = @parse_url($this->request->getFullRequestUri());
                        if (!$requestParts || empty($requestParts['host']))
                        {
                            return true;
                        }

                        return ($requestParts['host'] === $referrerParts['host']);
                    };

                    $reply = parent::actionIndex();

                    if ($reply instanceof \XF\Mvc\Reply\View)
                    {
                        if (!empty($purchaseRequest->extra_data['email']))
                        {
                            $this->assertPaidRegistrationEmailNotRegistered($purchaseRequest->extra_data['email']);
                        }

                        // use the purchase request cost amount instead just incase it was a custom amount
                        $userUpgrade->cost_amount = $purchaseRequest->cost_amount;
                        // set to read only just incase it somehow attempts to save, shouldn't happen though
                        $userUpgrade->setReadOnly(true);

                        $reply->setParam('purchaseRequest', $purchaseRequest);
                        $reply->setParam('userUpgrade', $userUpgrade);

                        $fields = $reply->getParam('fields');
                        $fields['email'] = $purchaseRequest->extra_data['email'];
                        $reply->setParam('fields', $fields);

                        if (!$isValidReferrer($this->request->getReferrer()))
                        {
                            // force a refresh so the xf_session cookie is accepted/received by the browser
                            $reply->setParam('paidRegistrationsRefreshUrl', $this->buildLink('canonical:register', null, [
                                'prk' => $purchaseRequestKey,
                                '_xfRedirect' => $this->filter('_xfRedirect', 'str'),
                                '_t' => time(), // prevent the browser from using cache
                            ]));
                        }
                    }

                    return $reply;
                }
            }
        }

        $accountTypeRepo = $this->getAccountTypeRepo();

        $accountType = $this->getAccountType($accountTypeId);

        // if no or invalid account type was chosen or a valid account type was chosen but it's not a "free" type
        // entering a valid user_upgrade_id ex. register/?accountType=3 should still show the account types list because we handle the purchase in actionPurchase()
        if (!$accountType || $accountType->user_upgrade_id != -1)
        {
            // at least one account type must be available
            $purchasable = $this->em()->find('XF:Purchasable', 'user_upgrade', 'AddOn');

            $upgradeRepo = $this->repository('XF:UserUpgrade');
            $upgrades = $upgradeRepo->findUserUpgradesForList()->fetch();

            if
            (
                $purchasable->isActive() &&
                $accountTypeRepo->filterPurchasable($accountTypeRepo->findActiveAccountTypesForList()->fetch())->count() &&
                $upgrades->count()
            )
            {
                return $this->accountTypes();
            }
        }

        // regular registration form, only executed by "free type"
        return parent::actionIndex();
    }

    protected function accountTypes()
    {
        $accountTypeRepo = $this->getAccountTypeRepo();

        $accountTypes = $accountTypeRepo->findActiveAccountTypesForList()->fetch();

        $has = false;
        foreach ($accountTypes as $accountType)
        {
            if ($accountType->user_upgrade_id == -1 || $accountType->version)
            {
                $has = true;
                break;
            }
        }

        if (!$has)
        {
            $this->em()->create('AddonFlare\PaidRegistrations:AccountType')->save();
            $accountTypes = $accountTypeRepo->findActiveAccountTypesForList()->fetch();
        }

        $accountTypes = $accountTypeRepo->filterPurchasable($accountTypes, true);

        $accountTypeRows = $accountTypes->groupBy('row');

        ksort($accountTypeRows);

        $viewParams = [
            'accountTypeRows' => $accountTypeRows,
        ];

        return $this->view('', 'af_paidregistrations_accounttype', $viewParams);
    }

    public function actionPurchase()
    {
        $accountTypeId = $this->filter('accountType', 'uint');

        $accountType = $this->getAccountType($accountTypeId);

        if (!$accountType || !$accountType->canPurchase())
        {
            return $this->error(\XF::phrase('af_paidregistrations_invalid_accountType'));
        }

        // guest purchases are only supported by supported payment providers
        $profiles = $this->getAccountTypeRepo()->getPaymentProfileTitlePairs(true);

        $aliasUpgrades = [];

        if (!$accountType->allow_custom_amount && $accountType->alias_user_upgrades)
        {
            $aliasUserUpgradeIds = array_column($accountType->alias_user_upgrades, 'user_upgrade_id');
            // add the main/parent user_upgrade_id
            $aliasUserUpgradeIds[] = $accountType->user_upgrade_id;

            $upgradeRepo = $this->repository('XF:UserUpgrade');
            $aliasUpgrades = $upgradeRepo->findUserUpgradesForList()
                ->where('can_purchase', '=', 1)
                ->whereIds($aliasUserUpgradeIds)
            ->fetch();
        }

        $coupons = $hasCoupons = false;

        $viewParams = [
            'accountType'       => $accountType,
            'upgrade'           => $accountType->UserUpgrade,
            'profiles'          => $profiles,
            'aliasUpgrades'     => $aliasUpgrades,
            'isRegistration'    => true,
            'hasOnlyPayPal'     => false, // never true for guests, they need to fill out email field
            'allowCustomAmount' => $accountType->allow_custom_amount,
            'coupons'           => $coupons,
            'hasCoupons'        => $hasCoupons,
        ];

        return $this->view('', 'af_paidregistrations_purchase', $viewParams);
    }

    public function actionRegister()
    {
        if (!$this->options()->af_paidregistrations_guest)
        {
            return parent::actionRegister();
        }

        $purchaseRequest = null;

        if ($purchaseRequestKey = $this->filter('prk', 'str'))
        {
            $purchaseRequest = $this->em()->findOne('XF:PurchaseRequest', [
                'request_key' => $purchaseRequestKey,
                'user_id'     => 0,
                'purchasable_type_id' => 'user_upgrade',
            ]);

            if ($purchaseRequest && !empty($purchaseRequest->extra_data['email']))
            {
                $this->assertPaidRegistrationEmailNotRegistered($purchaseRequest->extra_data['email']);
            }
        }

        $accountTypeRepo = $this->getAccountTypeRepo();

        $freeAccountTypes = $accountTypeRepo->findActiveAccountTypesForList()
        ->where('user_upgrade_id', '=', -1)->fetch();

        if (!$purchaseRequest && !$freeAccountTypes->count())
        {
            if ($accountTypeRepo->filterPurchasable($accountTypeRepo->findActiveAccountTypesForList()->fetch())->count())
            {
                // there's no valid purchase request and there's no free account type and we have at least one active account type the guest could've used to register
                return $this->error(\XF::phrase('invalid_purchase_request'));
            }
        }

        // make sure the same email is being used to register
        if ($this->options()->af_paidregistrations_force_same_email && $purchaseRequest && !empty($purchaseRequest->extra_data['email']))
        {
            $regForm = $this->service('XF:User\RegisterForm', $this->session());
            if ($purchaseRequest->extra_data['email'] != $this->filter($regForm->getFieldName('email'), 'str'))
            {
                return $this->error(\XF::phrase('af_paidregistrations_must_use_same_email', ['email' => $purchaseRequest->extra_data['email']]));
            }
        }

        // process normal registration
        $reply = parent::actionRegister();

        $visitor = \XF::visitor();

        // if registration was successful & we have a purchase request, link it to the new user
        if ($visitor->user_id && $purchaseRequest)
        {
            $purchaseRequest->fastUpdate('user_id', $visitor->user_id);

            $this->app->jobManager()->enqueueUnique('PaidRegistrationsGuestPurchases', 'AddonFlare\PaidRegistrations:GuestPurchases', [], false);

            if ($reply instanceof \XF\Mvc\Reply\Redirect)
            {
                // add support for 3rd party extensions to pass the purchaseRequest variable to them
                $reply->setPageParam('afpr_purchaseRequest', $purchaseRequest);
            }
        }

        return $reply;
    }

    protected function getAccountTypeRepo()
    {
        return $this->repository('AddonFlare\PaidRegistrations:AccountType');
    }

    protected function getAccountType($accountTypeId)
    {
        $accountType = $this->getAccountTypeRepo()->findActiveAccountTypesForList()
            ->where('account_type_id', '=', $accountTypeId)
        ->fetchOne();

        return $accountType;
    }

    protected function assertPaidRegistrationEmailNotRegistered($email)
    {
        if ($existingUser = \XF::finder('XF:User')->where('email', $email)->fetchOne())
        {
            throw $this->exception($this->error(\XF::phrase('af_paidregistrations_already_registered_username_x', ['username' => $existingUser['username']])));
        }

        return true;
    }
}