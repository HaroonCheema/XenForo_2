<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Repository;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\Repository;

class Badge extends Repository
{
	/**
	 * @return \XF\Mvc\Entity\Finder|\OzzModz\Badges\Finder\Badge
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	public function findBadgesForList()
	{
		return $this->finder(Addon::shortName('Badge'))
			->setDefaultOrder('display_order');
	}

	/**
	 * @return \XF\Mvc\Entity\Finder|\OzzModz\Badges\Finder\Badge
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	public function findBadgesForAutoAward()
	{
		return $this->finder(Addon::shortName('Badge'))
			->where('active', '=', '1')
			->whereOr(
				['is_revoked', '=', 1],
				['user_criteria', '!=', '[]']
			)
			->setDefaultOrder('badge_id');
	}

	public function getBadgesOptionsData($includeEmpty = true, $includeDisabled = true, $enableTypes = null)
	{
		$choices = [];

		if ($includeEmpty)
		{
			$choices[0] = [
				'_type' => 'option',
				'value' => 0,
				'label' => \XF::phrase('(none)')
			];
		}

		$badgeFinder = $this->findBadgesForList();
		if (!$includeDisabled)
		{
			$badgeFinder->onlyActive();
		}

		$badges = $badgeFinder->fetch();
		$badgeCategories = $this->getBadgeCategoryRepo()->getBadgeCategoriesForList(true);

		$groupedBadges = $badges->groupBy('badge_category_id');

		/** @var \OzzModz\Badges\Entity\BadgeCategory $category */
		foreach ($badgeCategories as $categoryId => $category)
		{
			$options = [];
			$badgesInCategory = $groupedBadges[$categoryId] ?? [];

			/** @var \OzzModz\Badges\Entity\Badge $badge */
			foreach ($badgesInCategory as $badge)
			{
				$options[$badge->badge_id] = [
					'value' => $badge->badge_id,
					'label' => $badge->title
				];

				if (!isset($enableTypes['unawardable']))
				{
					$options[$badge->badge_id]['disabled'] = $badge->isAwardable() ? false : 'disabled';
				}
				else
				{
					$options[$badge->badge_id]['disabled'] = false;
				}
			}

			$choices[] = [
				'_type' => 'optgroup',
				'label' => $category->title,
				'options' => $options,
			];
		}

		return $choices;
	}

	public function getBadgesCache()
	{
		$output = [];

		/** @var \OzzModz\Badges\Entity\Badge[] $badges */
		$badges = $this->findBadgesForList()->onlyActive()->fetch();
		foreach ($badges as $key => $badge)
		{
			$output[$key] = $badge->toArray();
			$output[$key]['title_phrase'] = $badge->getTitlePhraseName();
		}

		return $output;
	}

	/**
	 * @return array
	 */
	public function rebuildBadgesCache()
	{
		$cache = $this->getBadgesCache();
		\XF::registry()->set('ozzmodz_badges_badge', $cache);
		return $cache;
	}

	public function purgePhrases()
	{
		$phrases = $this->finder('XF:Phrase')
			->whereOr([
				['title', 'LIKE', '%ozzmodz_badges_badge_title.%'],
				['title', 'LIKE', '%ozzmodz_badges_badge_description.%'],
				['title', 'LIKE', '%ozzmodz_badges_badge_alt_description.%'],
			])
			->fetch();

		foreach ($phrases as $phrase)
		{
			$phrase->delete(false);
		}
	}

	//
	// UTIL
	//

	/**
	 * @return Repository|BadgeCategory
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	protected function getBadgeCategoryRepo()
	{
		return $this->repository(Addon::shortName('BadgeCategory'));
	}
}