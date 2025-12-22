<?php

namespace XenBulletin\RandomFeatureVideos\XB\VideoPages\Pub\Controller;

use XF\Mvc\ParameterBag;

class FetchVideo extends XFCP_FetchVideo
{  
    public function actionIndex(ParameterBag $params)
    {   
        $reply = parent::actionIndex($params);

        if($reply instanceof \XF\Mvc\Reply\View)
        {

        //    $featureVideo = $this->Finder('XenBulletins\VideoPages:Iframe')->where('feature','1')->order('RAND()')->fetchOne();       
                  
          //  $reply->setParam('featurevideo', $featureVideo);
        }
        
        return $reply;
    }
}
