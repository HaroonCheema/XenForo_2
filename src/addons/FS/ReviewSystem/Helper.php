<?php

namespace FS\ReviewSystem;

class Helper
{
        public static function isReviewApplicableForum($nodeId)
        {
            $reviewApplicableForumIds = \XF::options()->rs_applicable_forums;
            
            return in_array($nodeId, $reviewApplicableForumIds); 
        }
        
        
        public static function canPostReview($nodeId)
        {
            $options = \XF::options();
            $visitor = \XF::visitor();
            
            $hideButtonUserGroupIds = $options->rs_hide_button_userGroups;

            if (!Helper::isReviewApplicableForum($nodeId) || $visitor->isMemberOf($hideButtonUserGroupIds)) 
            {
                return false;
            }
            
            return true;
        }
}

