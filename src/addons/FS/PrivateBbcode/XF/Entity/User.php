<?php

namespace FS\PrivateBbcode\XF\Entity;

class User extends XFCP_User
{
    public function canUsePrivateBbcodeTag(): bool
    {
        return $this->hasPermission('fsPrivateBbcode', "usePrivateTag");
    }
    
    
    public function canViewPrivateContent(): bool
    {
        return $this->hasPermission('fsPrivateBbcode', "viewPrivateContent");
    }

}