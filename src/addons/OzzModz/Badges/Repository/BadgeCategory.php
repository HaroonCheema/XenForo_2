<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Repository;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Repository;

class BadgeCategory extends Repository
{
	public function getDefaultCategory()
	{
		/** @var \OzzModz\Badges\Entity\BadgeCategory $category */
		$category = $this->em->create(Addon::shortName('BadgeCategory'));
		$category->setTrusted('badge_category_id', 0);
		$category->setTrusted('display_order', 0);
		$category->setReadOnly(true);

		return $category;
	}

	public function getBadgeCategoriesForList($getDefault = false)
	{
		$categories = $this->finder(Addon::shortName('BadgeCategory'))
			->with('MasterTitle')
			->order('display_order')
			->fetch();

		if ($getDefault)
		{
			$defaultCategory = $this->getDefaultCategory();
			$defaultCategories = new ArrayCollection([$defaultCategory]);
			$categories = $categories->merge($defaultCategories);
		}

		return $categories;
	}

	public function getBadgeCategoryTitlePairs()
	{
		$badgeCategories = $this->finder(Addon::shortName('BadgeCategory'))->order('display_order');
		return $badgeCategories->fetch()->pluckNamed('title', 'badge_category_id');
	}

	public function purgePhrases()
	{
		$phrases = $this->finder('XF:Phrase')
			->where('title', 'LIKE', '%ozzmodz_badges_badge_category_title.%')
			->fetch();

		foreach ($phrases as $phrase)
		{
			$phrase->delete(false);
		}
	}
}