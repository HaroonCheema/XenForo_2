<?php

namespace FS\ThreadMultiTag\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Forum extends XFCP_Forum {

    protected function finalizeThreadCreate(\XF\Service\Thread\Creator $creator) {
        
        
        $creator->sendNotifications();

        $forum = $creator->getForum();
        $thread = $creator->getThread();

        $visitor = \XF::visitor();

        $customFields = $this->filter('custom_fields', 'array');
        $thread_multi_tag = \xf::options()->thread_multi_tag;
        
        if(!isset($customFields[$thread_multi_tag])){
            
            
            return parent::finalizeThreadCreate($creator);
            
        }

        if (isset($customFields[$thread_multi_tag]) && $customFields[$thread_multi_tag]!="") {

            $threadTags=null;
            if(count($thread->tags)){
                
                $threadTags=array_column($thread->tags,'tag');
            }
           
            $multiTags = $customFields[$thread_multi_tag];

            $multiTags = $this->clearTags($multiTags);

            $tagger = $this->service('XF:Tag\Changer', 'thread', $thread);

            if( is_array($threadTags)){
                
                $multiTags=array_merge(($threadTags),$multiTags);
                
               
            }
            $tagger->setEditableTags($multiTags);
            if ($tagger->hasErrors()) {
                return $this->error($tagger->getErrors());
            }


            $tagger->saveMultiTags();
        }




        return parent::finalizeThreadCreate($creator);
    }

    public function clearTags($multiTags) {

        $step1 = str_replace(' ', '_', $multiTags);

        $step2 = preg_replace('/[^a-zA-Z0-9_\n]/', '', $step1);

        $result = explode("\n", $step2);

        return array_reverse($result);
    }
}
