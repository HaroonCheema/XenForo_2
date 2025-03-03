<?php

namespace AddonFlare\PaidRegistrations\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

use AddonFlare\PaidRegistrations\Listener;

class Purchase extends XFCP_Purchase
{
    // incase the general "view" permission is disallowed for guests, still give access to this controller
    public function assertViewingPermissions($action)
    {
        if ($this->options()->af_paidregistrations_guest)
        {
            return;
        }

        parent::assertViewingPermissions($action);
    }

    public function actionAfprAliasProfiles()
    {
        $this->assertPostOnly();
        $userUpgradeId = $this->filter('user_upgrade_id', 'uint');

        $userUpgrade = $this->assertRecordExists('XF:UserUpgrade', $userUpgradeId);
        $profiles = $this->repository('AddonFlare\PaidRegistrations:AccountType')->getPaymentProfileTitlePairs(!\XF::visitor()->user_id);

        $viewParams = [
            'upgrade'  => $userUpgrade,
            'profiles' => $profiles,
        ];

        return $this->view('', 'af_paidregistrations_profile_selectrow', $viewParams);
    }
}