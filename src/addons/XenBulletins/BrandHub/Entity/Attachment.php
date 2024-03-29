<?php

namespace XenBulletins\BrandHub\Entity;

use XF\Mvc\Entity\Structure;

class Attachment extends XFCP_Attachment {

    public function canView(&$error = null) {
        
   if ($this->content_type == 'bh_item' || $this->content_type == 'bh_ownerpage' || $this->content_type == 'bh_review' ) {
            return TRUE;
        }
        return parent::canView($error);
    }
    
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);
        $structure->columns['page_id'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['user_id'] =  ['type' => self::UINT, 'default' => 0];
         $structure->columns['item_main_photo'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['page_main_photo'] =  ['type' => self::UINT, 'default' => 0];
        
        
        
        $structure->relations['Item'] = [   
                                            'entity' => 'XenBulletins\BrandHub:Item',
                                            'type' => self::TO_ONE,
                                            'conditions' => [
                                                    ['item_id', '=', '$content_id']
                                            ],
                                            'primary' => true
                                        ];

        return $structure;
    }  
}