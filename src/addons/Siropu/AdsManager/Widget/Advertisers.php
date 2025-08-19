<?php

namespace Siropu\AdsManager\Widget;

class Advertisers extends \XF\Widget\AbstractWidget
{
     protected $defaultOptions = [
          'limit' => 10,
          'order' => 'registerDate'
     ];

	public function render()
	{
          if (!\XF::options()->siropuAdsManagerAdvertisersWidget)
          {
               return;
          }

          $widgetsCache = $this->repository('Siropu\AdsManager:Ad')->getWidgetsCache();

          if (empty($widgetsCache['advertiserIds']))
          {
               return;
          }

          switch ($this->options['order'])
          {
               case 'random':
                    $order = 'RAND()';
                    break;
               case 'alphabetically':
                    $order = ['username', 'ASC'];
                    break;
               case 'registerDate':
               default:
                    $order = ['register_date', 'ASC'];
                    break;
          }

          $advertisers = $this->finder('XF:User')
               ->where('user_id', $widgetsCache['advertiserIds'])
               ->order($order)
               ->limit($this->options['limit'])
               ->fetch();

          if (!$advertisers->count())
          {
               return;
          }

          $advertiserList = [];

          foreach ($advertisers as $advertiser)
          {
               $advertiserList[$advertiser->user_id] = $advertiser;
          }

          $params = [
               'advertisers' => $advertiserList,
               'title'       => $this->getTitle() ?: \XF::phrase('siropu_ads_manager_widget_advertisers')
          ];

          return $this->renderer('siropu_ads_manager_widget_advertisers', $params);
	}
	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
	{
          $options = $request->filter([
               'limit' => 'uint',
               'order' => 'str'
          ]);

		return true;
	}
}
