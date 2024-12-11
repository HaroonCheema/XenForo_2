<?php

/*
 * Updated on 19.10.2020
 * HomePage: https://xentr.net
 * Copyright (c) 2020 XENTR | XenForo Add-ons - Styles -  All Rights Reserved
 */

namespace XDinc\FTSlider\Pub\Controller;

use XF\Pub\Controller\AbstractController;

class FTSliders extends AbstractController
{ 	

    public function actionIndex()
    {
        $visitor = \XF::visitor();
        if (!$visitor->hasPermission('FTSlider_permissions', 'FTSlider_view'))
        {
            throw $this->exception($this->noPermission());
        }

		$page = $this->filterPage();
		$perPage = $this->options()->FTSlider_perpage_count;

        /** @var \XDinc\FTSlider\Repository\FTSlider $repo */
		$ftsliderRepo = $this->app->repository('XDinc\FTSlider:FTSlider');

		$entries = $ftsliderRepo->findftslider();
	    $entries->limitByPage($page, $perPage);

		if (!$ftsliders = $entries->fetch())
		{
			return false;
		}
		
			$viewParams = [
				'ftsliders' => $entries->fetch(),
			    'total' => $entries->total(),
			    'page' => $page,
			    'perPage' => $perPage,
		];

        return $this->view('XDinc\FTSlider:FTSlider', 'FTSlider_page', $viewParams);
    }
}