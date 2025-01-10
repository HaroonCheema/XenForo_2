<?php

namespace BS\AIBots\Entity;

use BS\AIBots\Bot\IBot;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int $bot_id
 * @property int $user_id
 * @property string $username
 * @property array $extra_user_group_ids
 * @property bool $is_active
 * @property array|null $general
 * @property array|null $triggers
 * @property array|null $restrictions
 * @property string $bot_class
 *
 * GETTERS
 * @property \BS\AIBots\Bot\IBot|null $Handler
 * @property array $tabs
 *
 * RELATIONS
 * @property \XF\Entity\User $User
 */
class Bot extends Entity
{
    public function getHandler(?string $class = null): ?IBot
    {
        $class ??= $this->bot_class;

        if (! $this->getBotRepo()->isValidBotClass($class)) {
            return null;
        }

        $xfClassName = $this->app()->extendClass($class);
        return new $xfClassName($this->app(), $this);
    }

    public function getTabs(): array
    {
        if (! $this->Handler) {
            return [];
        }
        return $this->Handler->getTabs();
    }

    // function to get non-existing array keys from general, triggers and restrictions
    public function getSafest(string $column, string $key, string $default = null)
    {
        return $this->get($column)[$key] ?? $default;
    }

    protected function filterValidRegexes(array $regexes)
    {
        return array_filter($regexes, static function ($regex) {
            return @preg_match($regex, '') !== false;
        });
    }

    protected function verifyBotClass(string $class)
    {
        if (! ($handler = $this->getHandler($class)) ) {
            $this->error(\XF::phrase('bs_aib_invalid_handler'), 'bot_class');
            return false;
        }

        $handler->setupDefaults();

        return true;
    }

    protected function _preSave()
    {
        $this->verifyAssociatedUsername();
        $this->verifyHandlerDependencies();
    }

    protected function verifyAssociatedUsername()
    {
        if (! $this->user_id || $this->isChanged('username')) {
            $user = $this->_em->findOne('XF:User', ['username' => $this->username]);
            if ($user) {
                $this->user_id = $user->user_id;
            } else {
                $this->error(\XF::phrase('bs_aib_bot_user_not_found'), 'username');
                return;
            }

            if ($this->_em->findOne('BS\AIBots:Bot', ['user_id' => $this->user_id])) {
                $this->error(\XF::phrase('bs_aib_bot_with_same_username_already_exists'), 'username');
            }
        }
    }

    protected function verifyHandlerDependencies()
    {
        $handler = $this->getHandler();
        if (! $handler) {
            $this->error(\XF::phrase('bs_aib_invalid_handler'), 'bot_class');
            return;
        }

        $general = $this->general;
        $restrictions = $this->restrictions;
        $triggers = $this->triggers;

        if ($this->isChanged('general')) {
            $handler->verifyGeneral($general);
        }

        if ($this->isChanged('restrictions')) {
            $handler->verifyRestrictions($restrictions);
        }

        if ($this->isChanged('triggers')) {
            $handler->verifyTriggers($triggers);
        }

        $this->general = $general;
        $this->restrictions = $restrictions;
        $this->triggers = $triggers;
    }

    protected function _postSave()
    {
        if ($this->isChanged('extra_user_group_ids')) {
            $this->getUserGroupChangeService()->addUserGroupChange(
                $this->user_id,
                $this->getUserGroupChangesKey(),
                $this->extra_user_group_ids
            );
        }
    }

    protected function _postDelete()
    {
        $this->getUserGroupChangeService()->removeUserGroupChange(
            $this->user_id,
            $this->getUserGroupChangesKey()
        );
    }

    protected function getUserGroupChangesKey(): string
    {
        return 'bs_ai_bot_'.$this->bot_id;
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_bs_ai_bot';
        $structure->shortName = 'BS\AIBots:Bot';
        $structure->contentType = '';
        $structure->primaryKey = 'bot_id';
        $structure->columns = [
            'bot_id'               => ['type' => self::UINT, 'autoIncrement' => true],
            'user_id'              => ['type' => self::UINT],
            'username'             => ['type' => self::STR, 'maxLength' => 50],
            'extra_user_group_ids' => [
                'type'    => self::LIST_COMMA,
                'default' => [],
                'list'    => ['type' => 'posint', 'unique' => true, 'sort' => SORT_NUMERIC]
            ],
            'is_active'            => ['type' => self::BOOL, 'default' => true],
            'general'              => ['type' => self::JSON_ARRAY, 'nullable' => true, 'default' => []],
            'triggers'             => ['type' => self::JSON_ARRAY, 'nullable' => true, 'default' => []],
            'restrictions'         => ['type' => self::JSON_ARRAY, 'nullable' => true, 'default' => []],
            'bot_class'            => ['type' => self::STR, 'default' => ''],
        ];
        $structure->getters = [
            'Handler' => true,
            'tabs' => true
        ];
        $structure->relations = [
            'User' => [
                'entity'     => 'XF:User',
                'type'       => self::TO_ONE,
                'conditions' => 'user_id',
                'primary'    => true
            ]
        ];

        return $structure;
    }

    /**
     * @return \XF\Service\User\UserGroupChange
     */
    protected function getUserGroupChangeService()
    {
        return $this->app()->service('XF:User\UserGroupChange');
    }

    /**
     * @return \BS\AIBots\Repository\Bot
     */
    protected function getBotRepo()
    {
        return $this->repository('BS\AIBots:Bot');
    }
}