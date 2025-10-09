<?php

namespace XenAddons\Showcase\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{
    protected function _postSave()
    {
        parent::_postSave();

        if ($this->isInsert())
        {
			if (strpos($this->title, 'Review') === 0)
			{
	            $firstPost = $this->FirstPost;

                if (preg_match('/\[B\]Phone\[\/B\]:\s*([^\n\r]+)/i', $firstPost->message, $match)) 
                {
                    $phoneRaw = trim($match[1]);
                    $phoneDigits = preg_replace('/\D/', '', $phoneRaw);

	                if ($phoneDigits)
	                {
	                    $db = $this->db();
						$spa_id = $db->fetchOne("
						    SELECT item_id
						    FROM xf_xa_sc_item_field_value
						    WHERE field_id = ?
						      AND REGEXP_REPLACE(field_value, '[^0-9]', '') = ?
						    ORDER BY item_id DESC
						    LIMIT 1
						", ['scfPhone', $phoneDigits]);

	                    if($spa_id)
	                    {
			                $review_type = null;

						    if (strpos($firstPost->message, '[B]Recommendation[/B]: No') !== false)
				                $review_type = 'A';
						    else
				                $review_type = 'R';

						    $this->fastUpdate([
						        'spa_id' => $spa_id,
						        'review_type' => $review_type
						    ]);
	                    }
	                }
                }
			}
		}
	}

	public function canConvertThreadToScItem(&$error = null)
	{
		// only visible threads can be converted to a showcase item
		if ($this->discussion_state != 'visible')
		{
			return false; 
		}
		
		// Check for valid ThreadType
		if ($this->discussion_type == 'discussion' || $this->discussion_type == 'article')
		{
			return \XF::visitor()->hasNodePermission($this->node_id, 'convertTheadToScItem');
		}
		
		return false;
	}
	
	public function getScItem()
	{
		if ($this->discussion_type == 'sc_item')
		{
			/** @var \XenAddons\Showcase\Entity\Item $item */
			$item = \XF::repository('XenAddons\Showcase:Item')->findItemForThread($this)->fetchOne();
				
			if ($item && $item->canView())
			{
				return $item;
			}
		}
	
		return null;
	}
	
	public static function getStructure(Structure $structure)
	{
		$structure = parent::getStructure($structure);

		// #### AMC CODE #####
	    $structure->columns['spa_id'] = ['type' => self::UINT, 'default' => 0];
	    $structure->columns['review_type'] = ['type' => self::STR,'allowedValues' => ['R', 'A'], 'default' => null, 'nullable' => true];

		$structure->getters['sc_item'] = true;
	
		return $structure;
	}	
}