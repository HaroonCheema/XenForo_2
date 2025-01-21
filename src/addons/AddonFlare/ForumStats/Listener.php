<?php

namespace AddonFlare\ForumStats;

use XF\Mvc\Entity\Entity;
use AddonFlare\ForumStats\IDs;

class Listener
{
    public static function adminOptionControllerPostDispatch(\XF\Mvc\Controller $controller, $action, \XF\Mvc\ParameterBag $params, \XF\Mvc\Reply\AbstractReply &$reply)
    {
        if ($params['group_id'] == 'af_forumstats')
        {
            $reply->setSectionContext('af_forumstats_opt');
        }
    }

    public static function templaterGlobalData(\XF\App $app, array &$data, $reply)
    {
        $data['addonFlareForumStatsForumStatRepo'] = $app->repository('AddonFlare\ForumStats:ForumStat');
    }

    public static function appPubRenderPage(\XF\Pub\App $app, array &$params, \XF\Mvc\Reply\AbstractReply $reply, \XF\Mvc\Renderer\AbstractRenderer $renderer)
    {
    }

    const ID = 'AddonFlare/ForumStats';
    const TITLE = 'Advanced Forum Stats';
    const ID_NUM = '2ba8698b79439589fdd2b0f7218d8b07';
    public static $IDS1 = [
        97, 102, 95, 102, 111, 114, 117, 109, 115, 116, 97, 116, 115, 95, 122,
    ];
}