<?php

namespace BS\AIBots\Service\ChatGPT;

use BS\AIBots\Entity\Bot;
use BS\AIBots\Exception\ShouldRehandleException;
use BS\ChatGPTBots\Response;
use Orhanerday\OpenAi\OpenAi;
use XF\Mvc\Entity\Entity;
use XF\Service\AbstractService;

abstract class AbstractReplier extends AbstractService
{
    use \BS\AIBots\Bot\Concerns\ChatGPT\Triggers;
    use \BS\AIBots\Bot\Concerns\ChatGPT\Restrictions;

    protected OpenAi $api;

    protected Entity $replyContextItem;

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

    public function reply(Bot $bot)
    {
        $message = $this->getReplyContextItemMessage();

        $this->setReplyTemperature($bot->general['temperature']);

        $hasQuotes = $this->hasQuotes($message, $bot->user_id);
        if ($hasQuotes) {
            $this->buildRepliesOnQuotes($bot);
        } else {
            $this->buildRepliesOnMentions($bot);
        }

        $post = \XF::asVisitor($bot->User, fn() => $this->postReplies($bot));

        $this->resetContextAndReplies();

        return $post;
    }

    protected function getReplyContextItemMessage(): string
    {
        return $this->replyContextItem->get('message');
    }

    public function postReplies(Bot $bot)
    {
        if (empty($this->replies)) {
            return null;
        }

        return $this->_postReplies($bot);
    }

    abstract protected function _postReplies(Bot $bot);

    protected function getFinalMessage(): string
    {
        return trim(implode(str_repeat(PHP_EOL, 2), $this->replies));
    }

    protected function buildRepliesOnQuotes(Bot $bot)
    {
        $this->setupMessagesContext($bot, 'quotes');

        $quotes = $this->messageRepo->getQuotes(
            $this->getReplyContextItemMessage(),
            $bot->user_id
        );
        foreach ($quotes as $quote) {
            $this->addQuoteToMessages($quote);
            $reply = $this->getReplyOnMessages();
            // Add bot replies to memory
            $this->messages[] = $this->messageRepo->wrapMessage($reply, 'assistant');
            $this->pushReplyWithQuoteMessage($quote, $reply);
        }
    }

    protected function buildRepliesOnMentions(Bot $bot)
    {
        $this->setupMessagesContext($bot, 'mentions');

        // don't reply to mentions message after removes quotes is empty
        $latestMessage = end($this->messages);
        if (! ($latestMessage['content'] ?? false)) {
            return;
        }

        $this->pushReplyOnLatestMessage();
    }

    protected function setupMessagesContext(Bot $bot, string $context = 'quotes'): void
    {
        $this->messages = $this->buildMessages($bot, $context);
    }

    abstract protected function buildMessages(Bot $bot, string $context);

    protected function getReplyOnMessages(): string
    {
        if (empty($this->messages)) {
            return '';
        }

        try {
            return Response::getReplyWithLogErrors($this->api, [
                'model'             => 'gpt-3.5-turbo',
                'messages'          => $this->messages,
                'temperature'       => $this->replyTemperature,
                'frequency_penalty' => 0,
                'presence_penalty'  => 0,
            ], true);
        } catch (\Exception $e) {
            throw new ShouldRehandleException($e->getMessage());
        }
    }

    protected function addQuoteToMessages(array $quote): void
    {
        $this->messages[] = $this->messageRepo->wrapMessage($quote['content'], 'assistant');
        $this->messages[] = $this->messageRepo->wrapMessage($quote['message']);
    }

    protected function pushReplyWithQuoteMessage(array $quote, string $reply)
    {
        $replyQuote = $this->makePartialQuote($this->replyContextItem, $quote['message']);
        $reply ??= $this->getReplyOnMessages();
        if ($this->shouldIgnoreReply($reply)) {
            return;
        }
        $this->replies[] = $replyQuote . PHP_EOL . $reply;
    }

    protected function pushReplyOnLatestMessage()
    {
        $replyQuote = $this->makePartialQuote($this->replyContextItem, end($this->messages)['content']);
        $reply = $this->getReplyOnMessages();
        if ($this->shouldIgnoreReply($reply)) {
            return;
        }
        $this->replies[] = $replyQuote . PHP_EOL . $reply;
    }

    protected function shouldIgnoreReply(string $reply)
    {
        $response = @json_decode($reply, true);
        if (! is_array($response)) {
            return false;
        }
        return (bool)($response['ignore'] ?? false);
    }

    protected function getSmartIgnorePrompt(): string
    {
        return <<<PROMPT
By default, user always refers to you
If user message referring to another member, you will ignore it
When you ignore user message, your answer must contain only json code {"ignore":true} and nothing else
Don't return json response unnecessarily
PROMPT;
    }

    abstract protected function makePartialQuote(
        Entity $context,
        string $content
    ): string;

    public function resetContextAndReplies(): void
    {
        $this->messages = [];
        $this->replies = [];
    }

    /**
     * @param  float  $replyTemperature
     */
    protected function setReplyTemperature(float $replyTemperature): void
    {
        $this->replyTemperature = $replyTemperature;
    }
}