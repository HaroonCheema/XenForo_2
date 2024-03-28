<?php

namespace FS\DownloadThreadAttachments\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;


class User extends XFCP_User
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);
        
        $structure->columns['daily_download_size']   = ['type' => self::UINT, 'default' => 0, 'max' => PHP_INT_MAX];
        $structure->columns['weekly_download_size']   = ['type' => self::UINT, 'default' => 0, 'max' => PHP_INT_MAX];
        $structure->columns['overall_download_size']   = ['type' => self::UINT, 'default' => 0, 'max' => PHP_INT_MAX];
        
        return $structure;
    } 
}

