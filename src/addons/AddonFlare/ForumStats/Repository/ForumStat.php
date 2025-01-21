<?php

namespace AddonFlare\ForumStats\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class ForumStat extends Repository
{
    public function findForumStatsForList($activeOnly = false)
    {
        $finder = $this->finder('AddonFlare\ForumStats:ForumStat')
            ->with('ForumStatDefinition', true)
            ->order('active', 'DESC')
            ->order('display_order', 'ASC');

        if ($activeOnly)
        {
            $finder->where('active', 1);
        }

        return $finder;
    }

    public function canViewStats(\XF\Entity\User $user = null)
    {
        $user = $user ?: \XF::visitor();
        $ugs = $this->app()->options()->af_forumstats_ugs_allowed;

        return $user->isMemberOf($ugs);
    }

    public function getForumStatsForDisplay()
    {
        $simpleCache = $this->app()->simpleCache();

        $forumStatDefinitionCache = $simpleCache['AddonFlare/ForumStats']['forumStatDefinition'];

        if ($forumStatDefinitionCache === null)
        {
            $forumStatDefinitionCache = $this->rebuildForumStatDefinitionCache();
        }

        $forumStatCache = $simpleCache['AddonFlare/ForumStats']['forumStat'];

        if ($forumStatCache === null)
        {
            $forumStatCache = $this->rebuildForumStatCache();
        }

        $positions = $first = [];

        foreach ($forumStatCache as $position => $forumStatsInPosition)
        {
            foreach ($forumStatsInPosition as $forumStat)
            {
                $relations = [];
                if (isset($forumStatDefinitionCache[$forumStat['definition_id']]))
                {
                    $relations['ForumStatDefinition'] = $this->em->instantiateEntity('AddonFlare\ForumStats:ForumStatDefinition', $forumStatDefinitionCache[$forumStat['definition_id']]);
                }
                $positions[$position][$forumStat['stat_id']] = $this->em->instantiateEntity('AddonFlare\ForumStats:ForumStat', ['stat_id' => $forumStat['stat_id']], $relations);
                $positions[$position][$forumStat['stat_id']]->bulkSet($forumStat, ['skipInvalid' => true]);
            }
        }

        // pre-fetch first tab data and results
        foreach ($positions as $position => $forumStatsInPosition)
        {
            $first[$position] = reset($forumStatsInPosition);
        }

        $results = [
            'positions' => $positions,
            'first'     => $first,
        ];

        return $results;
    }

    public function renderForumStats($context = '')
    {
        $options = $this->options();

        if (!$this->canViewStats() || ($context && $context != $options->af_forumstats_position))
        {
            return '';
        }

        $templateName = 'public:af_forumstats_stats';

        $params = [
            'forumStats' => $this->getForumStatsForDisplay(),
        ];

        return $this->app()->templater()->renderTemplate(
            $templateName, $params
        );
    }

    public function getForumStatCache()
    {
        $forumStats = $this->findForumStatsForList(true)->fetch();

        $positions = [];

        foreach ($forumStats as $forumStat)
        {
            $positions[$forumStat->position][$forumStat->stat_id] = [
                'stat_id'       => $forumStat->stat_id,
                'definition_id' => $forumStat->definition_id,
                'position'      => $forumStat->position,
                'display_order' => $forumStat->display_order,
                'options'       => $forumStat->options,
                'active'        => $forumStat->active,
                'custom_title'  => $forumStat->custom_title,
            ];
        }

        return $positions;
    }

    public function rebuildForumStatCache()
    {
        $cache = $this->getForumStatCache();

        $simpleCache = $this->app()->simpleCache();
        $simpleCache['AddonFlare/ForumStats']['forumStat'] = $cache;

        return $cache;
    }

    public function getForumStatDefinitionCache()
    {
        $output = [];

        $forumStatDefinitions = $this->finder('AddonFlare\ForumStats:ForumStatDefinition')
            ->order('definition_id');

        foreach ($forumStatDefinitions->fetch() AS $forumStat)
        {
            $output[$forumStat->definition_id] = [
                'definition_id'    => $forumStat->definition_id,
                'definition_class' => $forumStat->definition_class,
            ];
        }

        return $output;
    }

    public function rebuildForumStatDefinitionCache()
    {
        $cache = $this->getForumStatDefinitionCache();

        $simpleCache = $this->app()->simpleCache();
        $simpleCache['AddonFlare/ForumStats']['forumStatDefinition'] = $cache;

        \XF::runOnce('addonFlareForumStatCacheRebuild', function()
        {
            $this->rebuildForumStatCache();
        });

        return $cache;
    }
}