<?php

namespace FS\ReviewSystem\XF\Entity;

class User extends XFCP_User
{
    
    public function canViewRosContent(): bool
    {
            $rosViewUserGroupIds = \XF::options()->rs_view_ros_content_userGroups;
            
            return \XF::visitor()->isMemberOf($rosViewUserGroupIds);
    }
    
}