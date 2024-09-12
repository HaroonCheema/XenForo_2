<?php

namespace FS\LayeredPostersChanges\XF\Service\Post;

use XF\Entity\Post;

class Preparer extends XFCP_Preparer
{
    public function setMessage($message, $format = true, $checkValidity = true)
    {
        $request = \XF::app()->request();

        $attachemntHash = $request->filter('attachment_hash', 'str');

        /** @var \XF\Repository\Attachment $attachmentRepo */
        $attachmentRepo = $this->repository('XF:Attachment');
        $attachmentData = $attachmentRepo->getEditorData('post', $this->post->Thread->Forum, $attachemntHash);

        if (!count($attachmentData["attachments"])) {
            return parent::setMessage($message, $format = true, $checkValidity = true);
        }

        $preparer = $this->getMessagePreparer($format);

        $preparer->setConstraint('allowEmpty', true);

        $this->post->message = $preparer->prepare($message, $checkValidity);
        $this->post->embed_metadata = $preparer->getEmbedMetadata();

        $this->quotedPosts = $preparer->getQuotesKeyed('post');

        $this->mentionedUsers = $preparer->getMentionedUsers();

        return $preparer->pushEntityErrorIfInvalid($this->post);
    }
}
