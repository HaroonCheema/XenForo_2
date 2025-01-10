<?php

namespace BS\AIBots\Repository;

use BS\AIBots\Bot\ChatGPT;
use XF\Entity\Node;
use XF\Mvc\Entity\Repository;

class ChatGPTNodePrompt extends Repository
{

    public function listPromptsWithBotsGroupedByBotAndNode()
    {
        $bots = $this->getBotRepo()
            ->findBots()
            ->where('bot_class', ChatGPT::class)
            ->fetch();
        $prompts = $this->getPrompts();

        $groupedPrompts = [];

        foreach ($bots as $bot) {
            $promptTree = $prompts
                ->filter(fn($prompt) => $prompt->bot_id === $bot->bot_id)
                ->groupBy('node_id');
            $cleanPrompts = array_map(
                static fn($promptsList) => reset($promptsList),
                $promptTree
            );

            $groupedPrompts[$bot->bot_id] = $cleanPrompts;
        }

        return compact('bots', 'groupedPrompts');
    }

    /**
     * @param  \XF\Entity\Node  $node
     * @param  \BS\AIBots\Entity\Bot  $bot
     * @return \BS\AIBots\Entity\ChatGPTNodePrompt
     * @throws \XF\PrintableException
     */
    public function findOrCreatePrompt(Node $node, \BS\AIBots\Entity\Bot $bot)
    {
        $prompt = $this->findPrompt($node, $bot);
        if (!$prompt) {
            /** @var \BS\AIBots\Entity\ChatGPTNodePrompt $prompt */
            $prompt = $this->em->create('BS\AIBots:ChatGPTNodePrompt');
            $prompt->node_id = $node->node_id;
            $prompt->bot_id = $bot->bot_id;
            $prompt->prompt = '';
            $prompt->save();
        }
        return $prompt;
    }

    /**
     * @param  \XF\Entity\Node  $node
     * @param  \BS\AIBots\Entity\Bot  $bot
     * @return \XF\Mvc\Entity\Entity|null|\BS\AIBots\Entity\ChatGPTNodePrompt
     */
    public function findPrompt(Node $node, \BS\AIBots\Entity\Bot $bot)
    {
        return $this->em->findOne('BS\AIBots:ChatGPTNodePrompt', [
            'node_id' => $node->node_id,
            'bot_id' => $bot->bot_id,
        ]);
    }

    /**
     * @return \XF\Mvc\Entity\ArrayCollection|\BS\AIBots\Entity\ChatGPTNodePrompt[]
     */
    public function getPrompts()
    {
        return $this->finder('BS\AIBots:ChatGPTNodePrompt')
            ->fetch();
    }

    public function getPromptsCache()
    {
        $registry = $this->app()->registry();
        if (! $registry->exists('bsAibGPTNodePromptCache')) {
            $this->rebuildPromptsCache();
        }
        return $registry->get('bsAibGPTNodePromptCache');
    }

    protected function getPromptsCacheData()
    {
        $cache = [];

        $groupedPrompts = $this->listPromptsWithBotsGroupedByBotAndNode()['groupedPrompts'];
        foreach ($groupedPrompts as $botId => $prompts) {
            $cache[$botId] = array_map(
                static fn($prompt) => $prompt->prompt,
                $prompts
            );
        }

        return $cache;
    }

    public function rebuildPromptsCache()
    {
        $cache = $this->getPromptsCacheData();
        $this->app()->registry()->set('bsAibGPTNodePromptCache', $cache);
        return $cache;
    }

    /**
     * @return \XF\Mvc\Entity\Repository|\BS\AIBots\Repository\Bot
     */
    protected function getBotRepo()
    {
        return $this->repository('BS\AIBots:Bot');
    }
}