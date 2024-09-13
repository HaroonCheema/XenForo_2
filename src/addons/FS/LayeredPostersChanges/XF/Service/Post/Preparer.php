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
            throw new \XF\PrintableException(\XF::phrase('fs_please_upload_at_least_one_attachment'));
        }

        return parent::setMessage($message, $format = true, $checkValidity = true);
    }
}
