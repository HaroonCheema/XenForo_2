<?php

namespace FS\ReviewSystem\BbCode;
use XF\PreEscaped;

class RosTag
{
    public static function renderTagRos($tagChildren, $tagOption, $tag, array $options, \XF\BbCode\Renderer\AbstractRenderer $renderer)
    {
        
//        $content = $renderer->renderSubTreePlain($tagChildren);
        $content = $renderer->renderSubTree($tagChildren, $options);
        
        if ($content === '')
        {
            return '';
        } 

        
        $visitor = \XF::visitor();
        $options = \XF::options();
        
        $hideButtonUserGroupIds = $options->rs_hide_button_userGroups;

        
        
        $viewParams = [
            'canViewRosContent' => $visitor->isMemberOf($hideButtonUserGroupIds),
            'content' => new PreEscaped($content)
        ];

        return $renderer->getTemplater()->renderTemplate('public:rs_ros_content', $viewParams);
    }
}