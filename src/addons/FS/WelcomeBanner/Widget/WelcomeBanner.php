<?php

namespace FS\WelcomeBanner\Widget;

use XF\Widget\AbstractWidget;

class WelcomeBanner extends AbstractWidget
{
    public function render()
    {
        $optionThreadIds = \XF::app()->options()->fs_welcome_banner_applicable_threads;
        $threadIds = explode(",", $optionThreadIds);

        $threadFinder = $this->finder('XF:Thread')->where('thread_id', $threadIds);
        $threadFinder = $threadFinder->order($threadFinder->expression('FIELD(thread_id,' . $optionThreadIds . ')'))->fetch();

        $viewParams = [
            'threads' => $threadFinder,
        ];

        return $this->renderer('welcome_banner_thread_list', $viewParams);
    }

    public function getOptionsTemplate()
    {
        return null;
    }
}
