<?php

namespace xenMade\LAU;

class Listener
{
    public static function app_setup(\XF\App $app)
    {
        $classType = $app->container('app.classType');

        if($classType == 'Pub')
        {
            $session = $app->session();

            if($session->offsetExists('lau_id'))
            {
                $config = $app->container('config');
                $config['enableTfa'] = false;
                $app->offsetSet('config', $config);

                $addOns = \XF::app()->container('addon.cache');
                if (array_key_exists('SV/UserActivity', $addOns))
                {
                    /** @var \SV\UserActivity\Repository\UserActivity $userActivityRepo */
                    \XF::repository('SV\UserActivity:UserActivity')
                        ->supressLogging();
                }
            }
        }
    }
}