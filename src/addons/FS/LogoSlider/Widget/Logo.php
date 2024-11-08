<?php

namespace FS\LogoSlider\Widget;

use XF\Widget\AbstractWidget;

class Logo extends AbstractWidget
{
    public function render()
    {
        $logos = \XF::finder('FS\LogoSlider:Logo')->order('id', 'desc')->fetch();

        $viewParams = [
            'data' => count($logos) ? $logos : [],
        ];

        return $this->renderer('fs_widget_logo_slider', $viewParams);
    }

    public function getOptionsTemplate()
    {
        return null;
    }
}
