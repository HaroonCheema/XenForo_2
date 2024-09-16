<?php

namespace AVForums\TagEssentials\XF\Service\Tag;



use XF\Entity\Tag;

/**
 * Extends \XF\Service\Tag\Merger
 */
class Merger extends XFCP_Merger
{
    public function merge(Tag $source)
    {
        $db = $this->db();

        $targetTagId = $this->target->tag_id;
        $sourceTagId = $source->tag_id;

        if ($targetTagId == $sourceTagId)
        {
            throw new \InvalidArgumentException("May not merge a tag with itself");
        }

        $db->beginTransaction();

        $db->query("
			UPDATE IGNORE xf_tagess_tag_watch
			SET tag_id = ?
			WHERE tag_id = ?
		", [$targetTagId, $sourceTagId]);

        // this handles cases where the content already had the target tag
        $db->query("DELETE FROM xf_tagess_tag_watch WHERE tag_id = ?", $sourceTagId);

        parent::merge($source);

        $db->commit();
    }
}