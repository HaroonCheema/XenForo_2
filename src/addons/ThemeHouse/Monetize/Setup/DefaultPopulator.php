<?php

namespace ThemeHouse\Monetize\Setup;

/**
 * Trait DefaultPopulator
 * @package ThemeHouse\Monetize\Setup
 */
trait DefaultPopulator
{
    /**
     * @throws \XF\PrintableException
     */
    protected function setupDefaults() {
        $this->createDefaultUpgradePage();
        $this->createDefaultPaymentProvider();
        $this->createDefaultPaymentProfile();
        $this->createDefaultAlert();
        $this->createDefaultEmail();
        $this->createDefaultMessage();
    }

    /**
     * @param int $previousVersion
     * @throws \XF\PrintableException
     * @throws \XF\PrintableException
     */
    protected function createDefaultUpgradePage($previousVersion = 0)
    {
        if ($previousVersion < 1000035) {
            $this->createUpgradePage('Account upgrades');
        }
    }

    /**
     * @param $title
     * @throws \XF\PrintableException
     */
    public function createUpgradePage($title)
    {
        /** @var \ThemeHouse\Monetize\Entity\UpgradePage $upgradePage */
        $upgradePage = \XF::em()->create('ThemeHouse\Monetize:UpgradePage');
        $success = $upgradePage->save(false);

        if ($success) {
            $masterTitle = $upgradePage->getMasterPhrase();
            $masterTitle->phrase_text = $title;
            $masterTitle->save(false);
        }
    }

    /**
     * @param int $previousVersion
     * @throws \XF\PrintableException
     * @throws \XF\PrintableException
     * @throws \XF\PrintableException
     */
    protected function createDefaultPaymentProvider($previousVersion = 0)
    {
        if ($previousVersion < 1000037) {
            $this->createPaymentProvider('thmonetize_free', 'ThemeHouse\Monetize:Free');
        }

        if ($previousVersion < 1000133) {
            $this->createPaymentProvider('thmonetize_other', 'ThemeHouse\Monetize:Other');
        }
    }

    /**
     * @param $id
     * @param $class
     * @throws \XF\PrintableException
     */
    public function createPaymentProvider($id, $class)
    {
        /** @var \XF\Entity\PaymentProvider $paymentProvider */
        $paymentProvider = \XF::em()->create('XF:PaymentProvider');
        $paymentProvider->provider_id = $id;
        $paymentProvider->provider_class = $class;
        $paymentProvider->addon_id = 'ThemeHouse/Monetize';
        $paymentProvider->save(false);
    }

    /**
     * @param int $previousVersion
     * @throws \XF\PrintableException
     * @throws \XF\PrintableException
     */
    protected function createDefaultPaymentProfile($previousVersion = 0)
    {
        if ($previousVersion < 1000037) {
            $this->createPaymentProfile('thmonetize_free', 'Free');
        }
    }

    /**
     * @param $id
     * @param $title
     * @throws \XF\PrintableException
     */
    public function createPaymentProfile($id, $title)
    {
        /** @var \XF\Entity\PaymentProfile $paymentProfile */
        $paymentProfile = \XF::em()->create('XF:PaymentProfile');
        $paymentProfile->provider_id = $id;
        $paymentProfile->title = $title;
        $paymentProfile->save(false);
    }

    /**
     * @param int $previousVersion
     * @throws \XF\PrintableException
     * @throws \XF\PrintableException
     */
    protected function createDefaultAlert($previousVersion = 0)
    {
        if ($previousVersion < 1000041) {
            $this->createAlert(
                'Upgrade purchased',
                [
                    'day_type' => 'dom',
                    'dom' => [-1]
                ],
                'Thank you for purchasing one of our user upgrades.',
                1,
                7,
                [
                    'is_active' => ['rule' => 'is_active'],
                    'is_not_expired' => ['rule' => 'is_not_expired'],
                    'start_date_within' => ['rule' => 'start_date_within', 'data' => ['days' => '1']],
                ]
            );
        }
    }

    /**
     * @param $title
     * @param $sendRules
     * @param $body
     * @param $limitAlerts
     * @param $limitDays
     * @param $userUpgradeCriteria
     * @throws \XF\PrintableException
     */
    public function createAlert($title, $sendRules, $body, $limitAlerts, $limitDays, $userUpgradeCriteria)
    {
        /** @var \ThemeHouse\Monetize\Entity\Communication $alert */
        $alert = \XF::em()->create('ThemeHouse\Monetize:Communication');
        $alert->title = $title;
        $alert->type = 'alert';
        $alert->send_rules = $sendRules;
        $alert->body = $body;
        $alert->limit = $limitAlerts;
        $alert->limit_days = $limitDays;
        $alert->user_upgrade_criteria = $userUpgradeCriteria;
        $alert->save(false);
    }

    /**
     * @param int $previousVersion
     * @throws \XF\PrintableException
     * @throws \XF\PrintableException
     */
    protected function createDefaultEmail($previousVersion = 0)
    {
        if ($previousVersion < 1000041) {
            $this->createEmail(
                'Your upgrade has expired',
                [
                    'day_type' => 'dom',
                    'dom' => [-1]
                ],
                "Hi {name},

This is a courtesy message to let you know that one of your user upgrades has just expired.",
                1,
                7,
                [
                    'is_expired' => ['rule' => 'is_expired'],
                    'is_not_active' => ['rule' => 'is_not_active'],
                    'is_not_recurring' => ['rule' => 'is_not_recurring'],
                    'end_date_within' => ['rule' => 'end_date_within', 'data' => ['days' => '2']],
                ]
            );
        }
    }

    /**
     * @param $title
     * @param $sendRules
     * @param $body
     * @param $limitEmails
     * @param $limitDays
     * @param $userUpgradeCriteria
     * @throws \XF\PrintableException
     */
    public function createEmail($title, $sendRules, $body, $limitEmails, $limitDays, $userUpgradeCriteria)
    {
        /** @var \ThemeHouse\Monetize\Entity\Communication $email */
        $email = \XF::em()->create('ThemeHouse\Monetize:Communication');
        $email->type = 'email';
        $email->title = $title;
        $email->send_rules = $sendRules;
        $email->body = $body;
        $email->type_options = ['format' => 'html'];
        $email->limit = $limitEmails;
        $email->limit_days = $limitDays;
        $email->user_upgrade_criteria = $userUpgradeCriteria;
        $email->save(false);
    }

    /**
     * @param int $previousVersion
     * @throws \XF\PrintableException
     * @throws \XF\PrintableException
     */
    protected function createDefaultMessage($previousVersion = 0)
    {
        if ($previousVersion < 1000041) {
            $this->createMessage(
                'Your upgrade is about to expire',
                [
                    'day_type' => 'dom',
                    'dom' => [-1]
                ],
                "Hi {name},

This is a courtesy message to let you know that one of your user upgrades is about to expire in less than 7 days.",
                1,
                7,
                [
                    'is_active' => ['rule' => 'is_active'],
                    'end_date_within' => ['rule' => 'end_date_within', 'data' => ['days' => '7']],
                    'end_date_not_within' => ['rule' => 'end_date_not_within', 'data' => ['days' => '5']],
                ]
            );
        }
    }

    /**
     * @param $title
     * @param $sendRules
     * @param $body
     * @param $limitMessages
     * @param $limitDays
     * @param $userUpgradeCriteria
     * @throws \XF\PrintableException
     */
    public function createMessage($title, $sendRules, $body, $limitMessages, $limitDays, $userUpgradeCriteria)
    {
        /** @var \ThemeHouse\Monetize\Entity\Communication $message */
        $message = \XF::em()->create('ThemeHouse\Monetize:Communication');
        $message->title = $title;
        $message->type = 'message';
        $message->send_rules = $sendRules;
        $message->body = $body;
        $message->user_id = 1;
        $message->limit = $limitMessages;
        $message->limit_days = $limitDays;
        $message->user_upgrade_criteria = $userUpgradeCriteria;
        $message->save(false);
    }
}