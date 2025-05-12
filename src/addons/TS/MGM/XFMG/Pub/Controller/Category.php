<?php

namespace TS\MGM\XFMG\Pub\Controller;

use XF\Mvc\ParameterBag;

class Category extends XFCP_Category {
	
	public function actionAdd(ParameterBag $params)
	{

		$parent = parent::actionAdd($params);
		
		$category = $this->assertViewableCategory($params->category_id);

		if (!$category->canAddMedia($error))
		{
			return $this->noPermission($error);
		}		
		
		if($parent instanceof \XF\Mvc\Reply\View) {
			
			$viewParams = $parent->getParams();
			$categoryRepo = $this->repository("XFMG:Category");
			$categoryList = $categoryRepo->getViewableCategories();
		
			$categoryTree = $categoryRepo->createCategoryTree($categoryList);
			$categoryExtras = $categoryRepo->getCategoryListExtras($categoryTree);
			$categoryAddTree = $categoryTree->filter(null, function($id, \XFMG\Entity\Category $category, $depth, $children, \XF\Tree $tree)
			{
				return ($children || $category->canAddMedia());
			});
			
			$additionalCategories = [];
			
			foreach($categoryAddTree as $subTree) {
				
				$cat = $subTree["record"];
				
				if($cat->category_id != $params->category_id)
					$additionalCategories[] = $cat;
				
					
				if($cat->hasChildren()) {
					
					foreach($categoryRepo->findChildren($cat) as $child) {
						if($child->canView() && $child->category_id != $params->category_id)
							$additionalCategories[] = $child;
					}
						
				}
					
			}
			
			$viewParams["additional"] = $additionalCategories;
			
			return $this->view('XFMG:Category\Add', 'xfmg_category_add', $viewParams);
			
		}
		
		return $parent;
	
	}
}