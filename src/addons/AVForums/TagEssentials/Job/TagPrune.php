<?php

namespace AVForums\TagEssentials\Job;

use XF\Job\AbstractRebuildJob;

class TagPrune extends AbstractRebuildJob
{
    protected function setupData(array $data)
    {
        $this->defaultData = array_merge([
            'min_usage'        => 2,
            'delete_permanent' => 0,
            'delete_synonyms'  => 0,
        ], $this->defaultData);

        return parent::setupData($data);
    }

    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();

        $extraSql = '';
        if (empty($this->data['delete_permanent']))
        {
            $extraSql .= ' and permanent = 0 ';
        }
        if (empty($this->data['delete_synonyms']))
        {
            $extraSql .= ' and
                          not exists(select tag_id
                                    from xf_tagess_synonym as tagess_synonym
                                    where tagess_synonym.tag_id = xf_tag.tag_id or tagess_synonym.parent_tag_id = xf_tag.tag_id) ';
        }

        return $db->fetchAllColumn($db->limit(
            "
            select tag_id
            from xf_tag
            where tag_id > ? and use_count <= ? {$extraSql}
            ORDER BY tag_id
			", $batch
        ), [$start, $this->data['min_usage']]);
    }

    protected function rebuildById($id)
    {
        /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
        $tag = \XF::app()->find('XF:Tag', $id);
        if ($tag)
        {
            $tag->delete();
        }
    }

    protected function getStatusType()
    {
        return \XF::phrase('tags');
    }
}