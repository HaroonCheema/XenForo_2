<?php

namespace BS\AIBots\Service\Concerns;

trait ProfilePostComment
{
    /**
     * @param  \XF\Entity\ProfilePost  $profilePost
     * @param  string  $content
     * @param  string|null  $attachmentHash
     * @return \XF\Service\ProfilePostComment\Creator
     */
    protected function setupProfilePostComment(
        \XF\Entity\ProfilePost $profilePost,
        string $content,
        ?string $attachmentHash = null
    ) {
        /** @var \XF\Service\ProfilePostComment\Creator $creator */
        $creator = $this->service('XF:ProfilePostComment\Creator', $profilePost);
        $creator->setContent($content);

        if ($attachmentHash) {
            $creator->setAttachmentHash($attachmentHash);
        }

        return $creator;
    }

    protected function finalizeProfilePostComment(\XF\Service\ProfilePostComment\Creator $creator)
    {
        $creator->sendNotifications();
    }
}