<?php

namespace FS\CheckAttachment\Service;

class ValidateAttachments extends \XF\Service\AbstractService
{

    public function checkAttachments($message, $attachment_hash)
    {
        // $pattern = '/\b(?:https?:\/\/|www\.)[^\s<>"\']+|\[(?:ATTACH|IMG|MEDIA|URL|GALLERY)/';

        $message = preg_replace('#\[QUOTE\](.*?)\[/QUOTE\]#is', '', $message);

        $message = preg_replace('/\n{2,}/', "\n\n", trim($message));

        $pattern = "/ATTACH|IMG|GALLERY|MEDIA/";

        $exist = preg_match_all($pattern, $message, $match);

        if (!$exist)
            $exist = $this->messageContainsMediaUrl($message) ? 1 : 0;

        $attachmentFinder = \xf::app()->finder('XF:Attachment')
            ->where('temp_hash', $attachment_hash)->fetchOne();

        return [
            'exist' => $exist,
            'attachmentFinder' => $attachmentFinder
        ];
    }

    // public function checkAttachmentsTest($message, $attachment_hash)
    // {
    //     // $pattern = '/\b(?:https?:\/\/|www\.)[^\s<>"\']+|\[(?:ATTACH|IMG|MEDIA|URL|GALLERY)/';

    //     $message = preg_replace('#\[QUOTE\](.*?)\[/QUOTE\]#is', '', $message);

    //     $message = preg_replace('/\n{2,}/', "\n\n", trim($message));

    //     $pattern = "/ATTACH|IMG|GALLERY|MEDIA/";

    //     $exist = preg_match_all($pattern, $message, $match);

    //     $attachmentFinder = \xf::app()->finder('XF:Attachment')
    //         ->where('temp_hash', $attachment_hash)->fetchOne();

    //     return [
    //         'exist' => $exist,
    //         'attachmentFinder' => $attachmentFinder
    //     ];
    // }


    public function messageContainsMediaUrl(string $message)
    {
        $mediaRepo = \XF::repository('XF:BbCodeMediaSite');
        $sites = $mediaRepo->findActiveMediaSites()->fetch();

        preg_match_all('#https?://[^\s\'"<>\]]+#i', $message, $matches);

        foreach ($matches[0] as $url) {
            $url = trim($url);
            $match = $mediaRepo->urlMatchesMediaSiteList($url, $sites);
            if ($match) {
                return true; 
            }
        }

        return false; 
    }
}
