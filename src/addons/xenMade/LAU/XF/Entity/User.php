<?php

namespace xenMade\LAU\XF\Entity;

class User extends XFCP_User
{
    public function canUseLau(&$error = null): bool
    {
        return $this->hasPermission('general', 'canUseLau');
    }
}