<?php

namespace ThemeHouse\Monetize\Entity\Traits;

use ThemeHouse\Monetize\Finder\CommunicationLog;
use XF\Entity\User;
use XF\Mvc\Entity\ArrayCollection;


trait MessageTrait
{
    /**
     * @param User $user
     * @param ArrayCollection $userUpgrades
     * @throws \XF\PrintableException
     */
    public function sendMessage(User $user, ArrayCollection $userUpgrades)
    {
        if (!$this->active) {
            return;
        }

        if (!$this->canUserReceiveMessage($user, $userUpgrades)) {
            return;
        }

        $language = \XF::app()->language($user->language_id);
        $title = $this->replacePhrases($this->title, $language);
        $body = $this->replacePhrases($this->body, $language);

        $tokens = $this->prepareMessageTokens($user);
        $title = strtr($title, $tokens);
        $body = strtr($body, $tokens);

        /** @var \XF\Service\Conversation\Creator $creator */
        $creator = \XF::app()->service('XF:Conversation\Creator', $this->User);
        $creator->setIsAutomated();
        $creator->setOptions([
            'open_invite' => isset($this->type_options['open_invite']) && $this->type_options['open_invite'],
            'conversation_open' => !isset($this->type_options['conversation_locked']) || !$this->type_options['conversation_locked'],
        ]);
        $creator->setRecipientsTrusted($user);
        $creator->setContent($title, $body);
        if (!$creator->validate()) {
            return;
        }

        $conversation = $creator->save();

        if (isset($this->type_options['delete_type']) && $this->type_options['delete_type']) {
            /** @var \XF\Entity\ConversationRecipient $recipient */
            $recipient = $conversation->Recipients[$this->User->user_id];
            $recipient->recipient_state = $this->type_options['delete_type'];
            $recipient->save(false);
        }

        $this->logCommunication($user->user_id);
    }

    /**
     * @param User $user
     * @param ArrayCollection $userUpgrades
     * @return bool
     */
    public function canUserReceiveMessage(User $user, ArrayCollection $userUpgrades)
    {
        if (!\XF::app()->criteria('XF:User', $this->user_criteria)->isMatched($user)) {
            return false;
        }

        $userUpgradeCriteria = \XF::app()->criteria(
            'ThemeHouse\Monetize:UserUpgrade',
            $this->user_upgrade_criteria,
            $userUpgrades
        );
        if (!$userUpgradeCriteria->isMatched($user)) {
            return false;
        }

        $totalPerUser = \XF::options()->thmonetize_maxTotalMessagesPerUser;
        $perUser = \XF::options()->thmonetize_maxMessagesPerUser;

        $maxMessages = max($totalPerUser['messages'], $perUser['messages'], $this->limit);
        $maxDays = max($totalPerUser['days'], $perUser['days'], $this->limit_days);

        $cutOff = $maxDays ? \XF::$time - 86400 * $maxDays : 0;

        if (!$cutOff || !$maxMessages) {
            return true;
        }

        /** @var CommunicationLog $logFinder */
        $logFinder = $this->finder('ThemeHouse\Monetize:CommunicationLog');
        $totalMessages = $logFinder->where('user_id', $user->user_id)
            ->where('log_date', '>=', $cutOff)
            ->where('Communication.type', 'message')
            ->with(['Communication'])
            ->order($logFinder->expression('FIELD(xf_th_monetize_communication_log.communication_id, ' . $this->communication_id . ')'), 'desc')
            ->limit($maxMessages)
            ->fetch();

        if ($this->isLimitReached($totalMessages, $totalPerUser['messages'], $totalPerUser['days'])) {
            return false;
        }

        $messageId = $this->communication_id;
        $messages = $totalMessages->filter(
            function (\ThemeHouse\Monetize\Entity\CommunicationLog $log) use ($messageId) {
                return $log->communication_id === $messageId;
            }
        );

        if ($this->isLimitReached($messages, $perUser['messages'], $perUser['days'])) {
            return false;
        }

        if ($this->isLimitReached($messages, $this->limit, $this->limit_days)) {
            return false;
        }

        return true;
    }

    /**
     * @param User $user
     * @return array
     */
    protected function prepareMessageTokens(User $user)
    {
        return [
            '{name}' => $user->username,
            '{email}' => $user->email,
            '{id}' => $user->user_id
        ];
    }
}
