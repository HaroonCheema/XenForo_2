<?php

namespace XenBulletins\BrandHub\Job;

use XF\Job\AbstractRebuildJob;

class ItemDiscussionCount extends AbstractRebuildJob
{
    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();
     
        return $db->fetchAllColumn($db->limit("
                SELECT item_id
                FROM bh_item
                WHERE item_id > ?
                ORDER BY item_id
            ", $batch
        ), $start);
    }

    protected function rebuildById($id)
    {
        $item = $this->app->em()->find('XenBulletins\BrandHub:Item', $id);

        if ($item)
        {
            $tagRepo = $this->getTagRepo();
            
            $threadCount = $this->getItemThreadCount($item);

            $item->fastUpdate('discussion_count', $threadCount);
            
//            $this->app->db()->update('bh_item', ['discussion_count' => $threadCount], 'item_id = ?', $item->item_id);
        }
    }

    protected function getStatusType()
    {
        return \XF::phrase('bh_item_discussion_count');
    }
    
    
    
    protected function getTagRepo()
    {
        return $this->app->repository('XF:Tag');
    }
    
    
    
    protected function getItemThreadCount(\XenBulletins\BrandHub\Entity\Item $item)
    {
        $threadCount = 0;
        
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
                    
                    $threadCount = $tagRepo->getTagsThreadCount($tagIds);
                }
            }            
        }
        
        return $threadCount;
    }
}