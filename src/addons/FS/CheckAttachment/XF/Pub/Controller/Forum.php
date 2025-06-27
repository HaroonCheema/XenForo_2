<?php

namespace FS\CheckAttachment\XF\Pub\Controller;

class Forum extends XFCP_Forum
{

    /**
     * @param \XF\Entity\Forum $forum
     *
     * @return \XF\Service\Thread\Creator
     */
    protected function setupThreadCreate(\XF\Entity\Forum $forum)
    {
        $options = \XF::options();
        $applicable_forum = $options->ca_applicable_forum;
        $only_text_forum = $options->fs_ca_exclude_forum;

        if (in_array($forum->node_id, $applicable_forum) || in_array($forum->node_id, $only_text_forum)) {
            $message = $this->plugin('XF:Editor')->fromInput('message');

            $attachmentsService = \xf::app()->service('FS\CheckAttachment:ValidateAttachments');
            $responce = $attachmentsService->checkAttachments($message, $this->filter('attachment_hash', 'str'));

            if (in_array($forum->node_id, $only_text_forum)) {
                if ($responce['exist'] || $responce['attachmentFinder'] != NULL) {
                    throw $this->exception($this->error(\XF::phrase('fs_attachment_not_allowed')));
                }
            } else {
                if (!$responce['exist'] && $responce['attachmentFinder'] == NULL) {
                    throw $this->exception($this->error(\XF::phrase('fs_attachment_required')));
                }
            }
        }

        return parent::setupThreadCreate($forum);
    }
}
