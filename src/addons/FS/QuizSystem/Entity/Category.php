<?php

namespace FS\QuizSystem\Entity;

use XF\Draft;
use XF\Entity\AbstractCategoryTree;
use XF\Entity\Forum;
use XF\Entity\Phrase;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Structure;

class Category extends AbstractCategoryTree {

    protected $_viewableDescendants = [];

    public function getCategoryListExtras() {
        return [
            'quiz_count' => $this->quiz_count,
        ];
    }
//
//    public function getBreadcrumbs($includeSelf = true, $linkType = 'public') {
//        if ($linkType == 'public') {
//            $link = 'items/categories';
//        } else {
//            $link = 'resource-manager/categories';
//        }
//        return $this->_getBreadcrumbs($includeSelf, $linkType, $link);
//    }

    public function canView(&$error = null) {
        return true;
    }

    
    public function cacheViewableDescendents(array $descendents, $userId = null)
	{
		if ($userId === null)
		{
			$userId = \XF::visitor()->user_id;
		}

		$this->_viewableDescendants[$userId] = $descendents;
	}

    public static function getStructure(Structure $structure) {
        $structure->table = 'fs_quiz_category';
        $structure->shortName = 'FS\QuizSystem:Category';
        $structure->primaryKey = 'category_id';
        $structure->contentType = 'quiz_category';
        $structure->columns = [
            'category_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
            'title' => [
                'type' => self::STR, 'maxLength' => 100,
                'required' => 'please_enter_valid_title'
            ],
            'field_cache' => ['type' => self::JSON_ARRAY, 'default' => []],
			
            'description' => ['type' => self::STR, 'default' => ''],
            'quiz_count' => ['type' => self::UINT, 'forced' => true, 'default' => 0],
        ];
        $structure->relations = [];
        $structure->getters = [];
        $structure->options = [];

        static::addCategoryTreeStructureElements($structure, [
            'breadcrumb_json' => true
        ]);

        return $structure;
    }
}
