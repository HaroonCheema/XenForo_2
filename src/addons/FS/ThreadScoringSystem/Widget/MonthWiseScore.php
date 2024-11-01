<?php

namespace FS\ThreadScoringSystem\Widget;

use XF\Widget\AbstractWidget;

class MonthWiseScore extends AbstractWidget
{
    public function render()
    {

        $orderBy = \XF::options()->fs_thread_scoring_list_order;

        $records = \XF::finder('FS\ThreadScoringSystem:TotalScoringCustom')->order('total_score', $orderBy)->fetch();

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
