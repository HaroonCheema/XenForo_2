<?php

namespace FS\CheckAttachment\XF\Pub\Controller;

class Thread extends XFCP_Thread
{

    /**
     * @param \XF\Entity\Thread $thread
     *
     * @return \XF\Service\Thread\Replier
     */
    protected function setupThreadReply(\XF\Entity\Thread $thread)
    {
        $options = \XF::options();
        $applicable_forum = $options->ca_applicable_forum;
        $only_text_forum = $options->fs_ca_exclude_forum;

        if (in_array($thread->node_id, $applicable_forum) || in_array($thread->node_id, $only_text_forum)) {
            $message = $this->plugin('XF:Editor')->fromInput('message');

            $attachmentsService = \xf::app()->service('FS\CheckAttachment:ValidateAttachments');
            $responce = $attachmentsService->checkAttachments($message, $this->filter('attachment_hash', 'str'));

            if ($responce['exist'] || $responce['attachmentFinder'] != NULL) {
                throw $this->exception($this->error(\XF::phrase('fs_attachment_not_allowed')));
            }
        }

        return parent::setupThreadReply($thread);
    }
}
