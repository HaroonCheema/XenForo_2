<?php

namespace FS\WelcomeBanner\Widget;

use XF\Widget\AbstractWidget;

class WelcomeBanner extends AbstractWidget
{
    public function render()
    {
        $threadIds = explode(",", \XF::app()->options()->fs_welcome_banner_applicable_threads);

        $threads = $this->finder('XF:Thread')->where('thread_id', $threadIds)->fetch();

        $viewParams = [
            'threads' => $threads,
        ];

        return $this->renderer('welcome_banner_thread_list', $viewParams);
    }

    public function getOptionsTemplate()
    {
        return null;
    }
}
