<?php

namespace XenBulletins\BrandHub\Job;

use XF\Job\AbstractRebuildJob;

class OwnerPageDiscussionCount extends AbstractRebuildJob
{
    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();
     
        return $db->fetchAllColumn($db->limit("
                SELECT page_id
                FROM bh_owner_page
                WHERE page_id > ?
                ORDER BY page_id
            ", $batch
        ), $start);
    }

    protected function rebuildById($id)
    {
        $ownerPage = $this->app->em()->find('XenBulletins\BrandHub:OwnerPage', $id, ['Item']);

        if ($ownerPage)
        {   
            $tagRepo = $this->getTagRepo();
            
            $threadCount = $this->getOwnerPageThreadCount($ownerPage);

            $ownerPage->fastUpdate('discussion_count', $threadCount);
        }
    }

    protected function getStatusType()
    {
        return \XF::phrase('bh_owner_page_discussion_count');
    }
    
    
    
    protected function getTagRepo()
    {
        return $this->app->repository('XF:Tag');
    }
    
    
    
    protected function getOwnerPageThreadCount(\XenBulletins\BrandHub\Entity\OwnerPage $ownerPage)
    {
        $threadCount = 0;
        
        $item = $ownerPage->Item;
        $stringTags = $item->tags;
        
        if($stringTags)
        {   
            /** @var \XF\Repository\Tag $tagRepo */
            $tagRepo = $this->getTagRepo();

            $tags = $tagRepo->splitTagList($stringTags);

            if ($tags)
            {
                $validTags = $tagRepo->getTags($tags, $notFound);

                if($validTags)
                {
                    $tagIds = array_keys($validTags);
                    
                    $threadCount = $tagRepo->getTagsThreadCount($tagIds, $ownerPage->user_id);
                }
            }            
        }
        
        return $threadCount;
    }
}