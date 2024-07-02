<?php

namespace BS\XFMessenger\Job\ConversationRecipient;

use BS\RealTimeChat\DB;
use BS\RealTimeChat\Utils\Date;
use XF\Job\AbstractJob;

class TouchLastRead extends AbstractJob
{
    public static function create(
        int $conversationId,
        int $userId,
        ?int $date,
        ?int $microTime
    ) {
        $date ??= \XF::$time;
        $microTime ??= Date::getMicroTimestamp();

        \XF::app()->jobManager()->enqueueUnique(
            'xfm_touch_last_read:'.$conversationId.':'.$userId,
            'BS\XFMessenger:ConversationRecipient\TouchLastRead',
            [
                'conversation_id' => $conversationId,
                'user_id'         => $userId,
                'date'            => $date,
                'micro_time'      => $microTime
            ]
        );
    }

    public function run($maxRunTime)
    {
        $conversationId = $this->data['conversation_id'];
        $userId = $this->data['user_id'];
        $date = $this->data['date'];
        $microTime = $this->data['micro_time'] ?? 0;

        /** @var \BS\XFMessenger\XF\Entity\ConversationRecipient $recipient */
        $recipient = $this->app->em()->find('XF:ConversationRecipient', [
            'conversation_id' => $conversationId,
            'user_id'         => $userId
        ]);

        if (! $recipient) {
            return $this->complete();
        }

        $completed = false;

        DB::repeatOnDeadlock(static function () use ($recipient, $date, $microTime, &$completed) {
            $recipient->lockForUpdate();

            // If the new read date is the same as the old one
            // it will not trigger in \BS\XFMessenger\Listener::entityPostSaveConversationRecipient
            // so we need to increment it by 1 to add last_read_date to _newValues property in Entity
            if ($recipient->last_read_date === $date) {
                $recipient->set('last_read_date', $date + 1, ['forceSet' => true]);
            }

            $recipient->set('last_read_date', $date, ['forceSet' => true]);

            if ($microTime) {
                $recipient->xfm_last_read_date = $microTime;
            }

            $recipient->save();

            $completed = true;
        });

        if (! $completed) {
            return $this->resume();
        }

        return $this->complete();
    }

    public function getStatusMessage()
    {
        return 'Touching last read';
    }

    public function canTriggerByChoice()
    {
        return false;
    }

    public function canCancel()
    {
        return false;
    }
}
