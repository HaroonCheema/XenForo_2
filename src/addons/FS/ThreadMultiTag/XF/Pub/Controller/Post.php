<?php

namespace FS\ThreadMultiTag\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Post extends XFCP_Post {

    protected function finalizePostEdit(\XF\Service\Post\Editor $editor, \XF\Service\Thread\Editor $threadEditor = null) {
        
        
        $post=$editor->getPost();
        
     $thread=$post->Thread;
        if($post->isFirstPost()){
            
            $customFields = $this->filter('custom_fields', 'array');
        $thread_multi_tag = \xf::options()->thread_multi_tag;
        
        if(!isset($customFields[$thread_multi_tag])){
            
                        return parent::finalizePostEdit($editor,$threadEditor);
            
        }
        
        if(isset($customFields[$thread_multi_tag]) && $customFields[$thread_multi_tag]==""){
            
            $threadTags=$this->defaultThreadtags("thread", $thread->thread_id);
            
             if(is_array($threadTags)){
                 
                $tagger = $this->service('XF:Tag\Changer', 'thread', $thread);
                
                $this->removeTagIdsFromMultiContent("thread",$thread->thread_id);
       
                $tagger->setTags($threadTags);
                if ($tagger->hasErrors()) {
                    return $this->error($tagger->getErrors());
                }


                $tagger->saveMultiTags();
                
            }
            
            return parent::finalizePostEdit($editor,$threadEditor);
            
        }

        if (isset($customFields[$thread_multi_tag]) && $customFields[$thread_multi_tag]) {
            
            
            
            $threadTags=$this->defaultThreadtags("thread", $thread->thread_id);
            
            $this->removeTagIdsFromMultiContent("thread",$thread->thread_id);

            
            $multiTags = $customFields[$thread_multi_tag];

            $multiTags = $this->clearTags($multiTags);
            
           

            $tagger = $this->service('XF:Tag\Changer', 'thread', $thread);
            
            if(is_array($threadTags)){
       
                $multiTags=array_merge(($threadTags),$multiTags);
                
            }

            $tagger->setTags($multiTags);
            if ($tagger->hasErrors()) {
                return $this->error($tagger->getErrors());
            }


            $tagger->saveMultiTags();
        }
            
        }
     
        return parent::finalizePostEdit($editor,$threadEditor);
    }
    
    public function defaultThreadtags($contentType, $contentId){
        
         $db = \xf::app()->db();

        $Tags = $db->query("
            SELECT xf_tag.tag 
            FROM xf_tag_content
            INNER JOIN xf_tag ON xf_tag_content.tag_id = xf_tag.tag_id
            WHERE xf_tag_content.multi_order = 0
              AND xf_tag_content.content_type = ?
              AND xf_tag_content.content_id = ?
        ", [$contentType, $contentId])->fetchAll();

        
        if(count($Tags)){
            
            return array_column($Tags,"tag");
        }
        
        return null;
       
    }
    
     protected function removeTagIdsFromMultiContent($contentType, $contentId) {
         
        $db = \xf::app()->db();
        $db->query("
				DELETE FROM xf_tag_content
				WHERE multi_order != 0
					AND content_type = ?
					AND content_id = ?
			", [$contentType, $contentId]);
        
       		
    }
    
    public function clearTags($multiTags) {

        $step1 = str_replace(' ', '_', $multiTags);

        $step2 = preg_replace('/[^a-zA-Z0-9_\n]/', '', $step1);

        $result = explode("\n", $step2);

        return array_reverse($result);
    }
}
