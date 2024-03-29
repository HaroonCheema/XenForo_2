<?php

namespace XenBulletins\BrandHub\Repository;

use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Repository;
use XF\Util\Arr;
use XF\Entity\Attachment;


class Item extends Repository {

      
    	public function getMediaTypeFromAttachment(\XF\Entity\Attachment $attachment)
	{
		$data = $attachment->Data;
		if (!$data)
		{
			throw new \InvalidArgumentException("Attachment entity '$attachment->attachment_id' doesn't contain the expected Data relation.");
		}

		$extension = $data->getExtension();

		return $this->getMediaTypeFromExtension($extension);
	}

	public function getMediaTypeFromExtension($extension)
	{
		$options = $this->options();
		
		$imageExtensions = Arr::stringToArray($options->bh_ImageExtensions);
//		$videoExtensions = Arr::stringToArray($options->xfmgVideoExtensions);
//		$audioExtensions = Arr::stringToArray($options->xfmgAudioExtensions);

		if (in_array($extension, $imageExtensions))
		{
			return 'image';
		}
		else if (in_array($extension, $videoExtensions))
		{
			return 'video';
		}
		else if (in_array($extension, $audioExtensions))
		{
			return 'audio';
		}
		else
		{
			return false;
		}
	}
        

        
        
       /*************************flimstrip****************/
        
        public function getCurrentPositionInAlbum(Attachment $Item_Attachment, $content_id, array $limits = [],$page= null)
	{
        
            if($page)
            {
                $finder = $this->findMediaForAlbum($content_id, $Item_Attachment->content_type, $limits, $page);
            }
            else
            {
		$finder = $this->findMediaForAlbum($content_id, $Item_Attachment->content_type, $limits);
            }
                
                $finder->whereOr([
			[
				['attach_date', '>', $Item_Attachment->attach_date]
			],
			[
				['attach_date', '=', $Item_Attachment->attach_date],
				['attachment_id', '>', $Item_Attachment->attachment_id]
			]
		]);
                
               
		return $finder->total();
	}
        
        public function findMediaForAlbum($content_id,$content_type, array $limits = [], $page=null)
	{
       
		$finder = $this->findMediaForList($limits);
              
                if($page)
                {
                    $finder->where('page_id',$page->page_id)->where('content_type',$content_type);
                }
                else
                {
                    $finder->where('content_id',$content_id)->where('content_type',$content_type);
                }


		return $finder;
	}

        
        public function findMediaForList(array $limits = [])
	{
		$limits = array_replace([
			'visibility' => true,
			'allowOwnPending' => true
		], $limits);


		$finder = $this->finder('XF:Attachment');



                $finder->order('attach_date','DESC');

	

		return $finder;
	}
        
 
        
        
        
        
        public function logItemView(\XenBulletins\BrandHub\Entity\Item $item)
	{
		$this->db()->query("
			INSERT INTO bh_item_view
				(item_id, total)
			VALUES
				(? , 1)
			ON DUPLICATE KEY UPDATE
				total = total + 1
		", $item->item_id);
	}

	public function batchUpdateItemViews()
	{
		$db = $this->db();
		$db->query("
			UPDATE bh_item AS i
			INNER JOIN bh_item_view AS iv ON (i.item_id = iv.item_id)
			SET i.view_count = i.view_count + iv.total
		");
		$db->emptyTable('bh_item_view');
	}

        
        
}