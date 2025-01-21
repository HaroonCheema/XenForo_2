<?php

namespace AddonFlare\ForumStats\ForumStat;

class TopResources extends AbstractForumStat
{
    protected $defaultOptions = [
        'limit' => 5,
        'resource_category_ids' => [],
        'excluded_resource_category_ids' => [],
        'prefix' => 'html',
        'ignore_view_perms' => false,
        'show_counter' => false,
    ];

    protected function getDefaultTemplateParams($context)
    {
        $params = parent::getDefaultTemplateParams($context);
        if ($context == 'options')
        {
            $categoryRepo = $this->app->repository('XFRM:Category');
            $params['categoryTree'] = $categoryRepo->createCategoryTree($categoryRepo->findCategoryList()->fetch());
        }
        return $params;
    }

    public function render()
    {
        /** @var \XFRM\XF\Entity\User $visitor */
        $visitor = \XF::visitor();
        if (!method_exists($visitor, 'canViewResources') || !$visitor->canViewResources())
        {
            return '';
        }

        $options = $this->options;
        $limit = $options['limit'];
        $categoryIds = $options['resource_category_ids'];
        $excludedCategoryIds = $options['excluded_resource_category_ids'];
        $ignoreViewPerms = $options['ignore_view_perms'];

        $hasCategoryIds = ($categoryIds && !in_array(0, $categoryIds));
        $hasCategoryContext = (
            isset($this->contextParams['category'])
            && $this->contextParams['category'] instanceof \XFRM\Entity\Category
        );
        $useContext = false;

        if (!$hasCategoryIds && $hasCategoryContext)
        {
            /** @var \XFRM\Entity\Category $category */
            $category = $this->contextParams['category'];
            $viewableDescendents = $category->getViewableDescendants();
            $sourceCategoryIds = array_keys($viewableDescendents);
            $sourceCategoryIds[] = $category->resource_category_id;

            $useContext = true;
        }
        else if ($hasCategoryIds)
        {
            $sourceCategoryIds = $categoryIds;
        }
        else
        {
            $sourceCategoryIds = null;
        }

        /** @var \XFRM\Finder\ResourceItem $finder */
        $finder = $this->repository('XFRM:ResourceItem')->findTopResources($sourceCategoryIds);

        if (!$useContext)
        {
            // with the context, we already fetched the category and permissions
            $finder->with('Category.Permissions|' . $visitor->permission_combination_id);
        }

        $resources = $finder->fetch(max($limit * 2, 10));

        /** @var \XFRM\Entity\ResourceItem $resource */
        foreach ($resources AS $resourceId => $resource)
        {
            if ((!$ignoreViewPerms && !$resource->canView())
                || $visitor->isIgnoring($resource->user_id)
                || $this->ignoreContentAddonIsIgnored($resource)
            )
            {
                unset($resources[$resourceId]);
            }
        }

        $total = $resources->count();
        $resources = $resources->slice(0, $limit, true);

        $viewParams = [
            'resources' => $resources,
        ];
        return $this->renderer('af_forumstats_top_resources', $viewParams);
    }

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        $options = $request->filter([
            'limit'                          => 'uint',
            'resource_category_ids'          => 'array-uint',
            'excluded_resource_category_ids' => 'array-uint',
            'prefix'                         => 'str',
            'ignore_view_perms'              => 'bool',
            'show_counter'                   => 'bool',
        ]);

        if ($options['limit'] < 1)
        {
            $options['limit'] = 1;
        }

        return true;
    }
}