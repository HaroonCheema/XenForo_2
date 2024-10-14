<?php

namespace ThemeHouse\ThreadCredits\XF\Admin\Controller;

use ThemeHouse\ThreadCredits\Repository\CreditPackage;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class User extends XFCP_User
{
    public function actionExtra(ParameterBag $params)
    {
        $response = parent::actionExtra($params);
        if($response instanceof  View) {
            /** @var \XF\Entity\User $user */
            $user = $response->getParam('user');

            /** @var CreditPackage $repo */
            $repo = $this->repository('ThemeHouse\ThreadCredits:CreditPackage');
            $userCreditPackages = $repo->findUserCreditPackagesForUser($user)
                ->with('CreditPackage')->with('PurchaseRequest')
                ->limit(25)
                ->fetch();
            $response->setParam('thtcCreditPackages', $userCreditPackages);
        }

        return $response;
    }
}
