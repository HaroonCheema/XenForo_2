<?php

namespace FS\PostPrefix;
use XF\Mvc\Entity\Entity;

class Helper
{
        public static function insertPostPrefixes($postId,$postPrefixIds)
        {
            foreach ($postPrefixIds as $postPrefixId)
            {
                $app = \XF::app();
                
                $entity = $app->em()->create('FS\PostPrefix:PostPrefixes');
                $entity->post_id = $postId;
                $entity->prefix_id = $postPrefixId;
                $entity->save();
            }
        }
        
        public static function deletePreviousPrefixes($postId)
        {
             \XF::app()->db()->delete('fs_post_prefixes', 'post_id = ?', $postId);
        }
        
        
        public static function excludePrefixes($prefixes)
        {
            $excludePrefixIds = \XF::options()->pp_exclude_prefix;
            
            if($excludePrefixIds)
            {
                $excludePrefixIds = explode(',', $excludePrefixIds);

                foreach ($excludePrefixIds as $prefixId)
                {
                    foreach($prefixes as $key => $prefixGroup)
                    {
                        $prefixGroup = array_values($prefixGroup);
                        
                        $prefixUnset = false;
                        foreach($prefixGroup as $prefix)
                        {
                            if($prefixId == $prefix->prefix_id)
                            {
                                unset($prefixes[$key][$prefixId]);
                                $prefixUnset = true;
                                
                                break;
                            }
                        }
                        
                        if($prefixUnset)
                        {
                            break;
                        }
                    }
                }
            }

            return $prefixes;
        }
        
        public static function isApplicableForum(\XF\Entity\Forum $forum)
        {
            $forumId = $forum->node_id;
            
            $applicableForumIds = \XF::options()->pp_applicable_forums;

            if($applicableForumIds && !in_array(0, $applicableForumIds))
            {
                if(in_array($forumId, $applicableForumIds))
                {
                    return true;
                }
            }

            return false;   
        }
        
        
        public static function getForumByRoute()
        {
            $app = \Xf::app();
        
            $routePath= $app->request()->getRoutePath();      
            $routeMatch = $app->router('public')->routeToController($routePath);
            $urlParams = $routeMatch->getParameterBag();
            
            $forum = null;
            
            if(isset($urlParams['node_id']))
            {
                $nodeId = $urlParams['node_id'];
                $forum = $app->em()->find('XF:Forum', $nodeId);
                
            }
            elseif (isset($urlParams['thread_id'])) 
            {
                $threadId = $urlParams['thread_id'];
                $thread = $app->em()->find('XF:Thread', $threadId);
                
                $forum = $thread->Forum;
            }
            elseif (isset($urlParams['post_id'])) 
            {
                $postId = $urlParams['post_id'];
                $post = $app->em()->find('XF:Post', $postId);
                
                $forum = $post->Thread->Forum;
            }
            
            
            return $forum;
        }
}