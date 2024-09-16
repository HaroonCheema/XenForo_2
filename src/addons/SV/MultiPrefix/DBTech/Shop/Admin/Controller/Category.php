<?php

namespace SV\MultiPrefix\DBTech\Shop\Admin\Controller;

/**
 * Class Category
 *
 * @package SV\MultiPrefix\DBTech\Shop\Admin\Controller
 */
class Category extends XFCP_Category
{
	/**
	 * @param \DBTech\Shop\Entity\Category $category
	 *
	 * @return \XF\Mvc\FormAction
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function categorySaveProcess(\DBTech\Shop\Entity\Category $category): \XF\Mvc\FormAction
    {
		$form = parent::categorySaveProcess($category);
		
		$form->setup(function() use($category) {
			/** @var \SV\MultiPrefix\DBTech\Shop\Entity\Category $category */
			$category->sv_min_prefixes = $this->filter('sv_multiprefix_min_prefixes', 'uint');
			$category->sv_max_prefixes = $this->filter('sv_multiprefix_max_prefixes', 'uint');
			
			$threadPrefixIds = $this->filter('thread_prefix_id', 'array-uint');
			$category->thread_prefix_id = $threadPrefixIds ? \reset($threadPrefixIds) : 0;
		});
		
		return $form;
	}
}
