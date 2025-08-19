<?php

namespace Siropu\AdsManager\Pub\View;

class Embed extends \XF\Mvc\View
{
     public function renderHtml()
	{
          $this->response->removeHeader('X-Frame-Options');
     }
}
