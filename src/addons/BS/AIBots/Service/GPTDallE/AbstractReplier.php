<?php

namespace BS\AIBots\Service\GPTDallE;

use BS\AIBots\Entity\Bot;
use BS\ChatGPTBots\Repository\Message;
use BS\ChatGPTBots\Response;
use Orhanerday\OpenAi\OpenAi;
use XF\App;
use XF\Mvc\Entity\Entity;
use XF\Service\AbstractService;
use XF\Util\File;
use XF\Util\Random;

abstract class AbstractReplier extends AbstractService
{
    private const DALLE_RESPONSE_STRUCTURE = [
        'prompt'          => '',
        'n'               => '',
        'size'            => '',
        'response_format' => '',
    ];

    protected OpenAi $api;

    protected Entity $replyContextItem;

    protected Message $messageRepo;

    public function __construct(App $app, Entity $replyContextItem)
    {
        parent::__construct($app);
        $this->api = $app->container('chatGPT');
        $this->replyContextItem = $replyContextItem;
        /** @var \BS\ChatGPTBots\Repository\Message messageRepo */
        $this->messageRepo = $this->repository('BS\ChatGPTBots:Message');
    }

    public function reply(Bot $bot): ?Entity
    {
        $gptReply = $this->getImageGeneratorJsonFromChatGPT($bot);
        $query = @json_decode($gptReply, true);

        if (! is_array($query)) {
            $this->logError(
                'Empty quote',
                compact('query', 'gptReply')
            );
            return null;
        }

        $query = $this->standardizeDallEQuery($bot, $query);

        if (! $this->hasRequiredStructure($query, self::DALLE_RESPONSE_STRUCTURE)) {
            $this->logError(
                'Invalid query structure',
                compact('query', 'gptReply')
            );
            return null;
        }

        $images = $this->getImagesFromDallE($query);
        if (empty($images)) {
            $this->logError(
                'Empty images',
                compact('query', 'images', 'gptReply')
            );
            return \XF::asVisitor(
                $bot->User,
                fn() => $this->postUnsuccessful($bot)
            );
        }

        return \XF::asVisitor($bot->User, fn() => $this->postImages($bot, $images, $query));
    }

    protected function postUnsuccessful(Bot $bot): ?Entity
    {
        $reply = $this->getUnsuccessfulMessageReplyFromChatGPT($bot);
        if (! $reply) {
            return null;
        }

        return $this->postUnsuccessfulMessage($bot, $reply);
    }

    abstract protected function postUnsuccessfulMessage(Bot $bot, string $message): ?Entity;

    abstract protected function postImages(Bot $bot, array $images, array $query): ?Entity;

    protected function getImagesFromDallE(array $query): array
    {
        $response = @json_decode($this->api->image($query), true);

        if (! is_array($response)) {
            return [];
        }

        if (! array_key_exists('data', $response)) {
            $this->logError(
                'Invalid response structure',
                compact('query', 'response')
            );
            return [];
        }

        return array_map(static fn($image) => $image['b64_json'], $response['data']);
    }

    protected function standardizeDallEQuery(Bot $bot, array $query)
    {
        $query['response_format'] = 'b64_json';

        // Restrict the number of images to the maximum allowed by the bot
        if ($query['n'] > $bot->restrictions['max_images_per_message']) {
            $query['n'] = $bot->restrictions['max_images_per_message'];
        }
        // Restrict the size of the images to the maximum allowed by the bot
        $size = (int)explode('x', $query['size'])[0];
        if ($size > $bot->restrictions['max_image_size']) {
            $query['size'] = implode(
                'x',
                array_fill(0, 2, $bot->restrictions['max_image_size'])
            );
        }

        return $query;
    }

    protected function uploadBase64Images(array $images, array $query): string
    {
        $attachmentRepo = $this->getAttachmentRepo();
        $handler = $attachmentRepo->getAttachmentHandler(
            $this->replyContextItem->getEntityContentType()
        );

        $hash = Random::getRandomString(32);

        /** @var \XF\Attachment\Manipulator $manipulator */
        $manipulatorClass = \XF::extendClass('XF\Attachment\Manipulator');
        $manipulator = new $manipulatorClass(
            $handler,
            $attachmentRepo,
            $this->getAttachmentContextForItem(),
            $hash
        );

        $imagePrompt = $query['prompt'];

        foreach ($images as $k => $image) {
            // Decode the base64 image
            $imageData = base64_decode($image);
            $resource = imagecreatefromstring($imageData);
            // Save the image as a JPEG file
            $tempFile = File::getTempFile();
            imagejpeg($resource, $tempFile);
            // Free up memory
            imagedestroy($resource);

            $fakeFilename = \XF::phrase('bs_aib_image_filename_x', [
                'key' => $k + 1,
                'prompt' => $imagePrompt,
            ]) . '.jpg';

            $uploadClass = \XF::extendClass('XF\Http\Upload');
            $upload = new $uploadClass($tempFile, $fakeFilename, null);
            $manipulator->insertAttachmentFromUpload($upload, $error);
        }

        return $hash;
    }

    abstract protected function getAttachmentContextForItem(): array;

    protected function getReplyContextItemMessage(): string
    {
        return $this->replyContextItem->get('message');
    }

    protected function getImageGeneratorJsonFromChatGPT(Bot $bot)
    {
        $message = $this->getReplyContextItemMessage();
        $prompt = $this->getImageGeneratorPromptForChatGPT($message);

        return trim(Response::getReplyWithLogErrors($this->api, [
            'model'             => $bot->getSafest('general', 'chat_model', 'gpt-3.5-turbo'),
            'messages'          => [
                $this->messageRepo->wrapMessage($prompt, 'system')
            ],
            'temperature'       => 0.1,
            'frequency_penalty' => 0,
            'presence_penalty'  => 0,
        ]));
    }

    protected function getUnsuccessfulMessageReplyFromChatGPT(Bot $bot): string
    {
        $userMessage = $this->getReplyContextItemMessage();
        $prompt = $this->getUnsuccessfulPromptForChatGPT($userMessage);
        return trim(Response::getReplyWithLogErrors($this->api, [
            'model'             => $bot->getSafest('general', 'chat_model', 'gpt-3.5-turbo'),
            'messages'          => [
                $this->messageRepo->wrapMessage($prompt, 'system')
            ],
            'temperature'       => 0.1,
            'frequency_penalty' => 0,
            'presence_penalty'  => 0,
        ]));
    }

    protected function hasRequiredStructure(array $input, array $comparison)
    {
        foreach ($comparison as $key => $value) {
            if (!array_key_exists($key, $input)) {
                return false;
            }

            if (is_array($value)) {
                $isNestedStructureValid = is_array($input[$key])
                    && $this->hasRequiredStructure($input[$key], $value);
                if (!$isNestedStructureValid) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function getImageGeneratorPromptForChatGPT(string $message): string
    {
        return <<<PROMPT
Convert message for DALL-E query, your answer must contain only JSON code, without any notes. 
Here are required JSON structure "{"prompt":"PROMPT_MESSAGE","n":IMAGES_COUNT,"size":"size from ALLOWABLE_SIZES based on message","response_format":"b64_json"}"
Remove size info from the PROMPT_MESSAGE, but leave it in JSON. 
Shorten the PROMPT_MESSAGE if it is longer than 1000 characters.
Reformulate the PROMPT_MESSAGE so that it answers the question "What should be in the picture?", it should not contain request for visual content and questions.
Default size is 512x512, default images count is 1.
ALLOWABLE_SIZES: 256x256, 512x512, 1024x1024
Message: $message
PROMPT;
    }

    protected function getUnsuccessfulPromptForChatGPT(string $message): string
    {
        return <<<PROMPT
Our bot failed to generate the messages that the user requested.
Please reply that we're sorry by suggesting other image search options for him if you have any suggestions.
Him message: $message
PROMPT;
    }

    protected function logError(string $message, array $params = [])
    {
        if (! \XF::$debugMode) {
            return;
        }

        foreach ($params as $key => $value) {
            if (PHP_SAPI === 'cli') {
                $GLOBALS['argv']["gptDalle[$key]"] = $value;
            } else {
                $_POST["gptDalle[$key]"] = $value;
            }
        }

        \XF::logError('GPT Dall-E: ' . $message);

        foreach ($params as $key => $value) {
            if (PHP_SAPI === 'cli') {
                unset($GLOBALS['argv']["gptDalle[$key]"]);
            } else {
                unset($_POST["gptDalle[$key]"]);
            }
        }
    }

    /**
     * @return \XF\Repository\Attachment
     */
    protected function getAttachmentRepo()
    {
        return $this->repository('XF:Attachment');
    }
}