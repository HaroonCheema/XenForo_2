<?php

namespace Siropu\AdsManager\Pub\View;

class Image extends \XF\Mvc\View
{
     public function renderHtml()
	{
          $this->response->removeHeader('X-Frame-Options');
          $this->response->header('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

          $ad = $this->params['ad'];

          if ($ad && $ad->isActive() && $ad->hasBanner())
          {
               $file = $ad->getBanner();

               if ($ad->canCountViews())
               {
                    $ad->countView();
                    $ad->save(false);
               }

               $position = \XF::app()->request()->filter('p', 'uint') == 1 ? 'mail_above_content' : 'mail_below_content';

               if ($ad->settings['daily_stats'])
               {
                    \XF::repository('Siropu\AdsManager:DailyStats')->logAction($ad, 'view', $position);
               }
          }
          else
          {
               $file = 'data/siropu/am/notfound.png';
          }

          $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
          $this->response->contentType("image/$fileExtension");

          readfile($file);
     }
}
