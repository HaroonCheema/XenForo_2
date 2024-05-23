<?php

namespace FS\PrivateBbcode\BbCode;
use XF\PreEscaped;

class PrivateTag
{
    public static function renderTagPrivate($tagChildren, $tagOption, $tag, array $options, \XF\BbCode\Renderer\AbstractRenderer $renderer)
    {
        
//        $content = $renderer->renderSubTreePlain($tagChildren);
        $content = $renderer->renderSubTree($tagChildren, $options);
        
        if ($content === '')
        {
            return '';
        } 
        
        
        $viewParams = [
            'content' => new PreEscaped($content)
        ];

        return $renderer->getTemplater()->renderTemplate('public:fs_pb_private_content', $viewParams);
    }
}