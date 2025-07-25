<?php

namespace FS\MapEmails\XF\Job;

class UserEmail extends XFCP_UserEmail
{
    protected $defaultData = [
        'emailNextCounter' => 0,
        'nextRunAt' => 0
    ];

    public function run($maxRunTime)
    {
        $startTime = microtime(true);
        $em = $this->app->em();

        if ($this->data['count'] == 0) {
            $emailPerHour = intval($this->data['criteria']['emails_per_hour']);
            $this->data['emailNextCounter'] = $emailPerHour;
        }

        $ids = $this->prepareUserIds();
        if (!$ids) {
            return $this->complete();
        }

        if ($this->data['nextRunAt'] > time()) {
            return $this->resume();
        }

        $this->actionSetup();

        $transaction = $this->wrapTransaction();

        $db = $this->app->db();
        if ($transaction) {
            $db->beginTransaction();
        }

        $limitTime = ($maxRunTime > 0);
        foreach ($ids as $key => $id) {

            $this->data['count']++;

            $this->data['start'] = $id;
            unset($ids[$key]);

            /** @var User $user */
            $user = $em->find('XF:User', $id);
            if ($user) {
                $this->executeAction($user);
            }

            if ($this->data['count'] == $this->data['emailNextCounter']) {
                $emailPerHour = $this->data['criteria']['emails_per_hour'];
                $this->data['emailNextCounter'] += $emailPerHour;

                $this->data['nextRunAt'] = time() + 60; // Set next run time to 1 minute later

                return $this->resume();
            }

            if ($limitTime && microtime(true) - $startTime > $maxRunTime) {
                break;
            }
        }

        if (is_array($this->data['userIds'])) {
            $this->data['userIds'] = array_values($ids);
        }

        if ($transaction) {
            $db->commit();
        }

        return $this->resume();
    }

    protected function prepareTokens(\XF\Entity\User $user, $escape)
    {
        $parent = parent::prepareTokens($user, $escape);

        $criteria = $this->data['criteria'];

        if (!$criteria['used_email']) {
            return $parent;
        }

        $unsubLink = $this->app->router('public')->buildLink('canonical:email-stop/mailing-list', $user);

        $tokens = [
            '{name}' => $user->username,
            '{email}' => $user->MapUser->email_old ?? $user->email,
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

    protected function getMail(\XF\Entity\User $user)
    {
        $parent = parent::getMail($user);

        $criteria = $this->data['criteria'];

        if (!$criteria['used_email']) {
            return $parent;
        }

        $mailer = $this->app->mailer();
        $mail = $mailer->newMail();

        $options = $this->app->options();
        $unsubEmail = $options->unsubscribeEmailAddress;
        $useVerp = $options->enableVerp;

        $mail->setToUser($user);

        $emailMap = $user->MapUser->email_old ?? $user->email;
        $mail->setTo($emailMap, $user->username);

        return $mail->setListUnsubscribe($unsubEmail, $useVerp);
    }
}
