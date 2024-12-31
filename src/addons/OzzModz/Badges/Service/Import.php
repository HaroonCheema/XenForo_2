<?php

namespace OzzModz\Badges\Service;

use OzzModz\Badges\Addon;

class Import extends \XF\Service\AbstractXmlImport
{
	protected $newTierIdMap = [];
	protected $newCategoryIdMap = [];
	protected $newBadgeIdMap = [];

	public function import(\SimpleXMLElement $xml)
	{
		$xmlTiers = $xml->badge_tiers;
		$this->importTiers($xmlTiers);

		$xmlCategories = $xml->badge_categories;
		$this->importCategories($xmlCategories);

		$xmlBadges = $xml->badges;
		$this->importBadges($xmlBadges);
	}

	// Tier

	protected function importTiers(\SimpleXMLElement $xmlTiers)
	{
		$existingTiers = $this->finder(Addon::shortName('BadgeTier'))
			->where('badge_tier_id', $this->getBadgeTierIds($xmlTiers->badge_tier))
			->order('badge_tier_id')
			->fetch();

		foreach ($xmlTiers->badge_tier as $xmlTier)
		{
			$data = $this->getTierDataFromXml($xmlTier);

			$badgeTierId = isset($xmlTier['badge_tier_id']) ? intval($xmlTier['badge_tier_id']) : null;
			if ($badgeTierId && $existingTiers->count() && $existingTiers->offsetGet($badgeTierId))
			{
				/** @var \OzzModz\Badges\Entity\BadgeTier $badgeTier */
				$badgeTier = $this->em()->find(Addon::shortName('BadgeTier'), $badgeTierId);
			}
			else
			{
				/** @var \OzzModz\Badges\Entity\BadgeTier $badgeTier */
				$badgeTier = $this->em()->create(Addon::shortName('BadgeTier'));
			}

			$badgeTier->bulkSet($data);

			/** @var \XF\Entity\Phrase $masterPhrase */
			$masterPhrase = $badgeTier->getMasterTitlePhrase();
			$masterPhrase->phrase_text = (string) $xmlTier['title'];

			$badgeTier->addCascadedSave($masterPhrase);
			$badgeTier->save(false);

			$oldTierId = intval($xmlTier['badge_tier_id']);
			$this->newTierIdMap[$oldTierId] = $badgeTier->badge_tier_id;
		}
	}

	protected function getBadgeTierIds(\SimpleXMLElement $xmlBadgeTiers)
	{
		$tierIds = [];
		foreach ($xmlBadgeTiers as $xmlBadgeTier)
		{
			$tierIds[] = (string) $xmlBadgeTier['badge_tier_id'];
		}
		return $tierIds;
	}

	protected function getTierDataFromXml(\SimpleXMLElement $xmlTier)
	{
		$tierData = [];

		foreach ($this->getTierAttributes() as $attr)
		{
			if (!empty($xmlTier[$attr]))
			{
				$tierData[$attr] = (string) $xmlTier[$attr];
			}
		}

		$tierData['css'] = \XF\Util\Xml::processSimpleXmlCdata($xmlTier->css);

		return $tierData;
	}

	protected function getTierAttributes()
	{
		return [
			'color',
			'display_order',
		];
	}

	// Category

	protected function importCategories(\SimpleXMLElement $xmlCategories)
	{
		$existingCategories = $this->finder(Addon::shortName('BadgeCategory'))
			->where('badge_category_id', $this->getBadgeCategoryIds($xmlCategories->badge_category))
			->order('badge_category_id')
			->fetch();

		foreach ($xmlCategories->badge_category as $xmlCategory)
		{
			$data = $this->getCategoryDataFromXml($xmlCategory);

			$badgeCategoryId = isset($xmlCategory['badge_category_id']) ? intval($xmlCategory['badge_category_id']) : null;
			if ($badgeCategoryId && $existingCategories->count() && $existingCategories->offsetGet($badgeCategoryId))
			{
				/** @var \OzzModz\Badges\Entity\BadgeCategory $badgeCategory */
				$badgeCategory = $this->em()->find(Addon::shortName('BadgeCategory'), $badgeCategoryId);
			}
			else
			{
				/** @var \OzzModz\Badges\Entity\BadgeCategory $badgeCategory */
				$badgeCategory = $this->em()->create(Addon::shortName('BadgeCategory'));
			}

			$badgeCategory->bulkSet($data);

			/** @var \XF\Entity\Phrase $masterPhrase */
			$masterPhrase = $badgeCategory->getMasterTitlePhrase();
			$masterPhrase->phrase_text = (string) $xmlCategory['title'];

			$badgeCategory->addCascadedSave($masterPhrase);
			$badgeCategory->save(false);

			$oldCategoryId = intval($xmlCategory['badge_category_id']);
			$this->newCategoryIdMap[$oldCategoryId] = $badgeCategory->badge_category_id;
		}
	}

	protected function getBadgeCategoryIds(\SimpleXMLElement $xmlBadgeCategories)
	{
		$categoryIds = [];
		foreach ($xmlBadgeCategories as $xmlBadgeCategory)
		{
			$categoryIds[] = (string) $xmlBadgeCategory['badge_category_id'];
		}
		return $categoryIds;
	}

	protected function getCategoryDataFromXml(\SimpleXMLElement $xmlCategory)
	{
		$categoryData = [];

		foreach ($this->getCategoryAttributes() as $attr)
		{
			if (!empty($xmlCategory[$attr]))
			{
				$categoryData[$attr] = (string) $xmlCategory[$attr];
			}
		}

		$categoryData['image_url'] = \XF\Util\Xml::processSimpleXmlCdata($xmlCategory->image_url);
		$categoryData['image_url_2x'] = \XF\Util\Xml::processSimpleXmlCdata($xmlCategory->image_url_2x);
		$categoryData['image_url_3x'] = \XF\Util\Xml::processSimpleXmlCdata($xmlCategory->image_url_3x);
		$categoryData['image_url_4x'] = \XF\Util\Xml::processSimpleXmlCdata($xmlCategory->image_url_4x);

		return $categoryData;
	}

	protected function getCategoryAttributes()
	{
		return [
			'icon_type',
			'fa_icon',
			'mdi_icon',
			'class',
			'display_order',
		];
	}

	// Badge

	protected function importBadges(\SimpleXMLElement $xmlBadges)
	{
		$stackingBadgeIds = [];

		foreach ($xmlBadges->badge as $xmlBadge)
		{
			$data = $this->getBadgeDataFromXml($xmlBadge);
			$phrases = $this->getBadgePhrasesFromXml($xmlBadge);

			/** @var \OzzModz\Badges\Entity\Badge $badge */
			$badge = $this->em()->create(Addon::shortName('Badge'));

			$tierId = $xmlBadge['badge_tier_id'] ? intval($xmlBadge['badge_tier_id']) : null;
			if ($tierId)
			{
				$badge->badge_tier_id = $this->newTierIdMap[$tierId];
			}
			$categoryId = $xmlBadge['badge_category_id'] ? intval($xmlBadge['badge_category_id']) : null;
			if ($categoryId)
			{
				$badge->badge_category_id = $this->newCategoryIdMap[$categoryId];
			}

			$badge->bulkSet($data);

			foreach ($phrases as $type => $text)
			{
				if ($type == 'title')
				{
					$masterTitlePhrase = $badge->getMasterTitlePhrase();
					$masterTitlePhrase->phrase_text = $text;

					$badge->addCascadedSave($masterTitlePhrase);
				}
				elseif ($type == 'description')
				{
					$masterDescriptionPhrase = $badge->getMasterDescriptionPhrase();
					$masterDescriptionPhrase->phrase_text = $text;

					$badge->addCascadedSave($masterDescriptionPhrase);
				}
				elseif ($type == 'alt_description')
				{
					$masterAltDescriptionPhrase = $badge->getMasterAltDescriptionPhrase();
					$masterAltDescriptionPhrase->phrase_text = $text;

					$badge->addCascadedSave($masterAltDescriptionPhrase);
				}
			}

			$badge->save(false);

			$this->newBadgeIdMap[intval($xmlBadge['badge_id'])] = $badge->badge_id;

			$stackingBadgeId = $xmlBadge['stacking_badge_id'] ? intval($xmlBadge['stacking_badge_id']) : null;
			if ($stackingBadgeId)
			{
				$stackingBadgeIds[$badge->badge_id] = $stackingBadgeId;
			}
		}

		foreach ($stackingBadgeIds as $newBadgeId => $stackingBadgeId)
		{
			/** @var \OzzModz\Badges\Entity\Badge $badge */
			$badge = $this->em()->find(Addon::shortName('Badge'), $newBadgeId);

			if ($badge && isset($this->newBadgeIdMap[$stackingBadgeId]))
			{
				$badge->fastUpdate('stacking_badge_id', $this->newBadgeIdMap[$stackingBadgeId]);
			}
		}
	}

	protected function getBadgeDataFromXml(\SimpleXMLElement $xmlBadges)
	{
		$badgeData = [];

		foreach ($this->getBadgeAttributes() as $attr)
		{
			if (!empty($xmlBadges[$attr]))
			{
				$badgeData[$attr] = (string) $xmlBadges[$attr];
			}
		}

		$badgeData['image_url'] = \XF\Util\Xml::processSimpleXmlCdata($xmlBadges->image_url);
		$badgeData['image_url_2x'] = \XF\Util\Xml::processSimpleXmlCdata($xmlBadges->image_url_2x);
		$badgeData['image_url_3x'] = \XF\Util\Xml::processSimpleXmlCdata($xmlBadges->image_url_3x);
		$badgeData['image_url_4x'] = \XF\Util\Xml::processSimpleXmlCdata($xmlBadges->image_url_4x);

		if (!empty($xmlBadges->user_criteria))
		{
			$badgeData['user_criteria'] = json_decode($xmlBadges->user_criteria, true);
		}

		return $badgeData;
	}

	protected function getBadgePhrasesFromXml(\SimpleXMLElement $xmlBadges)
	{
		return [
			'title' => (string) $xmlBadges['title'],
			'description' => \XF\Util\Xml::processSimpleXmlCdata($xmlBadges->description),
			'alt_description' => \XF\Util\Xml::processSimpleXmlCdata($xmlBadges->alt_description),
		];
	}

	protected function getBadgeAttributes()
	{
		return [
			'icon_type',
			'fa_icon',
			'mdi_icon',
			'class',
			'display_order',
			'is_revoked',
			'is_manually_awarded',
			'is_repetitive',
			'repeat_delay'
		];
	}

}

