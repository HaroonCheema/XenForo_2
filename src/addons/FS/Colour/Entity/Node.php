<?php

namespace FS\Colour\Entity;

use XF\Entity\Node as BaseNode;
use XF\Mvc\Entity\Structure;
class Node extends BaseNode
{
    public static function getStructure(Structure $structure)
    {
        // Call the parent method to get the existing structure
        $structure = parent::getStructure($structure);

        // Adding custom columns for the color entity
        $structure->columns += [
            'color_code' => ['type' => self::STR, 'maxLength' => 50, 'default' => ''],
            'color_title' => ['type' => self::STR, 'maxLength' => 50, 'default' => ''],
        ];

        $structure->getters += [
            'title' => true,  
            // 'original_title'=> ['type' => self::STR, 'maxLength' => 50, 'default' => ''],
            'original_title'=>true,
            
        ];

        return $structure;
    }
        /**
     * Getter method for formatted_title.
     * It prepends color_title to the node title with color_code styling.
     */
        public function getTitle()
    {
        return \XF::phrase('new_node_title',['title'=>$this->getValue('title'),'color_title'=>$this->getValue('color_title'),'code'=>$this->getValue('color_code')]); 
    }
    public function getOriginalTitle()
    {
        return $this->getValue('title');
    }
    }