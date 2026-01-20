<?php

namespace FS\PostPrefix\Template;
use FS\PostPrefix\Helper;

class TemplaterSetup
{

    public function fnIsApplicableForum(\XF\Template\Templater $templater, &$escape, \XF\Entity\Forum $forum)
    {
        return Helper::isApplicableForum($forum);
    }
}