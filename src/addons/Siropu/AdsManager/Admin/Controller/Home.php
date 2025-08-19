<?php

namespace Siropu\AdsManager\Admin\Controller;

use XF\Mvc\ParameterBag;

class Home extends AbstractController
{
     public function actionIndex()
     {
          return $this->view('Siropu\AdsManager:Home', 'siropu_ads_manager_home');
     }
}
