<?php

namespace XenBulletin\RandomFeatureVideos\XB\VideoPages\Admin\Controller;

class Iframe extends  XFCP_Iframe 
{
    protected function tagSaveProcess(\XenBulletins\VideoPages\Entity\Iframe $iframe) 
    {  
        // get already featureVideos Count
        $featureVideosCount = $this->Finder('XenBulletins\VideoPages:Iframe')->where('feature','1')->total();
        
        // if updating and already set to feature then -1 from featureVideosCount for the following condition
        if($iframe->iframe_id && $iframe->feature)
        {
            $featureVideosCount = $featureVideosCount - 1;
        }
        
        $featureVideosLimit = (int)\XF::options()->xb_featureVideosLimit;
        
        $featureInput = $this->filter('feature', 'UINT');
        
        if($featureInput && $featureVideosCount >= $featureVideosLimit)
        {
             throw $this->exception($this->error(\XF::phrase('feature_videos_limit_exceeded',['limit' => $featureVideosLimit])));
        }   
        
        return parent::tagSaveProcess($iframe);
    }
}
