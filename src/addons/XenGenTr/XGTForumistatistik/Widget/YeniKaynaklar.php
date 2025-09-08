<?php

namespace XenGenTr\XGTForumistatistik\Widget;

class YeniKaynaklar extends AbstractForumIstatistik
{
    protected $defaultOptions = [
        'limit' => 5,
        'resource_category_ids' => [],
        'excluded_resource_category_ids' => [],
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
        $limit = \XF::options()->xgtIstatistikGosterimLimiti;
        $categoryIds = $options['resource_category_ids'];
        $excludedCategoryIds = $options['excluded_resource_category_ids'];

        /** @var \XFRM\Finder\ResourceItem $finder */
        $finder = $this->finder('XFRM:ResourceItem');
        $finder
            ->where('resource_state', 'visible')
            ->with('User')
            ->with('Category.Permissions|' . $visitor->permission_combination_id)
            ->order('last_update', 'desc');

        if ($categoryIds && !in_array(0, $categoryIds))
        {
            $finder->where('resource_category_id', $categoryIds);
        }

        $resources = $finder->fetch(max($limit * 2, 10));

        /** @var \XFRM\Entity\ResourceItem $resource */
        foreach ($resources AS $resourceId => $resource)
        {
            if ((!$resource->canView())
                || $visitor->isIgnoring($resource->user_id)
            )
            {
                unset($resources[$resourceId]);
            }
        }

        $total = $resources->count();
        $resources = $resources->slice(0, $limit, true);

        $router = $this->app->router('public');
        $link = $router->buildLink('whats-new/resources', null, ['skip' => 1]);

        $viewParams = [
            'resources' => $resources,
        ];
        return $this->renderer('xgt_FrmIstatistik_yeniKaynaklar', $viewParams);
    }

    public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = null)
    {
        $options = $request->filter([
            'limit'                          => 'uint',
            'resource_category_ids'          => 'array-uint',
            'excluded_resource_category_ids' => 'array-uint',
        ]);

        if ($options['limit'] < 1)
        {
            $options['limit'] = 1;
        }

        return true;
    }
}