<?php

namespace FS\ReviewSystem\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use FS\ReviewSystem\Helper;

class Forum extends XFCP_Forum 
{


    public function actionPostThread(ParameterBag $params) 
    {
        $isReview = $this->filter('review', 'uint');
        $nodeId = $params->node_id;
        
        $parent = parent::actionPostThread($params);
        
        if ($parent instanceof \XF\Mvc\Reply\View && $isReview && Helper::canPostReview($nodeId)) 
        {
                $parent->setParam('isReview', true);
        }

        return $parent;
    }
    
    
    

    public function actionForum(ParameterBag $params) 
    {
        $nodeId = $params->node_id;
                
        $parent = parent::actionForum($params);

        if ($parent instanceof \XF\Mvc\Reply\View && Helper::canPostReview($nodeId)) 
        {
                $parent->setParam('canPostReview', true);
        }

        return $parent;
    }
}
