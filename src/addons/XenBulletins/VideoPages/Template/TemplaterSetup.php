<?php

namespace XenBulletins\VideoPages\Template;

use XF\Util\Arr;

class TemplaterSetup {

    public function fnGetVpthumbnail(\XF\Template\Templater $templater, &$escape, $url) {


        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            
                    $path= sprintf('xfvp/temp/%s', $url
        );
        
        return \XF::app()->applyExternalDataUrl($path);
            
            
            
        } else {
            return $url;
        }
    }
    
    
        public function fnIframUrl(\XF\Template\Templater $templater, &$escape, $url) {

            
            if($url['provider']=='facebook')
            {
                $videoId=$url['video'];
                return "https://www.facebook.com/v2.5/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2Fvideo.php%3Fv%3D$videoId";
            }
            else
            {
                return $url['iframe_URL'];
            }
           

    }
    
    
    
    
    

}
