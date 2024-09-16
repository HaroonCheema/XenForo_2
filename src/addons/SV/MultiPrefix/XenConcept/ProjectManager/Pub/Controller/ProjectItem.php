<?php

namespace SV\MultiPrefix\XenConcept\ProjectManager\Pub\Controller;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use SV\MultiPrefix\Listener;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class ProjectItem extends XFCP_ProjectItem
{
    /**
     * @param \XenConcept\ProjectManager\Entity\ProjectItem|\SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem $project
     * @return \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectItem\Edit|\XenConcept\ProjectManager\Service\ProjectItem\Edit
     */
    protected function setupProjectEdit(\XenConcept\ProjectManager\Entity\ProjectItem $project)
    {
        $originalPrefixes = \array_fill_keys(MultiPrefixable::getPreviousPrefixIds($project), true);
        $project->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $project->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectItem\Edit $editor */
        $editor = parent::setupProjectEdit($project);

        $prefixIds = $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds as $key => $prefixId)
            {
                if (!$prefixId || (empty($originalPrefixes[$prefixId]) && !$project->Category->isPrefixUsable($prefixId)))
                {
                    unset($prefixIds[$key]);
                }
            }

            $editor->setPrefixIds($prefixIds);
        }

        return $editor;
    }

    /**
     * @param \XenConcept\ProjectManager\Entity\ProjectItem|\SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem $project
     * @param \XenConcept\ProjectManager\Entity\Category|\SV\MultiPrefix\XenConcept\ProjectManager\Entity\Category $category
     * @return \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectItem\Move|\XenConcept\ProjectManager\Service\ProjectItem\Move
     */
    protected function setupProjectMove(\XenConcept\ProjectManager\Entity\ProjectItem $project, \XenConcept\ProjectManager\Entity\Category $category)
    {
        if (empty(\XF::options()->svStripPrefixOnContainerChange))
        {
            $project->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
            $project->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);
        }

        /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectItem\Move $mover */
        $mover = parent::setupProjectMove($project, $category);

        $prefixIds = $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            $mover->setPrefixIds($prefixIds);
        }

        return $mover;
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
            /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem $project */
            $project = $response->getParam('project');

            /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Entity\Category $category */
            $category = $response->getParam('category');
            if ($project && !$category)
            {
                $category = $project->Category;
            }

            if ($project && $category)
            {
                $prefixes = $project->sv_prefix_ids;
                $prefixes = $category->getMultipleUsablePrefixes($prefixes);

                $response->setParam('prefixes', $prefixes);
            }
        }

        return $response;
    }

    /**
     * @param ParameterBag $params
     *
     * @return \XF\Mvc\Reply\Error|\XF\Mvc\Reply\Redirect|View
     */
    public function actionMove(ParameterBag $params)
    {
        $response = parent::actionMove($params);

        if ($response instanceof View)
        {
            /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Entity\ProjectItem $project */
            $project = $response->getParam('project');

            /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Entity\Category $category */
            $category = $response->getParam('category');
            if ($project && !$category)
            {
                $category = $project->Category;
            }

            if ($project && $category)
            {
                $prefixes = $project->sv_prefix_ids;
                $prefixes = $category->getMultipleUsablePrefixes($prefixes);

                $response->setParam('prefixes', $prefixes);
            }
        }

        return $response;
    }

    // SUPPORT PROJECT TASK

    /**
     * @param \SV\MultiPrefix\XenConcept\ProjectManager\Entity\Category $category
     * @return \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectTask\Create|\XenConcept\ProjectManager\Service\ProjectTask\Create
     */
    protected function setupProjectTaskCreate(\XenConcept\ProjectManager\Entity\ProjectItem $project)
    {
        /** @var \SV\MultiPrefix\XenConcept\ProjectManager\Service\ProjectTask\Create $creator */
        $creator = parent::setupProjectTaskCreate($project);
        Listener::$draftEntity = $task = $creator->getTask();
        $task->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentIgnoreMinPrefixLimit', false);
        $task->getBehavior('SV\MultiPrefix:MultiPrefixable')->setOption('silentApplyMaxPrefixLimit', false);

        $prefixIds = $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            foreach ($prefixIds AS $key => $prefixId)
            {
                if (!$prefixId || !$task->Project->isPrefixUsable($prefixId))
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
    public function actionPostTask(ParameterBag $params)
    {
        $response = parent::actionPostTask($params);

        if (false && $response instanceof View)
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