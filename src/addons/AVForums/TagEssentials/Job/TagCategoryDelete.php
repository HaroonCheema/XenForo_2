<?php

namespace AVForums\TagEssentials\Job;

use XF\Job\AbstractJob;

/**
 * Class TagCategoryDelete
 *
 * @package AVForums\TagEssentials\Job
 */
class TagCategoryDelete extends AbstractJob
{
    protected $defaultData = [
        'tag_category_id' => null,
        'start' => 0,
        'count' => 0,
        'position' => 0,
        'batch' => 200
    ];

    public function run($maxRunTime)
    {
        $startTime = microtime(true);

        $db = $this->app->db();

        if (!$this->data['tag_category_id'])
        {
            return $this->complete();
        }

        $tagIds = $db->fetchAll($db->limit(
            '
				SELECT tag_id
				FROM xf_tag
				WHERE tagess_category_id = ?
					AND tag_id > ?
				ORDER BY tag_id
			', $this->data['batch']
        ), [$this->data['tag_category_id'], $this->data['start']]);

        if (!$tagIds)
        {
            return $this->complete();
        }

        $loopFinished = true;

        foreach ($tagIds AS $tagId)
        {
            $this->data['count']++;
            $this->data['position'] = $tagId;

            /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
            $tag = $this->app->find('XF:Tag', $tagId);
            if ($tag)
            {
                $tag->tagess_category_id = '';
                $tag->save();
            }

            if (microtime(true) - $startTime >= $maxRunTime)
            {
                $loopFinished = false;
                break;
            }
        }

        if ($loopFinished)
        {
            if (!$db->fetchOne('SELECT 1 FROM xf_tag WHERE tagess_category_id = ? AND tag_id > ? LIMIT 1',
                [$this->data['tag_category_id'], $this->data['position']]
            ))
            {
                return $this->complete();
            }
        }

        return $this->resume();
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        $actionPhrase = \XF::phrase('deleting');
        $typePhrase = \XF::phrase('avForumsTagEss_tag_category');

        return sprintf('%s... %s (%s)', $actionPhrase, $typePhrase,
            \XF::language()->numberFormat($this->data['count'])
        );
    }

    /**
     * @return bool
     */
    public function canCancel()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function canTriggerByChoice()
    {
        return false;
    }
}