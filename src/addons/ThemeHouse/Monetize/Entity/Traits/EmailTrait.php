<?php

namespace ThemeHouse\Monetize\Entity\Traits;

use ThemeHouse\Monetize\Finder\CommunicationLog;
use XF\Entity\User;
use XF\Mvc\Entity\ArrayCollection;


trait EmailTrait
{
    /**
     * @param User $user
     * @param ArrayCollection $userUpgrades
     */
    public function sendEmail(User $user, ArrayCollection $userUpgrades)
    {
        if (!$this->active || !$user->email) {
            return;
        }

        if (!$this->canUserReceiveEmail($user, $userUpgrades)) {
            return;
        }

        $language = \XF::app()->language($user->language_id);
        $options = \XF::app()->options();

        $body = $this->replacePhrases($this->body, $language);
        $title = $this->replacePhrases($this->title, $language);

        if (isset($this->type_options['unsub']) && $this->type_options['unsub']) {
            $body .= "\n\n<div class=\"minorText\" align=\"center\"><a href=\"{unsub}\">"
                . $language->renderPhrase('unsubscribe_from_mailing_list')
                . '</a></div>';
        }

        $tokens = $this->prepareEmailTokens($user, true);
        $html = strtr($body, $tokens);
        $text = \XF::app()->mailer()->generateTextBody($html);

        $titleTokens = $this->prepareEmailTokens($user, false);
        $title = strtr($title, $titleTokens);

        $mail = $this->getMail($user)->setFrom($options['defaultEmailAddress'], $options['emailSenderName'] ?: $options['boardTitle']);
        $mail->setTemplate('prepared_email', [
            'title' => $title,
            'htmlBody' => $html,
            'textBody' => $text,
            'raw' => isset($this->type_options['wrapped']) && $this->type_options['wrapped'] ? false : true
        ]);
        $mail->send();

        $this->logCommunication($user->user_id);
    }

    /**
     * @param User $user
     * @param ArrayCollection $userUpgrades
     * @return bool
     */
    public function canUserReceiveEmail(User $user, ArrayCollection $userUpgrades)
    {
        if (isset($this->type_options['receive_admin_email_only']) && $this->type_options['receive_admin_email_only'] && (!$user->Option || !$user->Option->receive_admin_email)) {
            return false;
        }

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

        $totalPerUser = \XF::options()->thmonetize_maxTotalEmailsPerUser;
        $perUser = \XF::options()->thmonetize_maxEmailsPerUser;

        $maxEmails = max($totalPerUser['emails'], $perUser['emails'], $this->limit);
        $maxDays = max($totalPerUser['days'], $perUser['days'], $this->limit_days);

        $cutOff = $maxDays ? \XF::$time - 86400 * $maxDays : 0;

        if (!$cutOff || !$maxEmails) {
            return true;
        }

        /** @var CommunicationLog $logFinder */
        $logFinder = $this->finder('ThemeHouse\Monetize:CommunicationLog');
        $totalEmails = $logFinder->where('user_id', $user->user_id)
            ->where('log_date', '>=', $cutOff)
            ->where('Communication.type', 'email')
            ->with(['Communication'])
            ->order($logFinder->expression('FIELD(xf_th_monetize_communication_log.communication_id, ' . $this->communication_id . ')'), 'desc')
            ->limit($maxEmails)
            ->fetch();

        if ($this->isLimitReached($totalEmails, $totalPerUser['emails'], $totalPerUser['days'])) {
            return false;
        }

        $emailId = $this->communication_id;
        $emails = $totalEmails->filter(
            function (\ThemeHouse\Monetize\Entity\CommunicationLog $log) use ($emailId) {
                return $log->communication_id === $emailId;
            }
        );

        if ($this->isLimitReached($emails, $perUser['emails'], $perUser['days'])) {
            return false;
        }

        if ($this->isLimitReached($emails, $this->limit, $this->limit_days)) {
            return false;
        }

        return true;
    }

    /**
     * @param User $user
     * @param $escape
     * @return array
     */
    protected function prepareEmailTokens(User $user, $escape)
    {
        $unsubLink = \XF::app()->router('public')->buildLink('canonical:email-stop/mailing-list', $user);

        $tokens = [
            '{name}' => $user->username,
            '{email}' => $user->email,
            '{id}' => $user->user_id,
            '{unsub}' => $unsubLink
        ];

        if ($escape) {
            array_walk($tokens, function (&$value) {
                if (is_string($value)) {
                    $value = htmlspecialchars($value);
                }
            });
        }

        return $tokens;
    }

    /**
     * @param User $user
     *
     * @return \XF\Mail\Mail
     */
    protected function getMail(User $user)
    {
        $mailer = \XF::app()->mailer();
        $mail = $mailer->newMail();

        $options = \XF::app()->options();
        $unsubEmail = $options->unsubscribeEmailAddress;
        $useVerp = $options->enableVerp;

        $mail->setToUser($user);

        return $mail->setListUnsubscribe($unsubEmail, $useVerp);
    }
}
