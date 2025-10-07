<?php

namespace FS\CallWhatsApp\XF\Entity;

use XF\Mvc\Entity\Structure;

class User extends XFCP_User
{
    public function canShowCallWhatsup()
    {
        return $this->hasPermission('call_whats_app', 'show');
    }

    
}
