<?php

namespace BS\AIBots\Service\Bot;

use BS\AIBots\Entity\Bot;
use XF\Service\AbstractService;

class Creator extends AbstractService
{
    use \XF\Service\ValidateAndSavableTrait;

    protected Bot $bot;

    public function __construct(\XF\App $app)
    {
        parent::__construct($app);
        $this->bot = $this->em()->create('BS\AIBots:Bot');
    }

    public function setUsername(string $username)
    {
        $this->bot->username = $username;
        return $this;
    }

    public function setExtraUserGroupIds(array $extraUserGroupIds)
    {
        $this->bot->extra_user_group_ids = $extraUserGroupIds;
        return $this;
    }

    public function setIsActive(bool $isActive)
    {
        $this->bot->is_active = $isActive;
        return $this;
    }

    public function setGeneral(array $general)
    {
        $this->bot->general = $general;
        return $this;
    }

    public function setTriggers(array $triggers)
    {
        $this->bot->triggers = $triggers;
        return $this;
    }

    public function setRestrictions(array $restrictions)
    {
        $this->bot->restrictions = $restrictions;
        return $this;
    }

    public function setBotClass(string $class)
    {
        $this->bot->bot_class = $class;
        return $this;
    }

    public function getBot(): Bot
    {
        return $this->bot;
    }

    protected function _validate()
    {
        $this->bot->preSave();
        return $this->bot->getErrors();
    }

    protected function _save()
    {
        $db = $this->db();
        $db->beginTransaction();

        $this->bot->save(true, false);

        $db->commit();
    }
}