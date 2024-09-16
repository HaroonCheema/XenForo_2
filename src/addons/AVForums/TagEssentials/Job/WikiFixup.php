<?php

namespace AVForums\TagEssentials\Job;

use XF\Job\AbstractRebuildJob;

class WikiFixup extends AbstractRebuildJob
{
    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();

        $phrase = (string)\XF::phrase('avForumsTagEss_no_wikipedia_entry_exists');
        return $db->fetchAllColumn($db->limit(
            "
            SELECT tag_id
            FROM xf_tag
            WHERE tag_id > ? and (tagess_wiki_description = '' 
              or tagess_wiki_description is null 
              or tagess_wiki_description = ?
              or tagess_wiki_description = ?
              or tagess_wiki_description = ?
            )              
            ORDER BY tag_id
			", $batch
        ), [$start, 'avForumsTagEss_no_wikipedia_entry_exists', 'tagess_no_wikipedia_entry_exists', $phrase]);
    }

    protected function rebuildById($id)
    {
        /** @var \AVForums\TagEssentials\XF\Entity\Tag $tag */
        $tag = \XF::app()->find('XF:Tag', $id);
        if ($tag)
        {
            $tag->tagess_wiki_description = '';
            $tag->saveIfChanged();
        }
    }

    protected function getStatusType()
    {
        return \XF::phrase('tags');
    }
}