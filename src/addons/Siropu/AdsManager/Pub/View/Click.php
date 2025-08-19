<?php

namespace Siropu\AdsManager\Pub\View;

class Click extends \XF\Mvc\View
{
     public function renderHtml()
	{
          $ad = $this->params['ad'];

          if ($ad)
          {
               if ($ad->canCountClicks())
               {
                    $ad->countClick();
                    $ad->save(false);
               }

               $position = \XF::app()->request()->filter('p', 'uint') == 1 ? 'mail_above_content' : 'mail_below_content';

               if ($ad->settings['daily_stats'])
               {
                    \XF::repository('Siropu\AdsManager:DailyStats')->logAction($ad, 'click', $position);
               }

               $this->response->redirect($ad->target_url, 301);
          }
     }
}
