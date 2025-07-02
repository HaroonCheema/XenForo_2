<?php

namespace FS\CheckAttachment\Service;

class ValidateAttachments extends \XF\Service\AbstractService
{

    public function checkAttachments($message, $attachment_hash)
    {
        // $pattern = '/\b(?:https?:\/\/|www\.)[^\s<>"\']+|\[(?:ATTACH|IMG|MEDIA|URL|GALLERY)/';

        $pattern = "/ATTACH|IMG|GALLERY|MEDIA/";

        $exist = preg_match_all($pattern, $message, $match);

        $attachmentFinder = \xf::app()->finder('XF:Attachment')
            ->where('temp_hash', $attachment_hash)->fetchOne();

        return [
            'exist' => $exist,
            'attachmentFinder' => $attachmentFinder
        ];
    }
}
