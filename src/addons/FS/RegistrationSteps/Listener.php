<?php

namespace FS\RegistrationSteps;

use XF\Mvc\Reply\View;
use XF\Pub\Controller\AbstractController;
use XF\Pub\Controller\Login;
use XF\Pub\Controller\Register;
use XF\Pub\Controller\Account;
use XF\Pub\Controller\Index;

class Listener
{
    public static function controllerPostDispatch(\XF\Mvc\Controller $controller, $action, \XF\Mvc\ParameterBag $params, \XF\Mvc\Reply\AbstractReply &$reply)
    {

        if ($controller instanceof AbstractController) {
            $user = \xf::visitor();

            
            

            if ($controller instanceof Login || $controller instanceof Register || $controller instanceof Account) {
                return;
            }

            if (($controller instanceof \XFMG\Pub\Controller\Media  || $controller instanceof \XFMG\Pub\Controller\Album) && $user->user_group_id == 16) {
                return;
            }
            
            if (!$reply instanceof View) {
                return;
            }

            $url = \xf::app()->request()->getFullRequestUri();

            $urI = \xf::app()->request()->getRequestUri();
            
            $parsedUrl = parse_url($urI);

            $path = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';
            
            if ($path == "female-verify/add" || $path == "female-verify/add/") {
                return;
            }

            $myProfile = "/^members\/[a-zA-Z0-9]+?\.\d+\/$/";

            if (preg_match($myProfile, $path) && $user->user_group_id == 16) {
                return;
            }
            

            if (!strpos($url, "admin.php") && ($urI == "/index.php" || $urI == '' || $urI == '/')) {

                $reply->setPageParam('template', 'fs_container_landing_page');

                $reply->setTemplateName('_page_node.150');
            }

            if (($urI != "/index.php" || $urI != '') && $user->user_id && !$user->is_verify && !strpos($url, "admin.php")) {

                $reply->setTemplateName('fs_verify_account_compulsory');
            }


            if (($urI != "/index.php" || $urI != '') && $user->user_id && $user->user_state == "moderated" && !strpos($url, "admin.php")) {

                $reply->setTemplateName('fs_verify_account_moderated');
            }

            return;
        }
    }
}
