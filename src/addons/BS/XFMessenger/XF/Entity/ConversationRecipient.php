<?php

namespace BS\XFMessenger\XF\Entity;

use BS\RealTimeChat\Entity\Concerns\UpdateLockable;
use BS\XFMessenger\Job\ConversationRecipient\TouchLastRead;
use XF\Mvc\Entity\Structure;

/**
 * @property int xfm_last_read_date
 */
class ConversationRecipient extends XFCP_ConversationRecipient
{
    use UpdateLockable;

    public function touchLastRead(
        ?int $unixTime = null,
        ?int $microTime = null
    ): void {
        if ($this->isDeleted()) {
            return;
        }

        TouchLastRead::create(
            $this->conversation_id,
            $this->user_id,
            $unixTime,
            $microTime
        );
    }

    protected function _postSave()
    {
        $participationChange = $this->isStateChanged('recipient_state', 'active');
        if (! $participationChange) {
            parent::_postSave();
            return;
        }

        if ($participationChange === 'enter') {
            /** @var \XF\Entity\ConversationUser $conversationUser */
            $conversationUser = $this->getRelationOrDefault('ConversationUser', false);

            $conversationUser->xfm_last_message_date = $this->Conversation->LastMessage->xfm_message_date;
        }

        parent::_postSave();
    }

    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['xfm_last_read_date'] = [
            'type'    => self::UINT,
            'default' => 0,
            'max'     => (2 ** 63) - 2
        ];

        return $structure;
    }
}
