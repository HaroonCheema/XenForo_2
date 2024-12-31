<?php

namespace OzzModz\Badges\Repository;

use OzzModz\Badges\Addon;

class BadgeTier extends \XF\Mvc\Entity\Repository
{
	public function findBadgeTiers()
	{
		return $this->finder(Addon::shortName('BadgeTier'))
			->setDefaultOrder('display_order', 'ASC');
	}

	public function getBadgeTiersOptionsData($includeEmpty = true)
	{
		$choices = [];
		if ($includeEmpty)
		{
			$choices = [
				0 => ['_type' => 'option', 'value' => 0, 'label' => \XF::phrase('(none)')]
			];
		}

		$badgeTierList = $this->findBadgeTiers();

		/** @var \OzzModz\Badges\Entity\BadgeTier $badgeTier */
		foreach ($badgeTierList->fetch() AS $badgeTier)
		{
			$choices[$badgeTier->badge_tier_id] = [
				'value' => $badgeTier->badge_tier_id,
				'label' => $badgeTier->title
			];
		}

		return $choices;
	}

	public function getBadgeTierCacheData()
	{
		$data = [];
		/** @var \OzzModz\Badges\Entity\BadgeTier $badgeTier */
		foreach ($this->finder(Addon::shortName('BadgeTier'))->fetch() AS $badgeTier)
		{
			$data[$badgeTier->badge_tier_id] = $badgeTier->toArray();
			$data[$badgeTier->badge_tier_id]['title_phrase'] = $badgeTier->getTitlePhraseName();
		}

		return $data;
	}

	public function rebuildBadgeTiersCache()
	{
		$cache = $this->getBadgeTierCacheData();
		\XF::registry()->set('ozzmodz_badges_tiers', $cache);

		/** @var \XF\Repository\Style $styleRepo */
		$styleRepo = $this->repository('XF:Style');
		$styleRepo->updateAllStylesLastModifiedDateLater();

		return $cache;
	}

}