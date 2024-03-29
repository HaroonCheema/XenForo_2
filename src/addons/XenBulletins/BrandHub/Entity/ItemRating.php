<?php



namespace XenBulletins\BrandHub\Entity;

use XF\Mvc\Entity\Structure;
use XF\Mvc\Entity\Entity;
use XF\Util\Arr;
use XF\Entity\ReactionTrait;

class ItemRating extends Entity {
    
     use ReactionTrait;
    
     
    public function canReact(&$error = null): bool
    {
        $visitor = \XF::visitor();
        if (!$visitor->user_id)
        {
                return false;
        }

        if ($this->rating_state != 'visible')
        {
                return false;
        }

        if ($this->user_id == $visitor->user_id)
        {
                $error = \XF::phraseDeferred('reacting_to_your_own_content_is_considered_cheating');
                return false;
        }

        return $visitor->hasPermission('bh_brand_hub','bh_reactToReviews');

    }
    
    public function canView(&$error = null)
	{
            $visitor = \XF::visitor();
		if ($this->rating_state == 'deleted')
		{
			if (!$visitor->hasPermission('bh_brand_hub','viewDeleted'))
			{
				return false;
			}
		}

		return true;
	}

	public function canDelete($type = 'soft', &$error = null)
	{
		$visitor = \XF::visitor();
		$item = $this->Item;

		if (!$visitor->user_id || !$item)
		{
			return false;
		}

		if ($type != 'soft')
		{
                    
			return (
				$visitor->hasPermission('bh_brand_hub','hardDelete')
				
			);
		}

		if ($this->user_id == $visitor->user_id)
		{
			return true;
		}

		return $visitor->hasPermission('bh_brand_hub','deleteAnyReview');
	}

	public function canUpdate(&$error = null)
	{
		$visitor = \XF::visitor();
		$item = $this->Item;

		if (!$visitor->user_id
			|| $visitor->user_id != $this->user_id
			|| !$item
//			|| !$item->hasPermission('rate')
		)
		{
			return false;
		}

		if ($this->rating_state != 'visible')
		{
			$error = \XF::phraseDeferred('bh_cannot_update_review_while_your_previous_review_exists_in_deleted_state');
			return false;
		}

//		if ($this->author_response)
//		{
//			$error = \XF::phraseDeferred('bh_cannot_update_rating_once_author_response');
//			return false;
//		}

		return true;
	}

	public function canUndelete(&$error = null)
	{
		$visitor = \XF::visitor();
		$item = $this->Item;

		if (!$visitor->user_id || !$item)
		{
			return false;
		}

		return $visitor->hasPermission('bh_brand_hub','undelete');
	}
//
//	public function canReport(&$error = null, \XF\Entity\User $asUser = null)
//	{
//		$asUser = $asUser ?: \XF::visitor();
//		return $asUser->canReport($error);
//	}
//
//	public function canWarn(&$error = null)
//	{
//		$visitor = \XF::visitor();
//		$resource = $this->Resource;
//
//		if (!$resource
//			|| !$visitor->user_id
//			|| $this->user_id == $visitor->user_id
//			|| !$resource->hasPermission('warn')
//		)
//		{
//			return false;
//		}
//
//		if ($this->warning_id)
//		{
//			$error = \XF::phraseDeferred('user_has_already_been_warned_for_this_content');
//			return false;
//		}
//
//		$user = $this->User;
//		return ($user && $user->isWarnable());
//	}
//
//	public function canReply(&$error = null)
//	{
//		$visitor = \XF::visitor();
//		$resource = $this->Resource;
//
//		return (
//			$visitor->user_id
//			&& $resource
//			&& $resource->user_id == $visitor->user_id
//			&& $this->is_review
//			&& !$this->author_response
//			&& $this->rating_state == 'visible'
//			&& $resource->hasPermission('reviewReply')
//		);
//	}
        
        
        protected function _preSave()
	{
		if ($this->isUpdate() && $this->isChanged(['message', 'rating', 'user_id']))
		{
			throw new \LogicException("Cannot change rating message, value or user");
		}

		if ($this->isChanged('message'))
		{
			$this->is_review = strlen($this->message) ? true : false;
		}

		if (!$this->user_id)
		{
			throw new \LogicException("Need user ID");
		}
	}
        
//           protected function _postSave()
//	{
//             if($this->isInsert())
//             {
//             echo 'postSave';exit;
//             }
//         }
//        
        
        
        public function softDelete($reason = '', \XF\Entity\User $byUser = null)
	{
		$byUser = $byUser ?: \XF::visitor();

		if ($this->rating_state == 'deleted')
		{
			return false;
		}

		$this->rating_state = 'deleted';

		/** @var \XF\Entity\DeletionLog $deletionLog */
		$deletionLog = $this->getRelationOrDefault('DeletionLog');
		$deletionLog->setFromUser($byUser);
		$deletionLog->delete_reason = $reason;

		$this->save();

		return true;
	}
        
        public function getAttachmentConstraints() 
        {

                $options = $this->app()->options();
                
                $extensions = Arr::stringToArray($options->bh_ImageExtensions);

                return [
                    'extensions' => $extensions
                ];
        }
        
        protected function _preDelete() {
           
        }
        
        protected function _postDelete() 
        {
            $attachRepo = $this->repository('XF:Attachment');
            $attachRepo->fastDeleteContentAttachments('bh_review', $this->item_rating_id);
        }

    
    
        public static function getStructure(Structure $structure) {
            
        $structure->table = 'bh_item_rating';
        $structure->shortName = 'XenBulletins\BrandHub:ItemRating';
        $structure->primaryKey = 'item_rating_id';
        $structure->contentType = 'bh_review';
        $structure->columns = [
            'item_rating_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'item_id' => ['type' => self::UINT, 'required' => true],
            'user_id' => ['type' => self::UINT, 'required' => true],
            'rating' => ['type' => self::UINT, 'required' => true, 'min' => 1, 'max' => 5],
            'rating_date' => ['type' => self::UINT, 'default' => \XF::$time],
            'message' => ['type' => self::STR, 'default' => ''],
            'is_review' => ['type' => self::BOOL, 'default' => false],
            'count_rating' => ['type' => self::BOOL, 'default' => TRUE],
            'rating_state' => ['type' => self::STR, 'default' => 'visible', 'allowedValues' => ['visible', 'deleted'] ],
            'position' => ['type' => self::UINT, 'forced' => true],
        ];
//           $structure->getters = [
//            'allowed_types' => true,
//            'field_cache' => true,
//            'custom_fields' => true,
//            'custom_fields_list' => true
//        ];
        
        
        
        
//        $structure->behaviors = [
//			'XF:Reactable' => ['stateField' => 'rating_state'],
//        ];
           
           
          $structure->relations = [
            'Item' => [
                            'entity' => 'XenBulletins\BrandHub:Item',
                            'type' => self::TO_ONE,
                            'conditions' => [
                                    ['item_id', '=', '$item_id']
                            ],
                    ],
//                    
                    'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true
			],
              
              'DeletionLog' => [
				'entity' => 'XF:DeletionLog',
				'type' => self::TO_ONE,
				'conditions' => [
					['content_type', '=', 'item_rating'],
					['content_id', '=', '$item_rating_id']
				],
				'primary' => true
			],
//              
//              'Brand' => [
//                            'entity' => 'XenBulletins\BrandHub:Brand',
//                            'type' => self::TO_ONE,
//                            'conditions' => [
//                                    ['brand_id', '=', '$brand_id']
//                            ],
//                    ],
//            
//            
//            'Description' => [
//                            'entity' => 'XenBulletins\BrandHub:ItemDescription',
//                            'type' => self::TO_ONE,
//                            'conditions' => [['item_id', '=', '$item_id']],
//                            'primary' => true
//                    ],
//              
               'Attachment' => [
                'entity' => 'XF:Attachment',
                'type' => self::TO_MANY,
                'conditions' => [
                    ['content_type', '=', 'bh_review'],
                    ['content_id', '=', '$item_rating_id']
                ],
                   'with' => 'Data',
                'order' => 'attach_date'
            ]
              
        ];
          
        static::addReactableStructureElements($structure);
           
        return $structure;
             
        }
    
    
    
}