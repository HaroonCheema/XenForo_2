<?php

namespace NF\GiftUpgrades\XF\Search\Data;

use NF\GiftUpgrades\Entity\IGiftable;
use NF\GiftUpgrades\Search\GiftSearcherTrait;
use NF\GiftUpgrades\Search\IGiftSearcher;
use XF\Mvc\Entity\Entity;

/**
 * @extends \XF\Search\Data\Thread
 */
class Thread extends XFCP_Thread implements IGiftSearcher
{
    use GiftSearcherTrait;

    /** @noinspection PhpMissingReturnTypeInspection */
    public function getIndexData(Entity $entity)
    {
        /** @var \XF\Entity\Thread $entity */
        $index = parent::getIndexData($entity);

        if ($index)
        {
            /** @var IGiftable|null $firstPost */
            $firstPost = $entity->FirstPost;
            if ($firstPost !== null && $firstPost->GiftCount !== 0)
            {
                $this->addGiftDataToIndex($index, $firstPost);
            }
        }

        return $index;
    }
}