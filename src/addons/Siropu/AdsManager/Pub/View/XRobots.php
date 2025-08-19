<?php

namespace Siropu\AdsManager\Pub\View;

class XRobots extends \XF\Mvc\View
{
     public function renderHtml()
	{
          $this->response->header('X-Robots-Tag', 'none');
     }
}
