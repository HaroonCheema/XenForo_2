<?php

namespace Siropu\ReferralSystem\Widget;

use \XF\Widget\AbstractWidget;

class TopReferrers extends AbstractWidget
{
     protected $defaultOptions = [
          'type'    => 'allTime',
          'compact' => true,
          'limit'   => 10
	];

	public function render()
	{
          $widgetKey = $this->widgetConfig->widgetKey;

		if (\XF::options()->siropuReferralSystemTopReferrersWidget)
		{
               if ($this->options['type'] == 'allTime')
               {
                    $topReferrers = $this->app->repository('XF:User')
                         ->findValidUsers()
                         ->where('siropu_rs_referral_count', '>', 0)
                         ->order('siropu_rs_referral_count', 'DESC')
                         ->limit($this->options['limit'])
                         ->fetch();
               }
               else
               {
                    $topReferrersCache = $this->getReferrerRepo()->getTopReferrersFromCache();

                    if (isset($topReferrersCache[$widgetKey]))
                    {
                         $referrers = $topReferrersCache[$widgetKey];
                    }
                    else
                    {
                         $referrers = $this->getReferrerRepo()->getTopReferrers();
                         $this->getReferrerRepo()->updateTopReferrersCache($widgetKey, $referrers);
                    }

                    $topReferrers = [];

                    \XF::em()->clearEntityCache('XF:User');

                    foreach ($referrers as $user)
                    {
                         $topReferrers[] = \XF::em()->instantiateEntity('XF:User', $user);
                    }
               }

			if (count($topReferrers))
			{
				return $this->renderer('siropu_referral_system_top_referrers_widget', [
					'topReferrers' => $topReferrers,
					'title'        => $this->getTitle()
				]);
			}
		}
	}
     public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
		$options = $request->filter([
               'type'    => 'str',
               'compact' => 'bool',
               'limit'   => 'uint'
		]);

		return true;
	}
     public function getReferrerRepo()
     {
          return $this->app->repository('Siropu\ReferralSystem:Referrer');
     }
}
