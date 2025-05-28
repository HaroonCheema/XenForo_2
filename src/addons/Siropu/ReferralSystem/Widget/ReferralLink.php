<?php

namespace Siropu\ReferralSystem\Widget;

use \XF\Widget\AbstractWidget;

class ReferralLink extends AbstractWidget
{
     protected $defaultOptions = [
          'currentPageLink' => true
	];

	public function render()
	{
          $options = \XF::options();
          $visitor = \XF::visitor();

		if ($options->siropuReferralSystemReferralLinkWidget && $visitor->hasPermission('siropuReferralSystem', 'refer'))
		{
			return $this->renderer('siropu_referral_system_referral_link_widget', [
				'title' => $this->getTitle()
			]);
		}
	}
     public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
			'currentPageLink' => 'bool'
		]);

		return true;
	}
}
