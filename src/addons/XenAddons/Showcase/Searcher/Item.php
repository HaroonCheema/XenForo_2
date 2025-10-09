<?php

namespace XenAddons\Showcase\Searcher;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Manager;
use XF\Searcher\AbstractSearcher;

/**
 * @method \XenAddons\Showcase\Finder\Item getFinder()
 */
class Item extends AbstractSearcher
{
	protected $allowedRelations = ['Category'];

	protected $formats = [
		'title' => 'like',
		'description' => 'like',
		'username' => 'like',
		'create_date' => 'date',
	];

	protected $whitelistOrder = [
		'title' => true,
		'username' => true,
		'create_date' => true,
		'comment_count' => true,
		'rating_count' => true,
		'review_count' => true,
		'update_count' => true,
		'view_count' => true,
		'reaction_score' => true
	];

	protected $order = [['create_date', 'desc']];

	protected function getEntityType()
	{
		return 'XenAddons\Showcase:Item';
	}

	protected function getDefaultOrderOptions()
	{
		return [
			'create_date' => \XF::phrase('date'),
			'title' => \XF::phrase('title'),
			'comment_count' => \XF::phrase('comments'),
			'rating_count' => \XF::phrase('xa_sc_ratings'),
			'review_count' => \XF::phrase('xa_sc_reviews'),
			'update_count' => \XF::phrase('xa_sc_updates'),
			'view_count' => \XF::phrase('views'),
			'reaction_score' => \XF::phrase('reaction_score')
		];
	}

	protected function applySpecialCriteriaValue(Finder $finder, $key, $value, $column, $format, $relation)
	{
		if ($key == 'prefix_id' && $value == -1)
		{
			// any prefix so skip condition
			return true;
		}

		if ($key == 'category_id' && $value == 0)
		{
			// any node so skip condition
			return true;
		}

		if ($key == 'item_field')
		{
			$exactMatchFields = !empty($value['exact']) ? $value['exact'] : [];
			$customFields = array_merge($value, $exactMatchFields);
			unset($customFields['exact']);

			$conditions = [];
			foreach ($customFields AS $fieldId => $value)
			{
				if ($value === '' || (is_array($value) && !$value))
				{
					continue;
				}

				$finder->with('CustomFields|' . $fieldId);
				$isExact = !empty($exactMatchFields[$fieldId]);

				foreach ((array)$value AS $possible)
				{
					$columnName = 'CustomFields|' . $fieldId . '.field_value';
					if ($isExact)
					{
						$conditions[] = [$columnName, '=', $possible];
					}
					else
					{
						$conditions[] = [$columnName, 'LIKE', $finder->escapeLike($possible, '%?%')];
					}
				}
			}
			if ($conditions)
			{
				$finder->whereOr($conditions);
			}
		}

		return false;
	}

	public function getFormData()
	{
		/** @var \XenAddons\Showcase\Repository\ItemPrefix $prefixRepo */
		$prefixRepo = $this->em->getRepository('XenAddons\Showcase:ItemPrefix');
		$prefixes = $prefixRepo->getPrefixListData();

		/** @var \XenAddons\Showcase\Repository\Category $categoryRepo */
		$categoryRepo = $this->em->getRepository('XenAddons\Showcase:Category');
		$categories = $categoryRepo->getCategoryOptionsData(false);
		
		return [
			'prefixes' => $prefixes,
			'categories' => $categories
		];
	}

	public function getFormDefaults()
	{
		return [
			'prefix_id' => -1,
			'category_id' => 0,

			'comment_count' => ['end' => -1],
			'rating_count' => ['end' => -1],
			'review_count' => ['end' => -1],
			'update_count' => ['end' => -1],
			'view_count' => ['end' => -1],

			'item_state' => ['visible', 'moderated', 'deleted'],
			'comments_open' => [0, 1],
			'ratings_open' => [0, 1],
		];
	}
}