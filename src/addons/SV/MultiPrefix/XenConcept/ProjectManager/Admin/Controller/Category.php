<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Admin\Controller;

/**
 * Class Category
 *
 * @package SV\MultiPrefix\XenConcept\ProjectManager\Admin\Controller
 */
class Category extends XFCP_Category
{
    /**
     * @param \XenConcept\ProjectManager\Entity\Category $category
     *
     * @return \XF\Mvc\FormAction
     */
    protected function categorySaveProcess(\XenConcept\ProjectManager\Entity\Category $category)
    {
        $form = parent::categorySaveProcess($category);

        $form->setup(function() use($category) {
            /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Entity\Category $category */
            $category->sv_min_project_prefixes = $this->filter('sv_min_project_prefixes', 'uint');
            $category->sv_max_project_prefixes = $this->filter('sv_max_project_prefixes', 'uint');
            $category->sv_min_task_prefixes = $this->filter('sv_min_task_prefixes', 'uint');
            $category->sv_max_task_prefixes = $this->filter('sv_max_task_prefixes', 'uint');


            $threadPrefixIds = $this->filter('thread_prefix_id', 'array-uint');
            $category->sv_thread_prefix_ids = $threadPrefixIds;
        });

        return $form;
    }
}
