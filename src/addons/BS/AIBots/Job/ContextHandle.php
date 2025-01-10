<?php

namespace BS\AIBots\Job;

use BS\AIBots\Entity\Bot;
use BS\AIBots\Exception\ShouldRehandleException;
use XF\Job\AbstractJob;

class ContextHandle extends AbstractJob
{
    public static array $activeBotUserIds = [];

    public function run($maxRunTime)
    {
        $context = $this->app->findByContentType(
            $this->data['content_type'],
            $this->data['content_id'],
        $this->data['with'] ?? []
        );
        if (! $context) {
            return $this->complete();
        }

        /** @var \XF\Entity\User $author */
        $author = isset($this->data['user_relation_key'])
            ? $context->getRelationOrDefault($this->data['user_relation_key'])
            : $this->app->em()->find('XF:User', $this->data['author_id']);
        if (! $author) {
            return $this->complete();
        }

        $message = $this->data['message'];

        $botRepo = $this->getBotRepo();
        $botFinder = $botRepo->findActiveBots()
            ->with('User')
            ->order('bot_id');

        if (isset($this->data['latest_bot_id'])) {
            $botFinder->where('bot_id', '>', $this->data['latest_bot_id']);
        }

        if (! isset($this->data['was_handled'])) {
            $this->data['was_handled'] = false;
        }

        if (! $this->isMatchingChatGPTRequirements()) {
            return $this->complete();
        }

        $bots = $botFinder->fetch();
        self::$activeBotUserIds = (array)$bots->pluckNamed('user_id');

        $start = microtime(true);

        /** @var \BS\AIBots\Entity\Bot $bot */
        foreach ($bots as $bot) {
            // Leave if we've exceeded the max run time
            if (microtime(true) - $start > $maxRunTime) {
                return $this->resume();
            }

            $handler = $bot->Handler;
            // Check if the bot has a handler
            if (! $handler) {
                $this->data['latest_bot_id'] = $bot->bot_id;
                continue;
            }

            // Check if the bot should handle the message
            if (! $handler->shouldHandle($author, $message, $context, ! $this->data['was_handled'])) {
                $this->data['latest_bot_id'] = $bot->bot_id;
                continue;
            }

            try {
                // Handle the message
                // Mark the message as handled
                if ($handler->handle($author, $message, $context, ! $this->data['was_handled'])) {
                    $this->data['was_handled'] = true;

                    if ($this->data['log_replies'] ?? false) {
                        // Log the reply
                        $botRepo->logReply(
                            $author->user_id,
                            $context->getEntityContentType(),
                            $context->getEntityId(),
                            $bot->bot_id
                        );
                    }
                }
            } catch (ShouldRehandleException $e) {
                $this->incrementBotTries($bot);

                if ($this->isBotExceedTries($bot)) {
                    $this->data['latest_bot_id'] = $bot->bot_id;
                    continue;
                }

                return $this->resume();
            } catch (\Exception $e) {
                \XF::logException($e, false, 'Error handling message: ');
            }

            $this->data['latest_bot_id'] = $bot->bot_id;
        }

        return $this->complete();
    }

    protected function isBotExceedTries(Bot $bot)
    {
        $tries = $this->data['bot_handle_tries'] ?? [];
        if (! isset($tries[$bot->bot_id])) {
            return false;
        }

        return $tries[$bot->bot_id] >= 3;
    }

    protected function incrementBotTries(Bot $bot)
    {
        $tries = $this->data['bot_handle_tries'] ?? [];
        if (! isset($tries[$bot->bot_id])) {
            $tries[$bot->bot_id] = 0;
        }

        $tries[$bot->bot_id]++;

        $this->data['bot_handle_tries'] = $tries;
    }

    protected function isMatchingChatGPTRequirements(): bool
    {
        return \XF::service('BS\AIBots:ChatGPT\Requirements')
            ->isValid();
    }

    public function getStatusMessage()
    {
        return 'Posting replies for bots...';
    }

    public function canTriggerByChoice()
    {
        return false;
    }

    public function canCancel()
    {
        return false;
    }

    /**
     * @return \BS\AIBots\Repository\Bot
     */
    protected function getBotRepo()
    {
        return $this->app->repository('BS\AIBots:Bot');
    }
}