<?php

namespace NF\GiftUpgrades\XF\Service\User;



/**
 * Extends \XF\Service\User\Merge
 */
class Merge extends XFCP_Merge
{
    /**
     * @throws \XF\Db\Exception
     */
    protected function stepFinalizeMerge()
    {
        $db = $this->db();
        $target = $this->target;
        $source = $this->source;

        $db->query(
            'UPDATE IGNORE xf_nf_gifted_content
                    SET gift_user_id = ?
                    WHERE gift_user_id = ?',
            [$target->user_id, $source->user_id]
        );
        $db->query(
            'UPDATE IGNORE xf_nf_gifted_content
                    SET content_user_id = ?
                    WHERE content_user_id = ?',
            [$target->user_id, $source->user_id]
        );

        parent::stepFinalizeMerge();
    }
}