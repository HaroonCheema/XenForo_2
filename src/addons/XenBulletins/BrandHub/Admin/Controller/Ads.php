<?php

namespace XenBulletins\BrandHub\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;


class Ads extends AbstractController
{
    
//        protected function preDispatchController($action, ParameterBag $params)
//	{
//		$this->assertAdminPermission('brandhub');
//	}
        
       public function actionIndex()
       {
            
            return $this->view('XenBulletins\BrandHub:Ads', 'bh_ads', $viewParams=[]);
       }

        public function actionEdit(ParameterBag $params)
        {   
            $templateTitle = $this->filter('template_title', 'str');
            $locationName = $this->filter('location_name', 'str');
            
            if(!$templateTitle)
            {
                throw $this->exception($this->notFound());
            }
 
            $adTemplate = $this->findAdTemplate($templateTitle);
          
              $viewParams = [
                        
                  'locationName' => $locationName,
                  'adTemplate' => $adTemplate
                  
                ];

            return $this->view('XenBulletins\BrandHub:Ads', 'bh_ads_edit', $viewParams);

        }



	public function actionSave(ParameterBag $params)
	{       
            $this->assertPostOnly();
            
            $templateTitle = $this->filter('template_title', 'str');
            $templateCode = $this->filter('template_code', 'str');
            
            if(!$templateTitle)
            {
                throw $this->exception($this->notFound());
            }
            
            
            $adTemplate = $this->findAdTemplate($templateTitle);

            if($adTemplate)
            {
                       
                $adTemplate->template = $templateCode;
                $adTemplate->save();
            }
            
            return $this->redirect($this->buildLink('bh-ads'));
	}

        
        public function findAdTemplate($templateTitle)
        {

            $styleId =  \XF::visitor()->style_id; 
            $type = 'public';
            
            $adTemplate = $this->finder('XF:Template')->where([
                                    'style_id' => $styleId,
                                    'title' => $templateTitle,
                                    'type' => $type
                            ])->fetchOne();
            
            if (!$adTemplate)
            {
                $phraseKey = 'requested_page_not_found';

                throw $this->exception(
                        $this->notFound(\XF::phrase($phraseKey))
                );
            }
            
            return $adTemplate;

        }

}