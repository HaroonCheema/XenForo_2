<?php

namespace Siropu\AdsManager\XF\Criteria;

class Page extends XFCP_Page
{
     protected function _matchTemplate(array $data, \XF\Entity\User $user)
	{
		$params = $this->pageState;
          return isset($params['template']) && in_array($params['template'], \Siropu\AdsManager\Util\Arr::getItemArray($data['name']));
	}
}
