<?php

namespace XenBulletins\BrandHub\Pub\Controller;

use XF\Pub\Controller\AbstractController;
use XenBulletins\BrandHub\Entity;
use XF\Mvc\ParameterBag;


class Brands extends AbstractController
{
     
       public function actionIndex(ParameterBag $params)
       {    
           if($params->item_id)
           {
               return $this->rerouteController('XenBulletins\BrandHub\Pub\Controller\Item', 'index', $params);
           }
           
           if($params->brand_id)
           {
               return $this->rerouteController(__CLASS__, 'brand', $params);
           }
          
            $page = $this->filterPage();
            $perPage = \xf::options()->bh_makesPerPage;

            $brands = $this->Finder('XenBulletins\BrandHub:Brand');
            
            
            $filter = $this->filter('_xfFilter', [
                    'text' => 'str',
                    'prefix' => 'bool'
            ]);
            
            if (strlen($filter['text']))
            {
                $brands->where('brand_title', 'LIKE', $brands->escapeLike($filter['text'], $filter['prefix'] ? '?%' : '%?%'));
            }
            
            

            $total = $brands->total();
            $this->assertValidPage($page, $perPage, $total, \XF::options()->bh_main_route);
            $brands->limitByPage($page, $perPage);
            
            
            $filters = $this->getFilterInput();
            
            if($filters)
                $brands->order($filters['order'], $filters['direction']);
            else
            {
                $defaultOrder = $this->options()->bh_brandListDefaultOrder;
                $defaultDir =  'desc'; 
                
                $brands->order($defaultOrder, $defaultDir);
            }
                


            $viewParams = [

                    'brands' => $brands->fetch(),
                
                    'page' => $page,
                    'perPage' => $perPage,
                    'total' => $total,
                    'filters' => $filters
            ];

            return $this->view('XenBulletins\BrandHub:Brand', 'bh_brand_list', $viewParams);
       }
       
      
       
//        public function actionItem(ParameterBag $params)
//        { 
//            echo 'actionItem <pre>';
//            var_dump($params);exit;
//        }
       
       public function actionBrand(ParameterBag $params)
       {   
            $page = $this->filterPage();
          
            $perPage = \xf::options()->bh_itemsPerPage;

            $brandObj = $this->Finder('XenBulletins\BrandHub:Brand')->with('Description')->where('brand_id',$params->brand_id)->fetchOne();
            
            
//            $isPrefetchRequest = $this->request->isPrefetch();
//            
//            if (!$isPrefetchRequest)
//            {
//                    $brandRepo = $this->repository('XenBulletins\BrandHub:Brand');
//                    $brandRepo->logBrandView($brandObj);
//            }
            
            
            $items = $this->Finder('XenBulletins\BrandHub:Item')->where('brand_id',$params->brand_id);
            
            
            $filter = $this->filter('_xfFilter', [
                    'text' => 'str',
                    'prefix' => 'bool'
            ]);
            
            if (strlen($filter['text']))
            {
                $items->where('item_title', 'LIKE', $items->escapeLike($filter['text'], $filter['prefix'] ? '?%' : '%?%'));
            }
            

            $total = $items->total();
            $this->assertValidPage($page, $perPage, $total, \XF::options()->bh_main_route);
            $items->limitByPage($page, $perPage);
            
            
            $filters = $this->getFilterInput(true);            
            
            if($filters)
                $items->order($filters['order'], $filters['direction']);
            else
            {
                $defaultOrder = $this->options()->bh_itemListDefaultOrder;
                $defaultDir = 'desc'; 
                
                $items->order($defaultOrder, $defaultDir);
            }

            $viewParams = [

                    'items' => $items->fetch(),
                    'brandObj' => $brandObj,
                
                    'page' => $page,
                    'perPage' => $perPage,
                    'total' => $total,
                    'filters' => $filters
            ];

            return $this->view('XenBulletins\BrandHub:Brand', 'bh_item_list', $viewParams);
       }
       
       public function actionItem(ParameterBag $item)
       {
            return $this->noPermission();
       }
       
//*****************Edit Brand Description***************************************
       
        public function brandAddEdit($brand)
        {

            $viewParams = [
                'brand' => $brand
            ];

            return $this->view('XenBulletins\BrandHub:Category', 'bh_brand_description_edit', $viewParams);
        }

        public function actionEdit(ParameterBag $params)
        {
            $visitor = \XF::visitor();
           if(!$visitor->hasPermission('bh_brand_hub', 'bh_can_edit_brandDescript'))
           {
               throw $this->exception($this->noPermission());
           }
            $brand = $this->assertBrandExists($params->brand_id,'Description');

            return $this->brandAddEdit($brand);
        }
        
        protected function saveDescription(\XenBulletins\BrandHub\Entity\Brand $brand)
        {
            $message = $this->plugin('XF:Editor')->fromInput('description');
            
            $descEntity = $this->finder('XenBulletins\BrandHub:BrandDescription')->where('brand_id', $brand->brand_id)->fetchOne();
            if(!$descEntity)
            {
                $descEntity = $this->em()->create('XenBulletins\BrandHub:BrandDescription');
            }
            
            $descEntity->description = $message;
            $descEntity->brand_id = $brand->brand_id;
            $descEntity->save();
            
            return $descEntity;
        }
        
        public function actionSave(ParameterBag $params)
	{   
            $this->assertPostOnly();

            if ($params->brand_id)
            {
                $brand = $this->assertBrandExists($params->brand_id);
            }
            else
            {
                $brand = $this->em()->create('XenBulletins\BrandHub:Brand');
            }
            
            $descEntity = $this->saveDescription($brand);

            return $this->redirect($this->buildLink(\XF::options()->bh_main_route, $brand));
	}
        
        
        protected function assertBrandExists($id, $with = null, $phraseKey = null)
        {
                return $this->assertRecordExists('XenBulletins\BrandHub:Brand', $id, $with, $phraseKey);
        }
        
        
//***************************** Filters ****************************************************
        
        
        public function actionFilters(ParameterBag $params)
	{
		$filters = $this->getFilterInput();
                
                if ($params->brand_id)
                {
                    $brand = $this->assertBrandExists($params->brand_id);
                }
                else
                    $brand = null;

		
		$viewParams = [
			'brand' => $brand,
			'filters' => $filters,
                        'route' => \XF::options()->bh_main_route,
		];
		return $this->view('XenBulletins\BrandHub:Filters', 'bh_filters', $viewParams);
	}
        
        
        
        public function getFilterInput($brand=false): array
	{
		$filters = [];

		$input = $this->filter([
			'order' => 'str',
			'direction' => 'str'
		]);


		$sorts = $this->getAvailableSorts();

		if ($input['order'] && isset($sorts[$input['order']]))
		{
			if (!in_array($input['direction'], ['asc', 'desc']))
			{
				$input['direction'] = 'desc';
			}

                        if($brand)
                            $defaultOrder = $this->options()->bh_itemListDefaultOrder;
                        else
                            $defaultOrder = $this->options()->bh_brandListDefaultOrder;
			$defaultDir =  'desc';

			if ($input['order'] != $defaultOrder || $input['direction'] != $defaultDir)
			{
				$filters['order'] = $input['order'];
				$filters['direction'] = $input['direction'];
			}
		}
                
                

		return $filters;
	}
        
              
        public function getAvailableSorts(): array
	{
		// maps [name of sort] => field in/relative to brand entity
		return [
                        'item_id' => 'item_id',
			'item_title' => 'item_title',
                    
                        'brand_id' => 'brand_id',
			'brand_title' => 'brand_title',
                        'discussion_count' => 'discussion_count',
			'view_count' => 'view_count',
			'rating_avg' => 'rating_avg',
			'review_count' => 'review_count'
		];
	}
        
        
}