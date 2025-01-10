<?php

namespace BS\AIBots\Bot;

use XF\Entity\User;
use XF\Mvc\Entity\Entity;

interface IBot
{
    /**
     * @param  \XF\Entity\User  $author
     * @param  string  $message
     * @param  \XF\Mvc\Entity\Entity  $context
     * @param  bool  $isFirstHandle – whether this is the first bot that matches
     * @return bool
     */
    public function shouldHandle(
        User $author,
        string $message,
        Entity $context,
        bool $isFirstHandle = true
    ): bool;

    /**
     * @param  \XF\Entity\User  $author
     * @param  string  $message
     * @param  \XF\Mvc\Entity\Entity  $context
     * @param  bool  $isFirstHandle – whether this is the first bot that matches
     * @return \XF\Mvc\Entity\Entity|null
     */
    public function handle(
        User $author,
        string $message,
        Entity $context,
        bool $isFirstHandle = true
    ): ?Entity;

    public function getTabs(): array;

    public function renderTabPanes(): string;

    public function getTabPanesTemplateData(): array;

    public function verifyGeneral(array &$general): void;

    public function verifyRestrictions(array &$restrictions): void;

    public function verifyTriggers(array &$triggers): void;

    public function setupDefaults(): void;
}