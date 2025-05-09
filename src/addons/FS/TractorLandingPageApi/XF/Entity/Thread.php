<?php

namespace FS\TractorLandingPageApi\XF\Entity;

class Thread extends XFCP_Thread
{

    protected function setupApiResultData(\XF\Api\Result\EntityResult $result, $verbosity = self::VERBOSITY_NORMAL, array $options = [])
    {

        $parent = parent::setupApiResultData($result, $verbosity, $options);

        $attachmentUrl = count($this->FirstPost->Attachments) ? (\XF::app()->request()->getHostUrl() . $this->FirstPost->Attachments->first()->Data->getThumbnailUrl()) : "";
        $result->message = \XF::app()->stringFormatter()->snippetString($this->FirstPost->message, 80, ['stripBbCode' => true]);
        $result->attachment_url = $attachmentUrl;

        return $parent;
    }
}
