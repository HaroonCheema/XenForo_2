<?php

namespace FS\CompleteProduction\XF\Entity;

use DateTime;
use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['is_product_completed'] =  ['type' => self::UINT, 'default' => 0];
        $structure->columns['is_transfer_received'] =  ['type' => self::UINT, 'default' => 0];

        return $structure;
    }

    public function canCompleteProduction()
    {
        $visitor = \XF::visitor();
        $options = \XF::options();
        $thread = $this;
        $message = $thread->FirstPost['message'] ?? '';
        $completionDate = false;

        $pattern = '/\[TD\]COMPLETION DATE\[\/TD\]\s*\[TD\](.*?)\[\/TD\]/i';

        if (preg_match($pattern, $message, $matches)) {
            $completionDateStr = $matches[1];
            $completionDate = DateTime::createFromFormat('d/m/Y', $completionDateStr);
        }

        // $createdDate = date('Y-m-d', $thread->post_date);
        // $todayDate   = date('Y-m-d');
        $today = new DateTime();

        if (
            $visitor->user_id == $thread->user_id
            && in_array($thread->node_id, $options->fs_production_btn_forums)
            && $completionDate
            && $completionDate <= $today
            && $thread->is_product_completed == 0
        ) {
            return true;
        }

        return false;
    }

    public function canReceiveMoney()
    {
        $options = \XF::options();
        $thread = $this;

        if (
            in_array($thread->node_id, $options->fs_production_btn_forums)
            && preg_match('/\btransfer\b/i', $thread->title)
            && $thread->is_transfer_received == 0

        ) {
            return true;
        }

        return false;
    }
}
