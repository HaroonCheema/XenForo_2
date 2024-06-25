<?php
/**
 * @noinspection PhpMultipleClassDeclarationsInspection
 */

namespace NF\GiftUpgrades\Entity;

use NF\GiftUpgrades\Repository\GiftUpgrade as GiftUpgradeRepo;
use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Structure;
use function array_key_exists;

/**
 * Trait GiftTrait
 *
 * GETTERS
 * @property-read int $GiftCount
 *
 * RELATIONS
 * @property-read AbstractCollection|GiftUpgrade[] $Gifts
 */
trait GiftTrait
{
    /**
     * @param string|null $error
     * @return bool
     */
    public function canViewGiftsList(&$error = null): bool
    {
        return true;
    }

    public function getGiftCount(): int
    {
        if (!(\XF::options()->nfDisplayGiftingOnWarnedContent ?? true) && $this->isValidKey('warning_id') && $this->warning_id)
        {
            return 0;
        }

        $structure = $this->_structure;
        if (isset($structure->columns['embed_metadata']))
        {
            $metadata = $this->embed_metadata;
            if (is_array($metadata) && isset($metadata['nfGiftCount']))
            {
                return $metadata['nfGiftCount'];
            }
        }

        return 0;
    }

    public function getGiftHandler(): ?\NF\GiftUpgrades\Gift\AbstractHandler
    {
        return GiftUpgradeRepo::get()->getGiftHandler($this->getEntityContentType());
    }

    protected function getGiftRoute(): string
    {
        return $this->getGiftHandler()->getGiftRoute();
    }

    protected function getGiftsRoute(): string
    {
        return $this->getGiftHandler()->getGiftsRoute();
    }

    protected function _preSave()
    {
        $structure = $this->_structure;
        if (isset($structure->columns['embed_metadata']) && $this->isChanged('embed_metadata'))
        {
            // XF doesn't preserve the contents of embed_metadata across edits, so grab the value out of previous values and copy the gift count across
            $oldMetaData = $this->getPreviousValue('embed_metadata');
            $metadata = $this->embed_metadata;
            if (!isset($metadata['nfGiftCount']) && isset($oldMetaData['nfGiftCount']))
            {
                $metadata['nfGiftCount'] = $oldMetaData['nfGiftCount'];
                $this->embed_metadata = $metadata;
            }
        }

        parent::_preSave();
    }

    /**
     * @param Structure $structure
     * @return Structure
     * @throws \LogicException
     * @noinspection PhpMissingReturnTypeInspection
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->relations['Gifts'] = [
            'entity'     => 'NF\GiftUpgrades:GiftUpgrade',
            'type'       => self::TO_MANY,
            'conditions' => [
                ['content_type', '=', $structure->contentType],
                ['content_id', '=', '$' . $structure->primaryKey]
            ],
            'order'      => 'gift_date'
        ];

        $structure->getters['giftRoute'] = ['getter' => 'getGiftRoute', 'cache' => true];
        $structure->getters['giftsRoute'] = ['getter' => 'getGiftsRoute', 'cache' => true];
        $structure->getters['GiftCount'] = ['getter' => 'getGiftCount', 'cache' => false];
        $structure->options['nfGift'] = true;

        if (array_key_exists('waring_id', $structure->columns) &&
            isset($structure->behaviors['XF:Indexable']['checkForUpdates']) &&
            !(\XF::options()->nfDisplayGiftingOnWarnedContent ?? true))
        {
            $structure->behaviors['XF:Indexable']['checkForUpdates'][] = 'warning_id';
        }

        return $structure;
    }
}
