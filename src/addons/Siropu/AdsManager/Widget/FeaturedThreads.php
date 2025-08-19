<?php

namespace Siropu\AdsManager\Widget;

class FeaturedThreads extends \XF\Widget\AbstractWidget
{
	protected $defaultOptions = [
          'limit' => 10,
          'order' => 'lastPostDate'
     ];

	public function render()
	{
          if (!\XF::options()->siropuAdsManagerFeaturedThreadsWidget)
          {
               return;
          }

          $widgetsCache = $this->repository('Siropu\AdsManager:Ad')->getWidgetsCache();

          if (empty($widgetsCache['threadIds']))
          {
               return;
          }

          switch ($this->options['order'])
          {
               case 'random':
                    $order = 'RAND()';
                    break;
               case 'lastPostDate':
               default:
                    $order = ['last_post_date', 'DESC'];
                    break;
          }

          $featuredThreads = $this->finder('XF:Thread')
               ->where('thread_id', $widgetsCache['threadIds'])
               ->order($order)
               ->limit($this->options['limit'])
               ->fetch();

          if (!$featuredThreads->count())
          {
               return;
          }

          $params = [
               'featuredThreads' => $featuredThreads,
               'title'           => $this->getTitle() ?: \XF::phrase('siropu_ads_manager_widget_featured_threads')
          ];

          return $this->renderer('siropu_ads_manager_widget_featured_threads', $params);
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
