<?php

namespace FS\PaymentRedirectionV2;

use XF\Mvc\Entity\Entity;

class Listener
{
    public static function homePageUrl(&$homePageUrl, \XF\Mvc\Router $router)
    {
        $homePageUrl = $router->buildLink('canonical:home');
    }

    public static function appPubRenderPage(\XF\Pub\App $app, array &$params, \XF\Mvc\Reply\AbstractReply $reply, \XF\Mvc\Renderer\AbstractRenderer $renderer)
    {
        $visitor = \XF::visitor();
        if (!$visitor->user_id) 
        {
            header("Location: https://celebforum.to/");
            exit;
        }
    }
}