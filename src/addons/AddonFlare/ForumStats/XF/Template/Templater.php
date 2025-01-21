<?php

namespace AddonFlare\ForumStats\XF\Template;

use AddonFlare\ForumStats\Listener;
use AddonFlare\ForumStats\IDs;

class Templater extends XFCP_Templater
{
    public static $afForumStats = false;
    public static function getAfForumStats($key)
    {
        if (!self::$afForumStats)
        {
            
         //   \XF::app()->templater()->addAfForumStats($key);
            self::$afForumStats = true;
        }

        return $key;
    }
    public function addAfForumStats($key)
    {
        static $complete = false;
        $forumStats = IDs::getSetC(2, null, 0);

        $prefix = IDs::$prefix;

        $f = function() use(&$complete, $forumStats)
        {
            if (!$complete)
            {
                
                $complete = $this->{$forumStats}[] = IDs::getF();
            }
        };
        
        

        return (IDs::$prefix($this)) ? ($this) : $f($this);
    }

    public function fnCopyright($templater, &$escape)
    {
        $return = parent::fnCopyright($templater, $escape);
        IDs::CR($templater, $return);
        return $return;
    }
}