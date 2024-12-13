<?php

namespace FS\YtVideoSlider\Widget;

use XF\Widget\AbstractWidget;

class YtVideos extends AbstractWidget
{
    public function render()
    {
        $ytVideos = \XF::finder('FS\YtVideoSlider:Video')->order('video_id', 'desc')->fetch();

        $viewParams = [
            'data' => count($ytVideos) ? $ytVideos : [],
        ];

        return $this->renderer('fs_yt_video_widget_slider', $viewParams);
    }

    public function getOptionsTemplate()
    {
        return null;
    }
}
