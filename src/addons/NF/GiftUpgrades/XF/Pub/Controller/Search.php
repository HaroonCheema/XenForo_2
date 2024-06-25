<?php

namespace NF\GiftUpgrades\XF\Pub\Controller;

use NF\GiftUpgrades\Repository\GiftUpgrade as GiftUpgradeRepo;
use NF\GiftUpgrades\Search\IGiftCategorySearcher;
use NF\GiftUpgrades\Search\IGiftSearcher;
use SV\SearchImprovements\Globals;
use SV\SearchImprovements\XF\Search\Query\Constraints\RangeConstraint;
use XF\Http\Request;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\AbstractReply;
use XF\Mvc\Reply\View as ViewReply;
use XF\Search\Query\Query;
use function count;

/**
 * @extends \XF\Pub\Controller\Search
 */
class Search extends XFCP_Search
{
    /**
     * @param ParameterBag $params
     * @return AbstractReply
     */
    public function actionIndex(ParameterBag $params)
    {
        $response = parent::actionIndex($params);

        if ($response instanceof ViewReply)
        {
            $searcher = $this->app->search();
            $type = (string)$response->getParam('type');
            $supportsGifts = false;
            $giftCategories = $this->em()->getEmptyCollection();

            if ($type === '')
            {
                $supportsGifts = true;
                $giftCategories = GiftUpgradeRepo::get()->getGiftCategoriesForSearch();
            }
            else if ($searcher->isValidContentType($type))
            {
                $typeHandler = $searcher->handler($type);
                if (!$typeHandler->getSearchFormTab())
                {
                    $typeHandler = null;
                }
                if ($typeHandler instanceof IGiftSearcher)
                {
                    $supportsGifts = true;
                    if ($typeHandler->hasCategorySupport())
                    {
                        $giftCategories = $typeHandler->getGiftCategoriesForSearch();
                    }
                }
            }

            // avoid use of setParams because of the strange behavior it has
            $response->setParam('nfSupportsGifts', $supportsGifts);
            $response->setParam('nfGiftCategories', $giftCategories);
        }

        return $response;
    }

    /**
     * @param array $data
     * @param array $urlConstraints
     * @return Query
     */
    protected function prepareSearchQuery(array $data, &$urlConstraints = [])
    {
        $query = parent::prepareSearchQuery($data, $urlConstraints);
        $searchRequest = new Request($this->app->inputFilterer(), $data, [], []);

        $mustHaveThreadmark = $searchRequest->filter('c.gifts_only', 'bool');
        if ($mustHaveThreadmark)
        {
            if (\XF::isAddOnActive('SV/SearchImprovements') && Globals::repo()->isUsingElasticSearch())
            {
                // MySqlFt search requires 'gift' to be added as a column
                // *or* to join to another table using $tableReferences parameter and setting $source to the table to join
                $query->withMetadata(new RangeConstraint('gift', 1, RangeConstraint::MATCH_GREATER));
            }
            else
            {
                $query->withMetadata('gift', 1);
            }

            $categories = GiftUpgradeRepo::get()->getGiftCategoriesForSearch();

            if ($categories->count() > 1 && $searchRequest->filter('c.in_gift_categories', 'bool'))
            {
                $inGiftCategories = $searchRequest->filter('c.gift_categories', 'array-uint');
                if (count($inGiftCategories) !== 0)
                {
                    $query->withMetadata('giftCategory', $inGiftCategories);
                }
                else
                {
                    unset($urlConstraints['c.in_gift_categories']);
                    unset($urlConstraints['c.gift_categories']);
                }
            }
            else
            {
                unset($urlConstraints['c.in_gift_categories']);
                unset($urlConstraints['c.gift_categories']);
            }
        }
        else
        {
            unset($urlConstraints['c.gifts_only']);
            unset($urlConstraints['c.in_gift_categories']);
            unset($urlConstraints['c.gift_categories']);
        }

        return $query;
    }

}