<?php

namespace FS\PostPrefix\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;
use FS\PostPrefix\Helper;

class Post extends XFCP_Post
{
    public function actionEdit(ParameterBag $params)
    {
  
        if ($this->isPost())
        {
            $post = $this->assertViewablePost($params->post_id);

            if( ($post->post_id != $post->Thread->first_post_id) && Helper::isApplicableForum($post->Thread->Forum))
            {
                $postPrefixIds = $this->filter('sv_prefix_ids', 'array-uint');

                if(!$postPrefixIds)
                {
                     throw new \XF\PrintableException(\XF::phrase('please_select_at_least_one_prefix'));
                }
            }
        }
        
        
        $parent = parent::actionEdit($params); 
        
        if($parent instanceof \XF\Mvc\Reply\View && !$this->isPost())
        {          
            $prefixes = $parent->getParam('prefixes');
            
            $prefixes = Helper::excludePrefixes($prefixes);
            
            $parent->setParam('prefixes', $prefixes);
        }
        
        return $parent;
    }
    protected function finalizePostEdit(\XF\Service\Post\Editor $editor, \XF\Service\Thread\Editor $threadEditor = null)
    {
        $postPrefixIds = $this->filter('sv_prefix_ids', 'array-uint');

        $post = $editor->getPost();
        $post->sv_prefix_ids = $postPrefixIds;
        $post->save();

        $postId = $post->post_id;
        Helper::deletePreviousPrefixes($postId);

        if($postPrefixIds)
        {
            Helper::insertPostPrefixes($postId, $postPrefixIds);
        }

        return parent::finalizePostEdit($editor, $threadEditor);
    }
    
    
    public function actionDelete(ParameterBag $params)
    {
        
        if ($this->isPost())
        {
            $type = $this->filter('hard_delete', 'bool') ? 'hard' : 'soft';
            if($type == 'hard')
            {
                $this->app()->db()->delete('fs_post_prefixes', 'post_id = ?', $params->post_id);
            }
        }
        
        return parent::actionDelete($params);
    }
            
    
}