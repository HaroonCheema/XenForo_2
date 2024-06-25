<?php
/**
 * @noinspection PhpMultipleClassDeclarationsInspection
 */

namespace NF\GiftUpgrades\XF\Entity;

use NF\GiftUpgrades\Repository\GiftUpgrade as GiftUpgradeRepo;
use function is_array;

/**
 * @extends \XF\Entity\Search
 */
class Search extends XFCP_Search
{
    protected function setupConstraintFields(): void
    {
        parent::setupConstraintFields();

        $this->svIgnoreConstraint[] = 'in_gift_categories';
    }

    protected function expandStructuredSearchConstraint(array &$query, string $key, $value): bool
    {
        if ($key === 'gift_categories' && is_array($value))
        {
            $categories = GiftUpgradeRepo::get()->getGiftCategoriesForSearch();
            foreach ($value as $id)
            {
                $id = (int)$id;
                $category = $categories[$id] ?? null;
                if ($category !== null)
                {
                    $query[$key . '_' . $id] = \XF::phrase('svSearchConstraint.gift_categories', [
                        'category' => $category->title,
                    ]);
                }
            }

            return true;
        }

        return parent::expandStructuredSearchConstraint($query, $key, $value);
    }
}