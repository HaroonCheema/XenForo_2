<?php

namespace ThemeHouse\Monetize\Entity;

use ThemeHouse\Monetize\Entity\Traits\AlertTrait;
use ThemeHouse\Monetize\Entity\Traits\EmailTrait;
use ThemeHouse\Monetize\Entity\Traits\MessageTrait;
use XF\Entity\User;
use XF\Language;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * Class Communication
 * @package ThemeHouse\Monetize\Entity
 *
 * COLUMNS
 * @property integer communication_id
 * @property array send_rules
 * @property string title
 * @property string body
 * @property bool active
 * @property array user_upgrade_criteria
 * @property array user_criteria
 * @property integer next_send
 * @property integer limit_days
 * @property integer limit
 * @property integer user_id
 * @property array type_options
 * @property string type
 *
 * RELATIONS
 * @property \XF\Entity\User User
 */
class Communication extends Entity
{
    use AlertTrait;
    use EmailTrait;
    use MessageTrait;

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_th_monetize_communication';
        $structure->shortName = 'ThemeHouse\Monetize:Communication';
        $structure->primaryKey = 'communication_id';
        $structure->contentType = 'th_monetize_communication';

        $structure->columns += [
            'communication_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
            'send_rules' => ['type' => self::JSON_ARRAY, 'required' => true],
            'title' => [
                'type' => self::STR,
                'maxLength' => 150,
                'required' => 'please_enter_valid_title'
            ],
            'body' => ['type' => self::STR, 'default' => ''],
            'active' => ['type' => self::BOOL, 'default' => true],
            'user_upgrade_criteria' => ['type' => self::JSON_ARRAY, 'default' => []],
            'user_criteria' => ['type' => self::JSON_ARRAY, 'default' => []],
            'next_send' => ['type' => self::UINT, 'default' => 0],
            'limit_days' => ['type' => self::UINT, 'default' => 0],
            'limit' => ['type' => self::UINT, 'default' => 0],
            'user_id' => ['type' => self::UINT, 'nullable' => true],

            'type_options' => ['type' => self::JSON, 'default' => []],
            'type' => ['type' => self::STR, 'allowedValues' => ['email', 'alert', 'message']]
        ];

        $structure->getters = [
            'type_phrase' => true
        ];

        $structure->relations += [
            'User' => [
                'entity' => 'XF:User',
                'type' => self::TO_ONE,
                'conditions' => 'user_id',
            ],
        ];

        return $structure;
    }

    public function getTypePhrase()
    {
        return \XF::phrase('thmonetize_communication.' . $this->type);
    }

    /**
     * @param $userId
     * @throws \XF\PrintableException
     */
    protected function logCommunication($userId)
    {
        /** @var CommunicationLog $log */
        $log = \XF::em()->create('ThemeHouse\Monetize:CommunicationLog');
        $log->communication_id = $this->communication_id;
        $log->user_id = $userId;
        $log->save();
    }

    /**
     * @param ArrayCollection $communications
     * @param $limitCommunications
     * @param $limitDays
     * @return bool
     */
    protected function isLimitReached(ArrayCollection $communications, $limitCommunications, $limitDays)
    {
        if ($limitCommunications && $limitDays) {
            $cutOff = \XF::$time - 86400 * $limitDays;
            $totalCommunications = $communications->filter(
                function (CommunicationLog $log) use ($cutOff) {
                    return ($log->log_date >= $cutOff);
                }
            );
            if ($totalCommunications->count() >= $limitCommunications) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $string
     * @param Language $language
     * @return string
     */
    protected function replacePhrases($string, Language $language)
    {
        return \XF::app()->stringFormatter()->replacePhrasePlaceholders($string, $language);
    }

    /**
     * @param $criteria
     * @return bool
     */
    protected function verifyUserCriteria(&$criteria)
    {
        $userCriteria = $this->app()->criteria('XF:User', $criteria);
        $criteria = $userCriteria->getCriteria();
        return true;
    }

    /**
     * @param array $rules
     * @return bool
     */
    protected function verifySendRules(array &$rules)
    {
        $filterTypes = ['dom', 'dow', 'hours', 'minutes'];

        foreach ($filterTypes as $type) {
            if (!isset($rules[$type])) {
                continue;
            }

            $typeRules = $rules[$type];
            if (!is_array($typeRules)) {
                $typeRules = [];
            }

            $typeRules = array_map('intval', $typeRules);
            $typeRules = array_unique($typeRules);
            sort($typeRules, SORT_NUMERIC);

            $rules[$type] = $typeRules;
        }

        return true;
    }

    /**
     * @param User $user
     * @param ArrayCollection $userUpgrades
     * @throws \XF\PrintableException
     */
    public function sendForUser(User $user, ArrayCollection $userUpgrades)
    {
        switch ($this->type) {
            case 'email':
                $this->sendEmail($user, $userUpgrades);
                break;

            case 'message':
                $this->sendMessage($user, $userUpgrades);
                break;

            case 'alert':
                $this->sendAlert($user, $userUpgrades);
                break;
        }
    }

    /**
     *
     */
    protected function _preSave()
    {
        if ($this->active) {
            if (!is_array($this->send_rules)) {
                $this->send_rules = [];
            }

            $this->set('next_send', $this->calculateNextSend());
        } else {
            $this->set('next_send', 0x7FFFFFFF); // waay in future
        }
    }

    /**
     * @return int
     */
    public function calculateNextSend()
    {
        /** @var \ThemeHouse\Monetize\Service\CalculateNextSend $service */
        $service = $this->app()->service('ThemeHouse\Monetize:CalculateNextSend');
        return $service->calculateNextSendTime($this->send_rules);
    }

    /**
     *
     */
    protected function _setupDefaults()
    {
        $this->send_rules = [
            'day_type' => 'dom',
            'dom' => ['-1']
        ];
    }
}