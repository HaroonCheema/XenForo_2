<?php

namespace XenBulletins\BrandHub\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class QuickReview extends AbstractController
{
        protected function preDispatchController($action, ParameterBag $params)
	{
            if (!\XF::visitor()->user_id)  throw $this->exception($this->noPermission());
	}

	public function actionIndex(ParameterBag $params)
	{        
                $brands = $this->Finder('XenBulletins\BrandHub:Brand');
        
                $defaultOrder = $this->options()->bh_brandListDefaultOrder;
                $defaultDir =  'desc'; 
                
                $brands = $brands->order($defaultOrder, $defaultDir)->fetch();

		$viewParams = [
			'brands' => $brands
		];
                
		return $this->view('XenBulletins\BrandHub:QuickReview', 'bh_quick_review', $viewParams);
	}
        
        
        public function actionGetBrandItems(ParameterBag $params)
	{        
            $brandId = $this->filter('brandId', 'uint');
            
            if(!$brandId)
            {
               	throw $this->exception($this->notFound(\XF::phrase('bh_brand_id_not_found')));
            }
            
            $defaultOrder = $this->options()->bh_dropdownItemListDefaultOrder ?: 'item_title';
            $defaultDir =   'DESC';
               
            
            $items = $this->Finder('XenBulletins\BrandHub:Item')->where('brand_id',$brandId)->order($defaultOrder, $defaultDir)->pluckFrom('item_title','item_id')->fetch()->toArray();

//            $sql = 'Select item_id, item_title from bh_item where brand_id = '.$brandId;
//        $db = \XF::db();
//        $items = $db->fetchPairs($sql);
        
            $this->setResponseType('json');

            $view = $this->view();
            $view->setJsonParam('items', $items);
            return $view; 
	}
        
        
        
        
        public function actionItemContent(ParameterBag $params)
	{        
            $visitor = \XF::visitor();
            $itemId = $this->filter('itemId', 'uint');
            
            if(!$itemId)
            {
               	throw $this->exception($this->notFound(\XF::phrase('bh_item_id_not_found')));
            }

            $item = $this->em()->find('XenBulletins\BrandHub:Item', $itemId);
            
            if(!$item)
            {
               	throw $this->exception($this->notFound(\XF::phrase('bh_requested_item_not_found')));
            }
            
            $ratingRepo = $this->getRatingRepo();
            $itemReview = $ratingRepo->findReviewsInItem($item)->where('user_id', $visitor->user_id)->fetchOne();
           

            $viewParams = [
                    'item' => $item,
                    'itemReview' => $itemReview,
            ];

            return $this->view('XenBulletins\BrandHub:QuickReview', 'bh_quick_review_content', $viewParams);
	}
        


	protected function getRatingRepo()
	{
            return $this->repository('XenBulletins\BrandHub:ItemRating');
	}
}