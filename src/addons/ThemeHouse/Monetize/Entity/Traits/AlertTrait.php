<?php

namespace ThemeHouse\Monetize\Entity\Traits;

use ThemeHouse\Monetize\Finder\CommunicationLog;
use XF\Entity\User;
use XF\Mvc\Entity\ArrayCollection;

trait AlertTrait
{
    /**
     * @param User $user
     * @param ArrayCollection $userUpgrades
     */
    public function sendAlert(User $user, ArrayCollection $userUpgrades)
    {
        if (!$this->active) {
            return;
        }

        if (!$this->canUserReceiveAlert($user, $userUpgrades)) {
            return;
        }

        $replacements = [];
        $body = $this->prepareAlert($replacements);

        $language = \XF::app()->language($user->language_id);
        $body = $this->replacePhrases($body, $language);

        $replacements = array_merge($replacements, [
            '{name}' => htmlspecialchars($user->username),
            '{id}' => $user->user_id
        ]);
        $alert = [
            'alert_text' => strtr($body, $replacements),
        ];

        /** @var \XF\Repository\UserAlert $alertRepo */
        $alertRepo = $this->repository('XF:UserAlert');
        $alertRepo->alert(
            $user,
            $this->User ? $this->User->user_id : 0,
            $this->User ? $this->User->username : '',
            'user',
            $user->user_id,
            'thmonetize_alert',
            $alert
        );

        $this->logCommunication($user->user_id);
    }

    /**
     * @param User $user
     * @param ArrayCollection $userUpgrades
     * @return bool
     */
    public function canUserReceiveAlert(User $user, ArrayCollection $userUpgrades)
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

        $totalPerUser = \XF::options()->thmonetize_maxTotalAlertsPerUser;
        $perUser = \XF::options()->thmonetize_maxAlertsPerUser;

        $maxAlerts = max($totalPerUser['alerts'], $perUser['alerts'], $this->limit);
        $maxDays = max($totalPerUser['days'], $perUser['days'], $this->limit_days);

        $cutOff = $maxDays ? \XF::$time - 86400 * $maxDays : 0;

        if (!$cutOff || !$maxAlerts) {
            return true;
        }

        /** @var CommunicationLog $logFinder */
        $logFinder = $this->finder('ThemeHouse\Monetize:CommunicationLog');
        $totalAlerts = $logFinder->where('user_id', $user->user_id)
            ->where('log_date', '>=', $cutOff)
            ->where('Communication.type', 'alert')
            ->with('Communication', true)
            ->order($logFinder->expression('FIELD(xf_th_monetize_communication_log.communication_id, ' . $this->communication_id . ')'), 'desc')
            ->limit($maxAlerts)
            ->fetch();

        if ($this->isLimitReached($totalAlerts, $totalPerUser['alerts'], $totalPerUser['days'])) {
            return false;
        }

        $alertId = $this->communication_id;
        $alerts = $totalAlerts->filter(
            function (\ThemeHouse\Monetize\Entity\CommunicationLog $log) use ($alertId) {
                return $log->communication_id === $alertId;
            }
        );

        if ($this->isLimitReached($alerts, $perUser['alerts'], $perUser['days'])) {
            return false;
        }

        if ($this->isLimitReached($alerts, $this->limit, $this->limit_days)) {
            return false;
        }

        return true;
    }

    /**
     * @param array $replacements
     * @return string
     */
    protected function prepareAlert(&$replacements = [])
    {
        $body = $this->body;

        if (isset($this->type_options['link_url']) && ($linkUrl = $this->type_options['link_url'])) {
            $link = '<a href="' . $linkUrl . '" class="fauxBlockLink-blockLink">'
                . ($linkUrl ? $linkUrl : $linkUrl)
                . '</a>';
            $replacements['{link}'] = $link;

            if (strpos($body, '{link}') === false) {
                $body .= ' {link}';
            }
        }
        return $body;
    }
}
