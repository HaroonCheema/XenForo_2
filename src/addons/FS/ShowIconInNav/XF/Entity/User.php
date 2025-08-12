<?php

namespace FS\ShowIconInNav\XF\Entity;

class User extends XFCP_User
{
    public function getNavIcons()
    {
        $finder = \XF::finder("FS\ShowIconInNav:NavIcon")->where('enabled', true)->fetch();

        return $finder ?? '';
    }
}
