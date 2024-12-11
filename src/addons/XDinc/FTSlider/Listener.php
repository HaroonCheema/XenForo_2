<?php

namespace XDinc\FTSlider;

use XF\Mvc\Entity\Entity;

class Listener
{

	public static function adminOptionControllerPostDispatch(\XF\Mvc\Controller $controller, $action, \XF\Mvc\ParameterBag $params, \XF\Mvc\Reply\AbstractReply &$reply)
    {
        if ($params['group_id'] == 'FTSlider_Options')
        {
            $reply->setSectionContext('FTSlider');
        }
    }

}