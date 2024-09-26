<?php

namespace AVForums\TagEssentials\XF\Finder;

use SV\StandardLib\Finder\SqlJoinTrait;

/**
 * Extends \XF\Finder\Thread
 */
class Thread extends XFCP_Thread
{
    use SqlJoinTrait;

    /**
     * @param $tagName
     *
     * @return $this
     */
    public function hasTag($tagName)
    {
        if (!is_array($tagName)) {
            $tags = explode(',', $tagName);
        } else {
            $tags = $tagName;
        }

        $this->sqlJoin('(
                SELECT tag_content.content_id AS thread_id
                FROM xf_tag_content AS tag_content
                INNER JOIN xf_tag AS tag
                    ON (tag.tag_id = tag_content.tag_id)
                WHERE content_type = \'thread\' AND tag.tag IN (' . $this->quote($tags) . ')
                GROUP BY content_id
                HAVING count(*) >= ' . $this->quote(count($tags)) . '
            )', 'taggedThread', ['thread_id'], true, true);

        $this->sqlJoinConditions('taggedThread', ['thread_id']);

        return $this;
    }

    /**
     * @param $tagName
     *
     * @return $this
     */
    public function hasNotTag($tagName)
    {
        if (!is_array($tagName)) {
            $tags = explode(',', $tagName);
        } else {
            $tags = $tagName;
        }

        $this->sqlJoin('(
                SELECT tag_content.content_id AS thread_id
                FROM xf_tag_content AS tag_content
                INNER JOIN xf_tag AS tag
                    ON (tag.tag_id = tag_content.tag_id)
                WHERE content_type = \'thread\' AND tag.tag IN (' . $this->quote($tags) . ')
                GROUP BY content_id
                HAVING count(*) >= ' . $this->quote(count($tags)) . '
            )', 'taggedThread', ['thread_id'], true, true);

        $this->sqlJoinConditions('taggedThread', ['thread_id']);

        return $this;
    }
    // public function hasNotTag($tagName)
    // {
    //     if (!is_array($tagName)) {
    //         $tags = explode(',', $tagName);
    //     } else {
    //         $tags = $tagName;
    //     }

    //     $this->sqlJoin('(
    //             SELECT tag_content.content_id AS thread_id
    //             FROM xf_tag_content AS tag_content
    //             INNER JOIN xf_tag AS tag
    //                 ON (tag.tag_id = tag_content.tag_id)
    //             WHERE tag.tag NOT IN (' . $this->quote($tags) . ')
    //             GROUP BY content_id
    //             HAVING count(*) >= ' . $this->quote(count($tags)) . '
    //         )', 'taggedThread', ['thread_id'], true, true);

    //     $this->sqlJoinConditions('taggedThread', ['thread_id']);

    //     return $this;
    // }
}
