<?php

namespace Siropu\AdsManager\Pub\Controller;

use XF\Mvc\ParameterBag;

class Home extends AbstractController
{
     protected function preDispatchController($action, ParameterBag $params)
     {
          $this->assertCanCreateAds();
     }
     public function actionIndex(ParameterBag $params)
     {
          return $this->view('Siropu\AdsManager:Home', 'siropu_ads_manager_home');
     }
     public function actionEdit()
     {
          $visitor = \XF::visitor();

          if (!$visitor->is_admin)
          {
               return $this->noPermission();
          }

          if ($this->isPost())
          {
               $message = $this->plugin('XF:Editor')->fromInput('message');
               $this->repository('XF:Option')->updateOption('siropuAdsManagerHomeMessage', $message);

               return $this->redirect($this->buildLink('ads-manager'));
          }

          return $this->view('Siropu\AdsManager:Home\Edit', 'siropu_ads_manager_home_edit');
     }
     public function actionTermsAndConditions()
     {
          return $this->view('Siropu\AdsManager:Terms', 'siropu_ads_manager_terms_and_conditions');
     }
     public function actionTermsAndConditionsEdit()
     {
          $visitor = \XF::visitor();

          if (!$visitor->is_admin)
          {
               return $this->noPermission();
          }

          if ($this->isPost())
          {
               $message = $this->plugin('XF:Editor')->fromInput('message');
               $this->repository('XF:Option')->updateOption('siropuAdsManagerTermsAndConditions', $message);

               return $this->redirect($this->buildLink('ads-manager/terms-and-conditions'));
          }

          return $this->view('Siropu\AdsManager:Terms\Edit', 'siropu_ads_manager_terms_and_conditions_edit');
     }
     public function actionSuccess()
     {
          return $this->view('Siropu\AdsManager:Home\Success', 'siropu_ads_manager_success');
     }
}
