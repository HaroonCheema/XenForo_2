<?php

namespace ThemeHouse\ThreadCredits\XF\Pub\Controller;

use ThemeHouse\ThreadCredits\Repository\CreditPackage;
use XF\Mvc\Reply\View;

class Account extends XFCP_Account
{
    public function actionThtcCreditPackagePurchase(): View
    {
        $view = $this->view('ThemeHouse\ThreadCredits:Account\CreditPackagePurchase', 'thtc_account_credit_package_purchase');
        return $this->addAccountWrapperParams($view, 'upgrades');
    }

    public function actionThtcCreditPackages(): View
    {
        $this->assertRegistrationRequired();

        $page = $this->filterPage();
        $perPage = 25;

        /** @var CreditPackage $repo */
        $repo = $this->repository('ThemeHouse\ThreadCredits:CreditPackage');
        $finder = $repo->findUserCreditPackagesForUser(\XF::visitor())
            ->limitByPage($page, $perPage)
            ->order('purchased_at', 'desc')
            ->with('CreditPackage');

        $available = $repo->findCreditPackagesForList()
            ->purchasableOnly()
            ->fetch();

        /** @var \XF\Repository\Payment $paymentRepo */
        $paymentRepo = $this->repository('XF:Payment');
        $profiles = $paymentRepo->getPaymentProfileOptionsData();

        $viewParams = [
            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),

            'available' => $available,
            'purchases' => $finder->fetch(),
            'profiles' => $profiles
        ];

        return $this->view('ThemeHouse\ThreadCredits:Account\CreditPackages', 'thtc_account_credit_packages', $viewParams);
    }
}
