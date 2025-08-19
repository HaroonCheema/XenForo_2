<?php

namespace Siropu\AdsManager\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class PositionCategory extends Repository
{
     public function getDefaultCategory()
     {
          $positionCategory = $this->em->create('Siropu\AdsManager:PositionCategory');
          $positionCategory->setTrusted('category_id', 0);
          $positionCategory->setTrusted('display_order', 999);
          $positionCategory->setReadOnly(true);

          return $positionCategory;
     }
     public function findPositionCategoriesForList()
     {
          $categories = $this->finder('Siropu\AdsManager:PositionCategory')
               ->order('display_order', 'ASC')
               ->fetch();

          $defaultCategory = $this->getDefaultCategory();
		$positionCategories = $categories->toArray();
		$positionCategories = $positionCategories + [$defaultCategory];
		$categories = $this->em->getBasicCollection($positionCategories);

          return $categories;
     }
     public function getPositionCategoryTitlePairs()
     {
          return $this->finder('Siropu\AdsManager:PositionCategory')
               ->order('display_order')
               ->fetch()
               ->pluckNamed('title', 'category_id');
     }
     public function addDefaultPositionCategories()
     {
          $categories = [
			[
				'category_id'   => 1,
				'title'         => 'Global positions',
				'description'   => 'Positions that are available on any page.',
				'display_order' => 1
			],
               [
				'category_id'   => 2,
				'title'         => 'Forum list positions',
				'description'   => 'Positions that are available on forum list.',
				'display_order' => 2
			],
			[
				'category_id'   => 3,
				'title'         => 'Forum view positions',
				'description'   => 'Positions that are available on forum pages.',
				'display_order' => 3
			],
			[
				'category_id'   => 4,
				'title'         => 'Thread view positions',
				'description'   => 'Positions that are available on thread pages.',
				'display_order' => 4
			],
               [
				'category_id'   => 16,
				'title'         => 'Conversation list positions',
				'description'   => 'Positions that are available on conversation list page.',
				'display_order' => 5
			],
               [
				'category_id'   => 5,
				'title'         => 'Conversation view positions',
				'description'   => 'Positions that are available on conversation pages.',
				'display_order' => 6
			],
			[
				'category_id'   => 6,
				'title'         => 'Member view positions',
				'description'   => 'Positions that are available on user profile pages.',
				'display_order' => 7
			],
               [
				'category_id'   => 7,
				'title'         => 'Search results positions',
				'description'   => 'Positions that are available on the serach results pages.',
				'display_order' => 8
			],
               [
				'category_id'   => 8,
				'title'         => 'Tag view positions',
				'description'   => 'Positions that are available on the tag view pages.',
				'display_order' => 9
			],
			[
				'category_id'   => 9,
				'title'         => 'Miscellaneous positions',
				'description'   => 'Positions that are available on various pages.',
				'display_order' => 10
			],
			[
				'category_id'   => 10,
				'title'         => 'Media Gallery positions',
				'description'   => 'Positions that are available on Media Gallery pages.',
				'display_order' => 11
			],
			[
				'category_id'   => 11,
				'title'         => 'Resource Manager positions',
				'description'   => 'Positions that are available on Resource Manager pages.',
				'display_order' => 12
			],
               [
				'category_id'   => 12,
				'title'         => 'Article Management System positions',
				'description'   => 'Positions that are available on AMS pages.',
				'display_order' => 13
			],
               [
				'category_id'   => 13,
				'title'         => 'No Wrapper',
				'description'   => 'Positions that can be used to insert JavaScript code without the ad HTML wrapper.',
				'display_order' => 14
			],
               [
				'category_id'   => 14,
				'title'         => 'Email positions',
				'description'   => 'Positions that are available inside emails.',
				'display_order' => 15
			],
               [
				'category_id'   => 15,
				'title'         => 'Showcase positions',
				'description'   => 'Positions that are available on Showcase pages.',
				'display_order' => 16
			]
		];

		foreach ($categories as $category)
		{
			$em = $this->em->create('Siropu\AdsManager:PositionCategory');
			$em->bulkSet($category, ['forceSet' => true]);
			$em->saveIfChanged($saved, false);
		}
     }
     public function resetPostionCategories()
     {
          $this->db()->emptyTable('xf_siropu_ads_manager_position_category');
          $this->addDefaultPositionCategories();
     }
}
