<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;
use SV\MultiPrefix\Listener;

class Category extends XFCP_Category
{
    /**
     * @param \SV\MultiPrefix\XenConcept\ProjectManager\Entity\Category $category
     * @return \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectItem\Create|\XenConcept\ProjectManager\Service\ProjectItem\Create
     */
    protected function setupProjectCreate(\XenConcept\ProjectManager\Entity\Category $category)
    {
        /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectItem\Create $creator */
        $creator = parent::setupProjectCreate($category);
        Listener::$draftEntity = $project = $creator->getProject();
        $project->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $project->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        $prefixIds = $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds AS $key => $prefixId)
            {
                if (!$prefixId || !$category->isPrefixUsable($prefixId))
                {
                    unset($prefixIds[$key]);
                }
            }

            $creator->setPrefixIds($prefixIds);
        }

        return $creator;
    }

    /**
     * @param ParameterBag $params
     * @return \XF\Mvc\Reply\Message
     */
    public function actionDraft(ParameterBag $params)
    {
        try
        {
            return parent::actionDraft($params);
        }
        finally
        {
            Listener::$draftEntity = null;
        }
    }

    /**
     * @param ParameterBag $params
     *
     * @return View
     */
    public function actionAdd(ParameterBag $params)
    {
        $response = parent::actionAdd($params);

        if ($response instanceof View)
        {
            /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Entity\Category $category */
            $category = $response->getParam('category');
            /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem $project */
            $project = $response->getParam('project');
            if ($project && !$category)
            {
                $category = $project->Category;
            }

            if ($project && $category)
            {
                $draft = $category->draft_project;
                $project->sv_prefix_ids = $draft->sv_prefix_ids ?? [];

                if (empty($project->sv_prefix_ids))
                {
                    $prefixId = $project->prefix_id;
                    if ($prefixId)
                    {
                        $project->sv_prefix_ids = [$prefixId];
                    }
                }
            }
        }

        return $response;
    }
}