<?php

namespace NF\GiftUpgrades\XF\Service\Post;



/**
 * Extends \XF\Service\Post\Merger
 */
class Merger extends XFCP_Merger
{
    /**
     * @throws \XF\Db\Exception
     */
    protected function moveDataToTarget()
    {
        $db = $this->db();
        $target = $this->target;

        $sourcePosts = $this->sourcePosts;
        $sourcePostIds = array_keys($sourcePosts);
        $sourceIdsQuoted = $db->quote($sourcePostIds);


        $db->query(
            "DELETE FROM xf_nf_gifted_content
                    WHERE content_type = 'post' AND 
                          content_id IN ({$sourceIdsQuoted}) AND
                          gift_user_id = ?",
            $target->user_id
        );
        $db->query(
            "UPDATE IGNORE xf_nf_gifted_content
                    SET content_id = ?
                    WHERE content_type = 'post' AND 
                          content_id IN ({$sourceIdsQuoted})",
            $target->post_id
        );
        $db->query(
            "DELETE FROM xf_nf_gifted_content
                    WHERE content_type = 'post' AND 
                          content_id IN ({$sourceIdsQuoted})"
        );

        parent::moveDataToTarget();
    }
}