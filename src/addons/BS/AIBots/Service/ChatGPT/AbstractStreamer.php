<?php

namespace BS\AIBots\Service\ChatGPT;

use BS\AIBots\Entity\Bot;
use BS\AIBots\Exception\ShouldRehandleException;
use BS\ChatGPTBots\Response;
use Orhanerday\OpenAi\OpenAi;
use XF\Mvc\Entity\Entity;
use XF\Service\AbstractService;

abstract class AbstractStreamer extends AbstractService
{
    use \BS\AIBots\Bot\Concerns\ChatGPT\Triggers;
    use \BS\AIBots\Bot\Concerns\ChatGPT\Restrictions;

    protected OpenAi $api;

    protected Entity $replyContextItem;

    protected ?Entity $streamingItem = null;

    protected array $messages = [];

    protected array $replies = [];

    protected float $replyTemperature = 1;

    public function __construct(\XF\App $app, Entity $replyContextItem)
    {
        parent::__construct($app);
        $this->api = $app->container('chatGPT');
        $this->setupMessageRepo();
        $this->replyContextItem = $replyContextItem;
    }

    public function stream(Bot $bot)
    {
        $message = $this->getReplyContextItemMessage();

        $this->setReplyTemperature($bot->general['temperature']);

        $hasQuotes = $this->hasQuotes($message, $bot->user_id);
        if ($hasQuotes) {
            $this->streamRepliesOnQuotes($bot);
        } else {
            $this->streamRepliesOnMentions($bot);
        }

        $this->resetMessagesAndStreamingItem();

        return $this->streamingItem;
    }

    protected function getReplyContextItemMessage(): string
    {
        return $this->replyContextItem->get($this->_getReplyContextItemMessageKey());
    }

    protected function _getReplyContextItemMessageKey(): string
    {
        return 'message';
    }

    protected function publishStreamingItem(Bot $bot, string $message): Entity
    {
        return \XF::asVisitor(
            $bot->User,
            fn() => $this->_publishStreamingItem($bot, $message)
        );
    }

    abstract protected function _publishStreamingItem(Bot $bot, string $message): Entity;

    protected function updateStreamingItem(Bot $bot, string $message): void
    {
        if (! $this->streamingItem) {
            $this->streamingItem = $this->publishStreamingItem($bot, $message);
        }
        \XF::asVisitor(
            $bot->User,
            fn() => $this->_updateStreamingItem($bot, $message)
        );
    }

    abstract protected function _updateStreamingItem(Bot $bot, string $message): void;

    protected function streamRepliesOnQuotes(Bot $bot)
    {
        $this->setupMessagesContext($bot, 'quotes');

        $quotes = $this->messageRepo->getQuotes(
            $this->getReplyContextItemMessage(),
            $bot->user_id
        );
        foreach ($quotes as $quote) {
            $this->addQuoteToMessages($quote);
            $replyQuote = $this->makePartialQuote($this->replyContextItem, $quote['message']);
            $reply = $this->streamReplyOnMessages($bot, $replyQuote);
            if (! $reply) {
                continue;
            }
            // Add bot replies to memory
            $this->messages[] = $this->messageRepo->wrapMessage($reply, 'assistant');
        }
    }

    protected function streamRepliesOnMentions(Bot $bot)
    {
        $this->setupMessagesContext($bot, 'mentions');

        // don't reply to mentions message after removes quotes is empty
        $latestMessage = end($this->messages);
        if (! ($latestMessage['content'] ?? false)) {
            return;
        }

        $replyQuote = $this->makePartialQuote($this->replyContextItem, end($this->messages)['content']);
        $reply = $this->streamReplyOnMessages($bot, $replyQuote);

        // Add bot replies to memory
        $this->messages[] = $this->messageRepo->wrapMessage($reply, 'assistant');
    }

    protected function setupMessagesContext(Bot $bot, string $context = 'quotes'): void
    {
        $this->messages = $this->buildMessages($bot, $context);
    }

    abstract protected function buildMessages(Bot $bot, string $context);

    protected function streamReplyOnMessages(
        Bot $bot,
        string $outputMessage = ''
    ): ?string {
        if (empty($this->messages)) {
            return null;
        }

        $chatModel = $bot->getSafest('general', 'chat_model', 'gpt-3.5-turbo');

        try {
            Response::streamReplyWithLogErrors(
                $this->api,
                [
                    'model'             => $chatModel,
                    'messages'          => $this->messages,
                    'temperature'       => $this->replyTemperature,
                    'frequency_penalty' => 0,
                    'presence_penalty'  => 0,
                ],
                function ($append) use ($bot, &$outputMessage) {
                    $outputMessage .= $append;
                    $this->updateStreamingItem($bot, $outputMessage);
                },
                true
            );
        } catch (\Exception $e) {
            throw new ShouldRehandleException($e->getMessage());
        }

        return $outputMessage;
    }

    protected function addQuoteToMessages(array $quote): void
    {
        $this->messages[] = $this->messageRepo->wrapMessage($quote['content'], 'assistant');
        $this->messages[] = $this->messageRepo->wrapMessage($quote['message']);
    }

    abstract protected function makePartialQuote(
        Entity $context,
        string $content
    ): string;

    public function resetMessagesAndStreamingItem(): void
    {
        $this->messages = [];
        $this->streamingItem = null;
    }

    /**
     * @param  float  $replyTemperature
     */
    protected function setReplyTemperature(float $replyTemperature): void
    {
        $this->replyTemperature = $replyTemperature;
    }
}