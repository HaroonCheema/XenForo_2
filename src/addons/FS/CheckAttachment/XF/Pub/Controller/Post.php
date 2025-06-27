<?php

namespace FS\CheckAttachment\XF\Pub\Controller;

class Post extends XFCP_Post
{

    /**
     * @param \XF\Entity\Post $post
     *
     * @return \XF\Service\Post\Editor
     */
    protected function setupPostEdit(\XF\Entity\Post $post)
    {

        $options = \XF::options();
        $applicable_forum = $options->ca_applicable_forum;
        $only_text_forum = $options->fs_ca_exclude_forum;
        $forum = $post->Thread->Forum;

        $message = $this->plugin('XF:Editor')->fromInput('message');

        $attachmentsService = \xf::app()->service('FS\CheckAttachment:ValidateAttachments');

        if (in_array($forum->node_id, $only_text_forum)) {
            $responce = $attachmentsService->checkAttachments($message, $this->filter('attachment_hash', 'str'));

            if ($responce['exist'] || $responce['attachmentFinder'] != NULL || count($post['Attachments'])) {
                throw $this->exception($this->error(\XF::phrase('fs_attachment_not_allowed')));
            }
        } elseif (in_array($forum->node_id, $applicable_forum)) {

            $responce = $attachmentsService->checkAttachments($message, $this->filter('attachment_hash', 'str'));

            if ($post->isFirstPost()) {
                if (!$responce['exist'] && $responce['attachmentFinder'] == NULL && !count($post['Attachments'])) {
                    throw $this->exception($this->error(\XF::phrase('fs_attachment_required')));
                }
            } else {
                if ($responce['exist'] || $responce['attachmentFinder'] != NULL || count($post['Attachments'])) {
                    throw $this->exception($this->error(\XF::phrase('fs_attachment_not_allowed')));
                }
            }
        }

        return parent::setupPostEdit($post);
    }
}
