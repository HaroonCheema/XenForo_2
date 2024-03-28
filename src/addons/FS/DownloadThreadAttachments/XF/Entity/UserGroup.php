<?php
namespace FS\DownloadThreadAttachments\XF\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;


class UserGroup extends XFCP_UserGroup
{    
    public static function getStructure(Structure $structure)
    {

        $structure = parent::getStructure($structure);
        
        $structure->columns['download_size_limit']   = ['type' => self::UINT, 'default' => 0];
        $structure->columns['daily_download_size_limit']   = ['type' => self::UINT, 'default' => 0];
        $structure->columns['weekly_download_size_limit']   = ['type' => self::UINT, 'default' => 0];

        return $structure;

    } 
}