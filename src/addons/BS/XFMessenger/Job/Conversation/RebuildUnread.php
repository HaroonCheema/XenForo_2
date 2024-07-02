<?php

namespace BS\XFMessenger\Job\Conversation;

use XF\Entity\ConversationMaster;
use XF\Entity\ConversationUser;
use XF\Job\AbstractRebuildJob;

class RebuildUnread extends AbstractRebuildJob
{
    public static function enqueue(): void
    {
        \XF::app()->jobManager()->enqueue('BS\XFMessenger:Conversation\RebuildUnread');
    }

    protected function getNextIds($start, $batch)
    {
        $db = $this->app->db();

        return $db->fetchAllColumn(
            $db->limit(
                "
                SELECT conversation_id
                FROM xf_conversation_master
                WHERE conversation_id > ?
                ORDER BY conversation_id
            ", $batch),
            $start
        );
    }

    protected function rebuildById($id)
    {
        /** @var \BS\XFMessenger\XF\Entity\ConversationMaster|null $cv */
        $cv = $this->app->em()->find('XF:ConversationMaster', $id);
        if (!$cv) {
            return;
        }

        foreach ($cv->Users as $user) {
            $lastReadDate = $user->Recipient->last_read_date;

            if ($this->isManuallyUnread($user)) {
                continue;
            }

            $lastMsg = $cv->LastMessage;
            try {
                if ($lastMsg
                    && $lastMsg->user_id === $user->owner_user_id
                    && $lastMsg->xfm_message_date > $user->Recipient->xfm_last_read_date
                ) {
                    // For some reason, recipient's last read date is not updated when the last message is sent by the owner
                    // of the conversation. We need to update it manually.
                    $user->Recipient->last_read_date = $lastReadDate = $lastMsg->message_date;
                    $user->Recipient->xfm_last_read_date = $lastMsg->xfm_message_date;
                    $user->Recipient->save();
                }

                $user->is_unread = $this->hasMessagesAfterDate($cv->conversation_id, $lastReadDate);
                $user->save();
            } catch (\Throwable $e) {
                \XF::logException(
                    $e,
                    false,
                    'Error rebuilding unread status for conversation '.$cv->conversation_id.' and user '.$user->user_id
                );
            }
        }
    }

    protected function isManuallyUnread(ConversationUser $user): bool
    {
        /** @var \XF\Entity\ConversationMessage $lastNotVisitorMessage */
        $lastNotVisitorMessage = $this->app->finder('XF:ConversationMessage')
            ->where('conversation_id', $user->conversation_id)
            ->where('user_id', '!=', $user->owner_user_id)
            ->order('message_date', 'DESC')
            ->fetchOne();
        return $lastNotVisitorMessage
            && $lastNotVisitorMessage->xfm_message_date - $user->Recipient->xfm_last_read_date === 1;
    }

    protected function hasMessagesAfterDate(int $conversationId, int $time): bool
    {
        return $this->app->finder('XF:ConversationMessage')
            ->where('conversation_id', $conversationId)
            ->where('message_date', '>', $time)
            ->total() > 0;
    }

    protected function getStatusType()
    {
        return \XF::phrase('conversations');
    }
}
