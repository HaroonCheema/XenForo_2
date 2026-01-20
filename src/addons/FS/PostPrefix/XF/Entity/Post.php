<?php

namespace FS\PostPrefix\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use SV\MultiPrefix\Behavior\MultiPrefixable;

class Post extends XFCP_Post 
{
      
    public function _getPrefixFilterLink($prefixId)
    {
        if (!$this->Thread)
        {
            return null;
        }
        return \XF::app()->router()->buildLink('threads', $this->Thread, ['prefix_id' => $prefixId]);
        //return \XF::app()->router()->buildLink('threads/prefixposts', $this->Thread, ['prefix_id' => $prefixId]);
    }
    
    public function getSvPrefixFilterLink($prefixId, $linkType = '')
    {
        if (!$this->Thread)
        {
            return null;
        }
        return \XF::app()->router()->buildLink('threads', $this->Thread, ['prefix_id' => $prefixId]);
        //return \XF::app()->router()->buildLink('threads/prefixposts', $this->Thread, ['prefix_id' => $prefixId]);
    }
    
    
    public function getSvPrefixIds()
    {
        return MultiPrefixable::getSvPrefixIds($this, 'sv_prefix_ids_', false, 'thread');
    }

    
    public static function getStructure(Structure $structure)
    {  
        
        $structure = parent::getStructure($structure);

        MultiPrefixable::addMultiPrefixFields($structure);

        return $structure;
    }
}
