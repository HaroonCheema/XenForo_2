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
        $atleast_one_attachment = $options->fs_ca_atleast_attachment_forum;

        $attachmentsService = \xf::app()->service('FS\CheckAttachment:ValidateAttachments');
        $message = $this->plugin('XF:Editor')->fromInput('message');

        if (in_array($thread->node_id, $applicable_forum) || in_array($thread->node_id, $only_text_forum)) {

            $responce = $attachmentsService->checkAttachments($message, $this->filter('attachment_hash', 'str'));

            if ($responce['exist'] || $responce['attachmentFinder'] != NULL) {
                throw $this->exception($this->error(\XF::phrase('fs_attachment_not_allowed')));
            }
        } elseif (in_array($thread->node_id, $atleast_one_attachment)) {

            $responce = $attachmentsService->checkAttachments($message, $this->filter('attachment_hash', 'str'));

            if (!$responce['exist'] && $responce['attachmentFinder'] == NULL) {
                throw $this->exception($this->error(\XF::phrase('fs_attachment_required')));
                // throw $this->exception($this->error(\XF::phrase('fs_atleast_one_attachment_required')));
            }
        }

        return parent::setupThreadReply($thread);
    }
}
