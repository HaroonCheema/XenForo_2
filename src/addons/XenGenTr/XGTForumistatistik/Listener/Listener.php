<?php

namespace XenGenTr\XGTForumistatistik\Listener;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Manager;
use XF\Mvc\Entity\Structure;

class Listener
{
    public static function templaterGlobalData(\XF\App $app, array &$data, $reply)
    {
        $data['xengentrForumIstatistikleriForumIstatistikRepo'] = $app->repository('XenGenTr\XGTForumistatistik:ForumIstatistik');
        $data['xengentrForumIstatistikleriForumIstatistikRepo2'] = $app->repository('XenGenTr\XGTForumistatistik:ForumIstatistik');
    }

    const KIMLIK = 'XenGenTr/XGTForumistatistik';
    const UNVAN = '[XGT] Forum statistics system';
    const ID_NUM = '';
    public static $KIMLIK1 = [
    ];
}

