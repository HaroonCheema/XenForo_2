<?php

namespace FS\ReviewSystem;

use XF\Template\Templater;
use \FS\ReviewSystem\Helper;

class Listener
{   
    
    public static function forum_post_thread_TemplatePreRender(Templater $templater, &$type, &$template, array &$params)
    {    
        if( array_key_exists('isReview', $params) && $params['isReview'])
        {
            $template = 'rs_forum_post_thread';
        }
    }
    
    
    public static function thread_edit_TemplatePreRender(Templater $templater, &$type, &$template, array &$params)
    {   
        if($params['thread']->is_review)
        {
            $template = 'rs_thread_edit';
        }
    }
   

}