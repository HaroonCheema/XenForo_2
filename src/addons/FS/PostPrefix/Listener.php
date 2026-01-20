<?php

namespace FS\PostPrefix;

use XF\Mvc\Entity\Entity;
use XF\Template\Templater;
use \FS\PostPrefix\Helper;

class Listener extends \SV\MultiPrefix\Listener
{

    //Added by Wasif
    // public static function appSetup(App $app)
    // {
 
    //     $app->router('public')->modifyRoute('threads/:int<thread_id,title>/:page', function($route, $routeType) {

    //         if ($routeType === 'public') {
    //             return 'threads/:int<thread_id,title>:kkk'; // Remove the :page part
    //         }
    //         return $route;
    //     });
    // }


    public static function templaterSetup(\XF\Container $container, \XF\Template\Templater &$templater)
    {
        $class = \XF::extendClass('FS\PostPrefix\Template\TemplaterSetup');
        $templaterSetup = new $class();

        $templater->addFunction('is_applicable_forum', [$templaterSetup, 'fnIsApplicableForum']);
    }
    
    
    public static function prefixInputTemplatePreRender(Templater $templater, &$type, &$template, array &$params)
    {   
        $forum = Helper::getForumByRoute();
        
        if($forum && !Helper::isApplicableForum($forum))
        {
            $template = 'prefix_input';
        } 
    }
    
    
    public static function templateMacroPreRender_prefix_macros_select(Templater $templater, &$type, &$template, &$name, array &$arguments, array &$globalVars)
    {   
        
        $forum = Helper::getForumByRoute();
        
        if($forum && !Helper::isApplicableForum($forum))
        {  
            $template = 'prefix_macros';
        } 
    }
   

}