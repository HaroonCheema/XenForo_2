<?php

namespace OzzModz\Badges\Service;

use OzzModz\Badges\Addon;
use XF\Mvc\Entity\Finder;
use XF\Util\Xml;

class Export extends \XF\Service\AbstractXmlExport
{
	public function getRootName()
	{
		return 'badges_export';
	}

	public function export(Finder $finder)
	{
		$finder = $finder->fetch();

		if (!$finder->count())
		{
			$this->throwNoBadgesError();
		}

		$badgeCategories = $this->finder(Addon::shortName('BadgeCategory'))
			->with('MasterTitle')
			->order(['display_order'])
			->where('badge_category_id', $finder->pluckNamed('badge_category_id'));

		$badgeTiers = $this->finder(Addon::shortName('BadgeTier'))
			->with('MasterTitle')
			->order(['display_order'])
			->where('badge_tier_id', $finder->pluckNamed('badge_tier_id'));

		return $this->exportFromArray($finder->toArray(), $badgeCategories->fetch()->toArray(), $badgeTiers->fetch()->toArray());
	}

	public function exportFromArray(array $badges, array $badgeCategories, array $badgeTiers)
	{
		$document = $this->createXml();
		$rootNode = $document->createElement($this->getRootName());
		$document->appendChild($rootNode);

		if (!count($badges))
		{
			$this->throwNoBadgesError();
		}

		$badgesNode = $document->createElement('badges');
		foreach ($badges as $badge)
		{
			$badgeNode = $document->createElement('badge');
			$this->exportBadge($badge, $badgeNode, $document);

			$badgesNode->appendChild($badgeNode);
		}

		$categoriesNode = $document->createElement('badge_categories');
		foreach ($badgeCategories as $badgeCategory)
		{
			$categoryNode = $document->createElement('badge_category');
			$this->exportBadgeCategory($badgeCategory, $categoryNode, $document);

			$categoriesNode->appendChild($categoryNode);
		}

		$tiersNode = $document->createElement('badge_tiers');
		foreach ($badgeTiers as $badgeTier)
		{
			$tierNode = $document->createElement('badge_tier');
			$this->exportBadgeTier($badgeTier, $tierNode, $document);

			$tiersNode->appendChild($tierNode);
		}

		$rootNode->appendChild($tiersNode);
		$rootNode->appendChild($categoriesNode);
		$rootNode->appendChild($badgesNode);

		return $document;
	}

	protected function exportBadge($badge, \DOMElement $badgeNode, \DOMDocument $document)
	{
		$badgeNode->setAttribute('badge_id', $badge['badge_id']);

		if ($badge['badge_category_id'])
		{
			$badgeNode->setAttribute('badge_category_id', $badge['badge_category_id']);
		}

		if ($badge['badge_tier_id'])
		{
			$badgeNode->setAttribute('badge_tier_id', $badge['badge_tier_id']);
		}

		if ($badge['stacking_badge_id'])
		{
			$badgeNode->setAttribute('stacking_badge_id', $badge['stacking_badge_id']);
		}

		$badgeNode->setAttribute('title', $badge['title']);
		$badgeNode->appendChild(Xml::createDomElement($document, 'description', $badge['description']));
		$badgeNode->appendChild(Xml::createDomElement($document, 'alt_description', $badge['alt_description']));

		$badgeNode->appendChild(Xml::createDomElement($document, 'image_url', $badge['image_url']));
		$badgeNode->appendChild(Xml::createDomElement($document, 'image_url_2x', $badge['image_url_2x']));
		$badgeNode->appendChild(Xml::createDomElement($document, 'image_url_3x', $badge['image_url_3x']));
		$badgeNode->appendChild(Xml::createDomElement($document, 'image_url_4x', $badge['image_url_4x']));

		$badgeNode->appendChild(Xml::createDomElement($document, 'user_criteria', json_encode($badge['user_criteria'])));

		$badgeNode->setAttribute('class', $badge['class']);

		$badgeNode->setAttribute('icon_type', $badge['icon_type']);
		$badgeNode->setAttribute('fa_icon', $badge['fa_icon']);
		$badgeNode->setAttribute('mdi_icon', $badge['mdi_icon']);
		$badgeNode->setAttribute('is_revoked', $badge['is_revoked']);
		$badgeNode->setAttribute('is_manually_awarded', $badge['is_manually_awarded']);
		$badgeNode->setAttribute('is_repetitive', $badge['is_repetitive']);
		$badgeNode->setAttribute('repeat_delay', $badge['repeat_delay']);

		$badgeNode->setAttribute('display_order', $badge['display_order']);
	}

	protected function exportBadgeCategory($badgeCategory, \DOMElement $categoryNode, \DOMDocument $document)
	{
		$categoryNode->setAttribute('badge_category_id', $badgeCategory['badge_category_id']);
		$categoryNode->setAttribute('title', $badgeCategory['title']);

		$categoryNode->setAttribute('icon_type', $badgeCategory['icon_type']);
		$categoryNode->setAttribute('fa_icon', $badgeCategory['fa_icon']);
		$categoryNode->setAttribute('mdi_icon', $badgeCategory['mdi_icon']);

		$categoryNode->appendChild(Xml::createDomElement($document, 'image_url', $badgeCategory['image_url']));
		$categoryNode->appendChild(Xml::createDomElement($document, 'image_url_2x', $badgeCategory['image_url_2x']));
		$categoryNode->appendChild(Xml::createDomElement($document, 'image_url_3x', $badgeCategory['image_url_3x']));
		$categoryNode->appendChild(Xml::createDomElement($document, 'image_url_4x', $badgeCategory['image_url_4x']));

		$categoryNode->setAttribute('class', $badgeCategory['class']);
		$categoryNode->setAttribute('display_order', $badgeCategory['display_order']);
	}

	protected function exportBadgeTier($badgeTier, \DOMElement $tierNode, \DOMDocument $document)
	{
		$tierNode->setAttribute('badge_tier_id', $badgeTier['badge_tier_id']);
		$tierNode->setAttribute('title', $badgeTier['title']);
		$tierNode->setAttribute('color', $badgeTier['color']);

		$tierNode->appendChild(Xml::createDomElement($document, 'css', $badgeTier['css']));

		$tierNode->setAttribute('display_order', $badgeTier['display_order']);
	}

	protected function throwNoBadgesError()
	{
		throw new \XF\PrintableException(Addon::phrase('please_select_at_least_one_badge')->render());
	}
}