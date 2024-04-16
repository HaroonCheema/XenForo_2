<?php

namespace FS\ApproveRejectedUser\XF\Repository;

class ApprovalQueue extends XFCP_ApprovalQueue
{

    public function findUnapprovedContent()
    {
        $visitor = \XF::visitor();

        $modIds = \XF::options()->fs_rejected_user_mod_ids;


        $array = explode(',', $modIds);

        // Check if $visitor exists in the array
        if (in_array($visitor->user_id, $array)) {
            return parent::findUnapprovedContent();
        }

        return $this->finder('XF:ApprovalQueue')
            ->setDefaultOrder('content_date')->where('content_type', '!=', 'fs_rejected_user');
    }

    public function getContentTypesFromCurrentQueue()
    {
        $visitor = \XF::visitor();

        $modIds = \XF::options()->fs_rejected_user_mod_ids;


        $array = explode(',', $modIds);

        // Check if $visitor exists in the array
        if (in_array($visitor->user_id, $array)) {
            return parent::getContentTypesFromCurrentQueue();
        }

        return $this->db()->fetchAllColumn("
        SELECT DISTINCT content_type
        FROM xf_approval_queue
        WHERE content_type != 'fs_rejected_user'
        ORDER BY CONVERT(content_type USING {$this->db()->getUtf8Type()})
        ");
    }
}
