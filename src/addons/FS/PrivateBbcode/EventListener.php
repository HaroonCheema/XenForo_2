<?php

namespace FS\PrivateBbcode;

class EventListener
{       
    
    //  templaterTemplatePreRender (editor tamplate)
    public static function templaterTemplatePreRender(\XF\Template\Templater $templater, &$type, &$template, array &$params)
    {
        if (!\XF::visitor()->canUsePrivateBbcodeTag())
        {
            $tag = 'private';
            
            $params['removeButtons'][] = "xfCustom_{$tag}";
        }
    }
}