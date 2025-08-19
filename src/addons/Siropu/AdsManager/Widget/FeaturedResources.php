<?php

namespace Siropu\AdsManager\Widget;

class FeaturedResources extends \XF\Widget\AbstractWidget
{
     protected $defaultOptions = [
          'limit' => 10,
          'order' => 'lastUpdate'
     ];

	public function render()
	{
          if (!\XF::options()->siropuAdsManagerFeaturedResourcesWidget)
          {
               return;
          }

          $widgetsCache = $this->repository('Siropu\AdsManager:Ad')->getWidgetsCache();

          if (empty($widgetsCache['resourceIds']))
          {
               return;
          }

          switch ($this->options['order'])
          {
               case 'random':
                    $order = 'RAND()';
                    break;
               case 'lastUpdate':
               default:
                    $order = ['last_update', 'DESC'];
                    break;
          }

          $featuredResources = $this->finder('XFRM:ResourceItem')
               ->where('resource_id', $widgetsCache['resourceIds'])
               ->order($order)
               ->limit($this->options['limit'])
               ->fetch();

          if (!$featuredResources->count())
          {
               return;
          }

          $params = [
               'featuredResources' => $featuredResources,
               'title'             => $this->getTitle() ?: \XF::phrase('siropu_ads_manager_widget_featured_resources')
          ];

          return $this->renderer('siropu_ads_manager_widget_featured_resources', $params);
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
