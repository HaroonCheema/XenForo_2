<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Pub\Controller;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class ProjectTask extends XFCP_ProjectTask
{
    /**
     * @param \XenConcept\ProjectManager\Entity\ProjectTask|\SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectTask $project
     * @return \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectTask\Edit|\XenConcept\ProjectManager\Service\ProjectTask\Edit
     */
    protected function setupTaskEdit(\XenConcept\ProjectManager\Entity\ProjectTask $task)
    {
        $originalPrefixes = \array_fill_keys(MultiPrefixable::getPreviousPrefixIds($task), true);
        $task->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $task->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectTask\Edit $editor */
        $editor = parent::setupTaskEdit($task);

        $prefixIds = $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds as $key => $prefixId)
            {
                if (!$prefixId || (empty($originalPrefixes[$prefixId]) && !$task->Project->isPrefixUsable($prefixId)))
                {
                    unset($prefixIds[$key]);
                }
            }

            $editor->setPrefixIds($prefixIds);
        }

        return $editor;
    }

    /**
     * @param ParameterBag $params
     *
     * @return \XF\Mvc\Reply\Redirect|View
     */
    public function actionEdit(ParameterBag $params)
    {
        $response = parent::actionEdit($params);

        if ($response instanceof View)
        {
            /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectTask $task */
            $task = $response->getParam('task');

            /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem $category */
            $project = $response->getParam('project');
            if ($task && !$project)
            {
                $project = $task->Project;
            }

            if ($task && $project)
            {
                $prefixes = $task->sv_prefix_ids;
                $prefixes = $project->getMultipleUsablePrefixes($prefixes);

                $response->setParam('prefixes', $prefixes);
            }
        }

        return $response;
    }
}