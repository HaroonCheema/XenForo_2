<?php

namespace SV\MultiPrefix\DBTech\eCommerce\Admin\Controller;

/**
 * Class Category
 *
 * @package SV\MultiPrefix\DBTech\eCommerce\Admin\Controller
 */
class Category extends XFCP_Category
{
	/**
	 * @param \DBTech\eCommerce\Entity\Category $category
	 *
	 * @return \XF\Mvc\FormAction
	 */
	protected function categorySaveProcess(\DBTech\eCommerce\Entity\Category $category): \XF\Mvc\FormAction
    {
		$form = parent::categorySaveProcess($category);
		
		$form->setup(function() use($category) {
			/** @var \SV\MultiPrefix\DBTech\eCommerce\Entity\Category $category */
			$category->sv_min_prefixes = $this->filter('sv_multiprefix_min_prefixes', 'uint');
			$category->sv_max_prefixes = $this->filter('sv_multiprefix_max_prefixes', 'uint');
			
			$threadPrefixIds = $this->filter('thread_prefix_id', 'array-uint');
			$category->thread_prefix_id = $threadPrefixIds ? \reset($threadPrefixIds) : 0;
		});
		
		return $form;
	}
}
