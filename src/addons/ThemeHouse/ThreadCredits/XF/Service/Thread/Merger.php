<?php

namespace ThemeHouse\ThreadCredits\XF\Service\Thread;

class Merger extends XFCP_Merger
{
    public function merge($sourceThreadsRaw)
    {
        $response = parent::merge($sourceThreadsRaw);

        if ($response) {
            $sourceThreads = $this->sourceThreads;
            $targetThread = $this->target;

            foreach ($sourceThreads as $sourceThread) {
                /** @var \XF\Entity\Thread $sourceThread */
                \XF::db()->update('xf_thtc_thread_payment', ['thread_id' => $targetThread->thread_id], 'thread_id = ?', [$sourceThread->thread_id]);
            }
        }

        return $response;
    }
}
