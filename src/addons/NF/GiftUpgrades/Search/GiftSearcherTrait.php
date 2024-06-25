<?php
/**
 * @noinspection PhpMultipleClassDeclarationsInspection
 * @noinspection PhpMissingReturnTypeInspection
 */

namespace NF\GiftUpgrades\Search;

use NF\GiftUpgrades\Entity\IGiftable;
use NF\GiftUpgrades\Repository\GiftUpgrade as GiftUpgradeRepo;
use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Entity;
use XF\Search\IndexRecord;
use XF\Search\MetadataStructure;

trait GiftSearcherTrait
{
    /** @var GiftUpgradeRepo */
    protected $giftUpgradeRepo;
    protected $hasCategorySupport = false;
    protected $hasRangeSupport = false;

    /**
     * @param string            $contentType
     * @param \XF\Search\Search $searcher
     */
    public function __construct($contentType, \XF\Search\Search $searcher)
    {
        parent::__construct($contentType, $searcher);
        $this->giftUpgradeRepo = GiftUpgradeRepo::get();
        $this->hasRangeSupport = \XF::isAddOnActive('SV/SearchImprovements');
        $this->hasCategorySupport = $this->hasCategorySupport();
    }

    public function hasCategorySupport(): bool
    {
        return false;
    }

    public function getGiftCategoriesForSearch(): AbstractCollection
    {
        return $this->giftUpgradeRepo->getGiftCategoriesForSearch();
    }

    /**
     * @param Entity|IGiftable $entity
     * @return ?IndexRecord
     */
    public function getIndexData(Entity $entity)
    {
        $index = parent::getIndexData($entity);

        if ($index && $entity->GiftCount !== 0)
        {
            $this->addGiftDataToIndex($index, $entity);
        }

        return $index;
    }

    protected function addGiftDataToIndex(IndexRecord $index, IGiftable $entity): void
    {
        $index->metadata['gift'] = $this->hasRangeSupport ? $entity->GiftCount : 1;
        if ($this->hasCategorySupport)
        {
            // todo allow searching by counts by category
            $giftCategories = $this->giftUpgradeRepo->getGiftCategoryCounts($entity);
            $index->metadata['giftCategory'] = array_keys($giftCategories);
        }
    }

    /**
     * @param MetadataStructure $structure
     */
    public function setupMetadataStructure(MetadataStructure $structure)
    {
        parent::setupMetadataStructure($structure);
        $structure->addField('gift', MetadataStructure::INT);
        if ($this->hasCategorySupport)
        {
            $structure->addField('giftCategory', MetadataStructure::INT);
        }
    }
}