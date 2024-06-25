<?php

namespace NF\GiftUpgrades\Repository;

use NF\GiftUpgrades\Entity\IGiftable;
use NF\GiftUpgrades\Finder\GiftUpgrade as GiftUpgradeFinder;
use NF\GiftUpgrades\Gift\AbstractHandler;
use XF\Entity\User as UserEntity;
use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Repository;

/**
 * Class GiftUpgrade
 *
 * @package NF\GiftUpgrades\Repository
 */
class GiftUpgrade extends Repository
{
    public static function get(): self
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return \XF::repository('NF\GiftUpgrades:GiftUpgrade');
    }

    public function getGiftHandler(string $type, bool $throw = false): ?AbstractHandler
    {
        $handlerClass = \XF::app()->getContentTypeFieldValue($type, 'nf_gift_handler_class');
        if (!$handlerClass)
        {
            if ($throw)
            {
                throw new \InvalidArgumentException("No gift handler for '$type'");
            }
            return null;
        }

        if (!class_exists($handlerClass))
        {
            if ($throw)
            {
                throw new \InvalidArgumentException("Gift handler for '$type' does not exist: $handlerClass");
            }
            return null;
        }

        $handlerClass = \XF::extendClass($handlerClass);
        return new $handlerClass($type);
    }

    public function getGiftHandlers(): array
    {
        $handlers = [];

        foreach (\XF::app()->getContentTypeField('nf_gift_handler_class') AS $contentType => $handlerClass)
        {
            if (class_exists($handlerClass))
            {
                $handlerClass = \XF::extendClass($handlerClass);
                $handlers[$contentType] = new $handlerClass($contentType);
            }
        }

        return $handlers;
    }

    public function getGiftCounts(string $contentType, int $id): int
    {
        return (int)$this->db()->fetchOne('
            select count(*)
            from xf_nf_gifted_content
            where content_type = ? and content_id = ? 
        ', [$contentType, $id]);
    }

    public function rebuildGiftCounts(Entity $content, ?int $giftCount = null): void
    {
        if ($giftCount === null)
        {
            $giftCount = $this->getGiftCounts($content->getEntityContentType(), $content->getEntityId());
        }

        $structure = $content->structure();
        if (empty($structure->columns['embed_metadata']))
        {
            return;
        }

        $originalMetaData = $content->embed_metadata ?? [];
        $metadata =  $originalMetaData ?: [];

        if ($giftCount)
        {
            $metadata['nfGiftCount'] = $giftCount;
        }
        else
        {
            unset($metadata['nfGiftCount']);
        }

        $content->fastUpdate('embed_metadata', $metadata);
    }


    public function getGiftFinderForList(Entity $entity, bool $includeAnon = null): GiftUpgradeFinder
    {
        $finder = GiftUpgradeFinder::get();
        $finder->where('content_type', $entity->getEntityContentType())
               ->where('content_id', $entity->getEntityId())
               ->order('gift_date');

        if ($includeAnon !== null)
        {
            $finder->where('is_anonymous', $includeAnon);
        }

        return $finder;
    }

    public function countGiftsReceivedByUser(UserEntity $user): int
    {
        return (int)$this->db()->fetchOne('
            SELECT COUNT(*)
            FROM xf_nf_gifted_content
            WHERE content_user_id = ?
        ', [$user->user_id]);
    }

    public function countGiftsGivenByUser(UserEntity $user): int
    {
        return (int)$this->db()->fetchOne('
            SELECT COUNT(*)
            FROM xf_nf_gifted_content
            WHERE gift_user_id = ?
        ', [$user->user_id]);
    }

    public function getGiftCategories(): AbstractCollection
    {
        return $this->app()->em()->getEmptyCollection();
    }

    public function getGiftCategoriesForSearch(): AbstractCollection
    {
        return $this->getGiftCategories()->filterViewable();
    }

    public function hasCategorySupport(): bool
    {
        return false;
    }

    /**
     * Returns a list of categories ids with counts associated
     *
     * @param Entity|IGiftable $entity
     * @return array [category_id => count, ...]
     * @noinspection PhpUnusedParameterInspection
     */
    public function getGiftCategoryCounts(IGiftable $entity): array
    {
        return [];
    }
}