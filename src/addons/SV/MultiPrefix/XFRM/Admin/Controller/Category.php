<?php

namespace SV\MultiPrefix\XFRM\Admin\Controller;

/**
 * Class Category
 *
 * @package SV\MultiPrefix\XFRM\Admin\Controller
 */
class Category extends XFCP_Category
{
    /**
     * @param \XFRM\Entity\Category $category
     *
     * @return \XF\Mvc\FormAction
     */
    protected function categorySaveProcess(\XFRM\Entity\Category $category)
    {
        $form = parent::categorySaveProcess($category);

        $form->setup(function() use($category) {
            /** @var \SV\MultiPrefix\XFRM\Entity\Category $category */
            $category->sv_min_prefixes = $this->filter('sv_multiprefix_min_prefixes', 'uint');
            $category->sv_max_prefixes = $this->filter('sv_multiprefix_max_prefixes', 'uint');

            $threadPrefixIds = $this->filter('thread_prefix_id', 'array-uint');
            $category->sv_thread_prefix_ids = $threadPrefixIds;
        });

        return $form;
    }
}
