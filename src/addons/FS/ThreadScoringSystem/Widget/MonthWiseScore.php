<?php

namespace FS\ThreadScoringSystem\Widget;

use XF\Widget\AbstractWidget;

class MonthWiseScore extends AbstractWidget
{
    public function render()
    {

        $orderBy = \XF::options()->fs_thread_scoring_list_order;
        $minimumPoints = \XF::options()->fs_total_users_minimum_points;
        $listLimit = \XF::options()->fs_thread_scoring_system_notable_perpage;

        $records = \XF::finder('FS\ThreadScoringSystem:TotalScoringCustom')->where('user_id', '!=', 0)->where('total_score', '>=', $minimumPoints)->limitByPage(1, $listLimit)->order('total_score', $orderBy)->fetch();

        $viewParams = [
            'data' => count($records) ? $records : [],
        ];

        return $this->renderer('widget_fs_thread_scoring_monthly_score', $viewParams);
    }

    public function getOptionsTemplate()
    {
        return null;
    }
}