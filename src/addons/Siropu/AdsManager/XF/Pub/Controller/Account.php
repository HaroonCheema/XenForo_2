<?php

namespace Siropu\AdsManager\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Account extends XFCP_Account
{
     protected function preferencesSaveProcess(\XF\Entity\User $visitor)
	{
          $form = parent::preferencesSaveProcess($visitor);

          if ($visitor->canOptInViewAdsSiropuAdsManager())
          {
               $userOptions = $visitor->getRelationOrDefault('Option');
     		$form->setupEntityInput($userOptions, ['siropu_ads_manager_view_ads' => $this->filter('siropu_ads_manager_view_ads', 'bool')]);
          }

          return $form;
     }
}
