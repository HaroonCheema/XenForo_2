<?php



namespace XenBulletins\BrandHub\Entity;

use XF\Mvc\Entity\Structure;
use XF\Mvc\Entity\Entity;
use XF\Util\Arr;
use XF\Entity\LinkableInterface;
use XF\Entity\ReactionTrait;
use XenBulletins\BrandHub\Helper;

class OwnerPage extends Entity implements LinkableInterface {
    
     use ReactionTrait;
     
        public function canView(&$error = null)
        {
            return true;

   //        $visitor = \XF::visitor();
   //        if ($visitor->user_id == $this->user_id)
   //        {
   //                return true;
   //        }
        }
     
        public function canViewPostsOnOwnerPage(&$error = null)
        {
                $visitor = \XF::visitor();
		if ( $visitor->user_id == $this->user_id )
		{
			return true;
		}


		if ($this->page_state != 'visible')
		{
			$error = \XF::phraseDeferred('this_owner_page_is_not_available');
			return false;
		}
                
                return \XF::visitor()->hasPermission('ownerPagePost', 'view');
        }
        
        public function canViewDeletedPostsOnOwnerPage()
	{
		return \XF::visitor()->hasPermission('ownerPagePost', 'viewDeleted');
	}

	public function canViewModeratedPostsOnOwnerPage()
	{
		return \XF::visitor()->hasPermission('ownerPagePost', 'viewModerated');
	}

	public function canPostOnOwnerPage()
	{
		$visitor = \XF::visitor();
                
		return ($visitor->user_id
			&& $visitor->hasPermission('ownerPagePost', 'view')
			&& $visitor->hasPermission('ownerPagePost', 'post')
//			&& ($this->user_id == $visitor->user_id)
			&& $this->page_state == 'visible'
		);
	}
        
        public function canUploadAndManageAttachmentsOnOwnerPage(): bool
	{
		$visitor = \XF::visitor();

		return ($visitor->user_id && $visitor->hasPermission('ownerPagePost', 'uploadAttachment'));
	}
        
        
        public function canUploadVideosOnOwnerPage(): bool
	{
		$options = $this->app()->options();

		if (empty($options->allowVideoUploads['enabled']))
		{
			return false;
		}

		$visitor = \XF::visitor();

		return ($visitor->user_id && $visitor->hasPermission('ownerPagePost', 'uploadVideo'));
	}
        
        
        public function getNewOwnerPagePost()
	{
		$ownerPagePost = $this->_em->create('XenBulletins\BrandHub:OwnerPagePost');
		$ownerPagePost->owner_page_id = $this->page_id;

		return $ownerPagePost;
	}
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        public function getBreadcrumbs($includeSelf = true)
	{
              $breadcrumbs = $this->Item ? $this->Item->getBreadcrumbs() : [];


		if ($includeSelf)
		{
			$breadcrumbs[] = [
				'href' => $this->app()->router()->buildLink('owners', $this),
			
			];
		}

		return $breadcrumbs;
	}
         public function canReact(&$error = null)
	{
        
             return true;
        
        
        }
          
           public function getContentUrl(bool $canonical = false, array $extraParams = [], $hash = null)
	{
          
		$route = $canonical ? 'canonical:owners' : 'owners';
                
		return $this->app()->router('public')->buildLink($route, $this, $extraParams, $hash);
	}

	public function getContentPublicRoute()
	{
		return 'owners';
	}

	public function getContentTitle(string $context = '')
	{
            
            if($this->page_id){
                
              return $this->page_id;
                
            }
	}
        
     
       public function getAttachmentConstraints() {
           

            $options = $this->app()->options();

            $extensions = [];
          //  if (in_array('image', $this->allowed_types)) {
                $extensions = array_merge($extensions, Arr::stringToArray($options->bh_ImageExtensions));
            //}

//            $size = $this->hasPermission('bh_maxFileSize');
//            $width = $this->hasPermission('bh_maxImageWidth');
//            $height = $this->hasPermission('bh_maxImageHeight');

            // Treat both 0 and -1 as unlimited
            return [
                'extensions' => $extensions,
//                'size' => ($size <= 0) ? PHP_INT_MAX : $size  1024  1024,
//                'width' => ($width <= 0) ? PHP_INT_MAX : $width,
//                'height' => ($height <= 0) ? PHP_INT_MAX : $height,
//                'count' => 100
            ];
//        }
    }
    
    
    protected function _postSave() 
    {
        if($this->isInsert())
        {
            Helper::updateOwnerCount($this->Item, 'added');
        }
    }


    protected function _postDelete()
    {
        
        $pageDetail = $this->Detail;   
                    
        if($pageDetail)
        {
            $pageDetail->delete();
        }
        
        $db = $this->db();
        $db->delete('bh_page_subscribe', 'page_id = ?', [$this->page_id]);
        
        $db->delete('bh_page_count', 'page_id = ?', [$this->page_id]);
        
        if($this->Item)
        {
            Helper::updateOwnerCount($this->Item, 'removed');
        }
        

        $attachRepo = $this->repository('XF:Attachment');
        $attachRepo->fastDeleteOwnerPageAttachments('bh_item', $this->page_id);
    }
    
    
       
    
    public function getThumbnailUrl()
	{
            $attachmentData = $this->finder('XF:Attachment')->where('content_type', 'bh_item')->where('page_id', $this->page_id)->where('page_main_photo', 1)->order('attach_date','Desc')->fetchOne();
            
           if(!$attachmentData){
                
          $attachmentData = $this->finder('XF:Attachment')->where('content_type', 'bh_item')->where('page_id', $this->page_id)->order('attach_date','Desc')->fetchOne();   
                    
           }

            return ($attachmentData && $attachmentData->Data) ? $attachmentData->Data->getThumbnailUrl() : '';
	}
    
        public static function getStructure(Structure $structure) {
            
        $structure->table = 'bh_owner_page';
        $structure->shortName = 'XenBulletins\BrandHub:OwnerPage';
        $structure->contentType = 'bh_ownerpage';
        $structure->primaryKey = 'page_id';
        
        
        $structure->columns = [
            'page_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'title' =>   ['type' => self::STR, 'default' => NULL],
            'page_state' => ['type' => self::STR, 'default' => 'visible',
                'allowedValues' => ['visible', 'moderated', 'deleted'], 'api' => true
            ],
            'discussion_count' => ['type' => self::UINT, 'default' => 0],
            'view_count' => ['type' => self::UINT, 'default' => 0],
            'rating_count' => ['type' => self::UINT, 'default' => 0],
            'rating_sum' => ['type' => self::UINT, 'default' => 0],
            'rating_avg' => ['type' => self::UINT, 'default' => 0],
            'rating_weighted' => ['type' => self::UINT, 'default' => 0],
            'review_count' => ['type' => self::UINT, 'default' => 0],
            'create_date' => ['type' => self::UINT, 'default' => \XF::$time, 'api' => true],
            'item_id' => ['type' => self::UINT, 'default' => 0],
            'user_id' => ['type' => self::UINT, 'default' => 0],
            
             'position' => ['type' => self::UINT, 'forced' => true, 'api' => true],
            'reaction_score' => ['type' => self::UINT, 'default' => 0],
            'reaction_users' => ['type' => self::JSON_ARRAY, 'default' => []],
            'reactions' => ['type' => self::JSON_ARRAY, 'default' => []],
            
        ];
          
           $structure->getters = [
			
			'thumbnail_url' => ['getter' => 'getThumbnailUrl', 'cache' => false],
			
		];
           
          $structure->relations = [
            
            
            
            'Detail' => [
                            'entity' => 'XenBulletins\BrandHub:PageDetail',
                            'type' => self::TO_ONE,
                            'conditions' => [['page_id', '=', '$page_id']],
                            //'primary' => true
                    ],
              
               'Attachment' => [
                'entity' => 'XF:Attachment',
                'type' => self::TO_ONE,
                'conditions' => [
                    ['content_type', '=', 'bh_ownerpage'],
                    ['content_id', '=', '$page_id']
                ]
            ],
              
                  'Item' => [
                            'entity' => 'XenBulletins\BrandHub:Item',
                            'type' => self::TO_ONE,
                            'conditions' => [['item_id', '=', '$item_id']],
                            //'primary' => true
                    ],
              
                  'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true,
				'api' => true
			],
              
              
        ];
           
        static::addReactableStructureElements($structure);
           
        return $structure;
             
        }
    
    
    
}