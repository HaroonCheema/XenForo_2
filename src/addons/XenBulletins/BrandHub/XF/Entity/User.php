<?php

namespace XenBulletins\BrandHub\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public function canViewOwnerPagePosts(&$error = null)
    {
            return $this->hasPermission('ownerPagePost', 'view');
    }
    
}
