<?php

namespace BS\AIBots\Bot\Concerns\ChatGPT;

trait Verifiers
{
    public function verifyGeneral(array &$general): void
    {
        $general = [
            'chat_model'                 => $general['chat_model'] ?? 'gpt-3.5-turbo',
            'thread_prompt'              => $general['thread_prompt'] ?? '',
            'thread_context_limit'       => (int)($general['thread_context_limit'] ?? 10),
            'thread_smart_ignore'        => (bool)($general['thread_smart_ignore'] ?? false),
            'conversation_prompt'        => $general['conversation_prompt'] ?? '',
            'conversation_context_limit' => (int)($general['conversation_context_limit'] ?? 10),
            'conversation_smart_ignore'  => (bool)($general['conversation_smart_ignore'] ?? false),
            'bot_profile_prompt'        => $general['bot_profile_prompt'] ?? '',
            'bot_profile_context_limit' => (int)($general['bot_profile_context_limit'] ?? 10),
            'temperature'                => (float)($general['temperature'] ?? 1),
        ];

        if (! $this->isValidChatModel($general['chat_model'])) {
            $this->bot->error(\XF::phrase('bs_ai_bot.chat_gpt_invalid_chat_model'));
        }

        $activeContext = $this->bot->triggers['active_in_context'] ?? [];
        [$contextLimitMin, $contextLimitMax] = $this->getContextLimitsForChatModel(
            $general['chat_model']
        );

        // thread context checks
        if (in_array('thread', $activeContext, true)) {
            if (empty($general['thread_prompt'])) {
                $this->bot->error(\XF::phrase('bs_ai_bot.chat_gpt_prompts_must_be_filled'));
            }
            if (! $this->isNumberBetween($general['thread_context_limit'], $contextLimitMin, $contextLimitMax)) {
                $this->bot->error(\XF::phrase('bs_ai_bot.chat_gpt_invalid_thread_context_limit', [
                    'min' => $contextLimitMin,
                    'max' => $contextLimitMax,
                ]));
            }
        }

        // conversation context checks
        if (in_array('conversation', $activeContext, true)) {
            if (empty($general['conversation_prompt'])) {
                $this->bot->error(\XF::phrase('bs_ai_bot.chat_gpt_prompts_must_be_filled'));
            }
            if (! $this->isNumberBetween($general['conversation_context_limit'], $contextLimitMin, $contextLimitMax)) {
                $this->bot->error(\XF::phrase('bs_ai_bot.chat_gpt_invalid_conversation_context_limit', [
                    'min' => $contextLimitMin,
                    'max' => $contextLimitMax,
                ]));
            }
        }

        // bot profile context checks
        if (in_array('bot_profile', $activeContext, true)) {
            if (empty($general['bot_profile_prompt'])) {
                $this->bot->error(\XF::phrase('bs_ai_bot.chat_gpt_prompts_must_be_filled'));
            }
            if (! $this->isNumberBetween($general['bot_profile_context_limit'], $contextLimitMin, $contextLimitMax)) {
                $this->bot->error(\XF::phrase('bs_ai_bot.chat_gpt_invalid_bot_profile_context_limit', [
                    'min' => $contextLimitMin,
                    'max' => $contextLimitMax,
                ]));
            }
        }

        if (! $this->isNumberBetween($general['temperature'], 0.1, 1.0)) {
            $this->bot->error(\XF::phrase('bs_ai_bot.chat_gpt_invalid_temperature'));
        }
    }

    public function verifyRestrictions(array &$restrictions): void
    {
        $restrictions['ignore_regexes'] = $restrictions['ignore_regexes'] ?? [];
        // Set max_replies_per_thread to the provided value as an integer, or use 0 if not set
        $restrictions['max_replies_per_thread'] = isset($restrictions['max_replies_per_thread']) ?
            (int)$restrictions['max_replies_per_thread']
            : 0;
        // Set spam_check to true if provided and set as boolean, or use false by default
        $restrictions['spam_check'] = isset($restrictions['spam_check'])
            && (bool)$restrictions['spam_check'];
        $restrictions['active_for_user_group_ids'] = $restrictions['active_for_user_group_ids'] ?? [];
        $restrictions['active_node_ids'] = $restrictions['active_node_ids'] ?? [];
        $restrictions['max_replies_per_thread'] = max(0, $restrictions['max_replies_per_thread']);
    }

    public function verifyTriggers(array &$triggers): void
    {
        $triggers['active_in_context'] = $triggers['active_in_context'] ?? [];
        $triggers['post'] = $triggers['post'] ?? [];
        $triggers['conversation'] = $triggers['conversation'] ?? [];

        if (! empty($triggers['regexes'])) {
            $triggers['regexes'] = $this->filterValidRegexes($triggers['regexes']);
        }

        if (! empty($triggers['ignore_regexes'])) {
            $triggers['ignore_regexes'] = $this->filterValidRegexes($triggers['ignore_regexes']);
        }

        $triggers['posted_in_node_ids'] = $triggers['posted_in_node_ids'] ?? [];
    }

    protected function filterValidRegexes(array $regexes)
    {
        return array_filter($regexes, static function ($regex) {
            return ! empty($regex) && @preg_match($regex, '') !== false;
        });
    }

    protected function isNumberBetween($number, $min, $max): bool
    {
        return $number >= $min && $number <= $max;
    }

    public function isValidChatModel(string $model): bool
    {
        /** @var \Orhanerday\OpenAi\OpenAi $api */
        $api = $this->app->container('chatGPT');
        $response = @json_decode($api->retrieveModel($model), true);
        return empty($response['error']);
    }

    protected function getContextLimitsForChatModel(string $model): array
    {
        switch ($model) {
            case 'gpt-3.5-turbo':
            default:
                return [0, 15];
            case 'gpt-4':
                return [0, 20];
            case 'gpt-4-32k':
                return [0, 80];
        }
    }
}