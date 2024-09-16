<?php

namespace xenbros\Threadthumbnail;

use XF\Mvc\Entity\Entity;

class Listener
{
    public static function nodeEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
    {
    	$structure->columns['node_thread_thumbnail_height'] = ['type' => Entity::STR, 'nullable' => true];
    	$structure->columns['node_thread_thumbnail_width'] = ['type' => Entity::STR, 'nullable' => true];
		$structure->columns['node_default_thread_thumbnail_image'] = ['type' => Entity::STR, 'nullable' => true];
		$structure->columns['node_custom_image_feild'] = ['type' => Entity::STR, 'nullable' => true];
    	$structure->columns['node_attachment_thumb'] = ['type' => Entity::STR, 'default'=>'full', 
    		'allowedValues' => ['full','small']
    	];
    }
}
