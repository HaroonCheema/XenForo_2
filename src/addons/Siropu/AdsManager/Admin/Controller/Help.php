<?php

namespace Siropu\AdsManager\Admin\Controller;

use XF\Mvc\ParameterBag;

class Help extends AbstractController
{
     public function actionIndex()
     {

     }
     public function actionGoogleAnalytics()
     {
          return $this->view('Siropu\AdsManager:Help\GoogleAnalytics', 'siropu_ads_manager_help_ga_statistics');
     }
     public function actionContentTemplateList()
     {
          return $this->view('Siropu\AdsManager:Help\ContentTemplateList', 'siropu_ads_manager_content_template_list');
     }
}
