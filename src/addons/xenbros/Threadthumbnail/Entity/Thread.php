<?php

namespace xenbros\Threadthumbnail\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    public function getfirstPostImgUrl()
    {   
        //\XF::dump($this->Forum->Node);
        $ctustom_image_feild = $this->getCustomFields()[$this->Forum->Node->node_custom_image_feild];

        if($ctustom_image_feild)
        {
            return $ctustom_image_feild;
        }

        $enable_first_image_url  = \XF::options()->enable_first_image_url ;

        if($this->discussion_type != 'redirect'){

            if ($enable_first_image_url) {
                $message = $this->FirstPost->message;
                preg_match('/\[IMG(.*?)\](.+?)\[\/IMG\]/i',$message,$matches);

                if($matches)
                {
                        $url = $matches[2];
                        $linkInfo = \XF::app()->stringFormatter()->getLinkClassTarget($url);
                        if ($linkInfo['local'])
                            { return $url; }
                        if(\XF::app()->options()->imageLinkProxy['images'])
                            {
                                $proxyUrl = \XF::app()->stringFormatter()->getProxiedUrlIfActive('image', $url);
                                return $proxyUrl;
                            }
                        return $url;
                }
            }
                $attachments = $this->FirstPost->Attachments;
                foreach ($attachments as &$attachment)
                {
                    //\XF::dump($this->Forum->Node->node_attachment_thumb);

                    if ( $attachment->has_thumbnail == 'TRUE' )
                    {   
                        //\XF::dump($attachment->thumbnail_url);
                        if ($this->Forum->Node->node_attachment_thumb == 'full777') {
                             $attachmentUrl = $baseUrl . \XF::app()->router()->buildLink('attachments', $attachment); 
                        }
                        else{
                            $attachmentUrl = $attachment->thumbnail_url;
                        }
                        return $attachmentUrl; 
                    }

                }

        }
        if ($this->Forum->Node->node_default_thread_thumbnail_image) {
            return $this->Forum->Node->node_default_thread_thumbnail_image ;
        }
        else{
            return \XF::options()->xb_th_default_image ; 
        }
    }
}