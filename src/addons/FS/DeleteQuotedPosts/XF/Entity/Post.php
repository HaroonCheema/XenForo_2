<?php

namespace FS\DeleteQuotedPosts\XF\Entity;

use XF\Mvc\Entity\Structure;

class Post extends \XF\Entity\Post
{
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        // Add your custom columns here
        $structure->columns['is_deleted_quoted_post'] = [
            'type' => self::BOOL,
            'default' => false,
        ];

        return $structure;
    }
}