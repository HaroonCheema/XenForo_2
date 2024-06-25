<?php

namespace NF\GiftUpgrades\Job;

use NF\GiftUpgrades\Gift\AbstractHandler;
use NF\GiftUpgrades\Repository\GiftUpgrade as GiftUpgradeRepo;
use XF\Job\AbstractRebuildJob;
use XF\Mvc\Entity\Structure;

/**
 * Class RebuildContentGiftCount
 *
 * @package NF\GiftUpgrades\Job
 */
class RebuildContentGiftCount extends AbstractRebuildJob
{
    /** @var AbstractHandler */
    protected $handler = null;

    /** @var Structure  */
    protected $structure = null;

    /** @var string */
    protected $entityName = null;

    /** @var GiftUpgradeRepo */
    protected $giftRepo;

    /**
     * @param array $data
     *
     * @return array
     * @throws \Exception
     */
    protected function setupData(array $data): array
    {
        $this->defaultData = array_merge([
            'content_type' => null,
            'upgrade' => false,
        ], $this->defaultData);
        $data = parent::setupData($data);

        $this->giftRepo = GiftUpgradeRepo::get();
        $this->handler = $this->giftRepo->getGiftHandler($data['content_type']);
        if (!$this->handler || !$this->handler->isSupported())
        {
            return $data;
        }

        $this->entityName = \XF::app()->getContentTypeEntity($data['content_type']);
        $this->structure = \XF::em()->getEntityStructure($this->entityName);

        return $data;
    }

    /**
     * @param $start
     * @param $batch
     *
     * @return null|array
     */
    protected function getNextIds($start, $batch): ?array
    {
        if (!$this->data['content_type'] || !$this->entityName || !$this->structure)
        {
            return null;
        }
        $structure = $this->structure;

        $db = $this->app->db();

        if ($this->data['upgrade'])
        {
            return $db->fetchAllColumn($db->limit(
                '
				SELECT distinct content_id
				FROM xf_nf_gifted_content
				WHERE content_type = ? and content_id > ?
				ORDER BY content_id
			', $batch
            ), [$this->data['content_type'], $start]);
        }

        return $db->fetchAllColumn($db->limit(
            "
				SELECT {$structure->primaryKey}
				FROM {$structure->table}
				WHERE {$structure->primaryKey} > ?
				ORDER BY {$structure->primaryKey}
			", $batch
        ), $start);
    }

    /**
     * @param int $id
     */
    protected function rebuildById($id): void
    {
        $content = $this->handler->getContent($id);
        if ($content)
        {
            $this->giftRepo->rebuildGiftCounts($content);
        }
    }

    protected function getStatusType(): \XF\Phrase
    {
        return \XF::phrase('like_counts');
    }
}