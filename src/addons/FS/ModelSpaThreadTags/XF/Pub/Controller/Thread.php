<?php

namespace FS\ModelSpaThreadTags\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{

    public function actionSuggestion(ParameterBag $params)
    {
        $visitor = \XF::visitor();

        if (!$visitor->is_admin && !$visitor->is_moderator) {
            return $this->noPermission();
        }

        $options = \XF::options();

        if (empty($options->fs_chat_gpt_api_key)) {
            return $this->error(\XF::phrase('fs_chat_gpt_api_key_not_configured'));
        }

        $thread = $this->assertViewableThread($params->thread_id, $this->getThreadViewExtraWith());

        $data = $this->getModelAndSpaName($thread);

        $content = $data['choices'][0]['message']['content'] ?? '';

        if (!$content) {
            return $this->notFound();
        }

        $modelName = 'N/A';
        $spaName = 'N/A';

        // Normalize line endings and split
        $lines = preg_split("/\r\n|\n|\r/", $content);

        foreach ($lines as $line) {
            if (stripos($line, 'model name') !== false) {
                $modelName = trim(preg_replace('/model name\s*:\s*/i', '', $line));
            } elseif (stripos($line, 'spa name') !== false) {
                $spaName = trim(preg_replace('/spa name\s*:\s*/i', '', $line));
            }
        }

        if (stripos($modelName, 'not mentioned') !== false || $modelName === '') {
            $modelName = '';
        }
        if (stripos($spaName, 'not mentioned') !== false || $spaName === '') {
            $spaName = '';
        }

        if (!$modelName && !$spaName) {
            return $this->error(\XF::phrase('fs_thread_model_or_spa_not_found'));
        }

        $finder = \XF::finder('XF:Thread');

        $conditions = [
            ['title', 'LIKE', $finder->escapeLike("Review", '%?%')],
            // ['title', 'LIKE', $finder->escapeLike($modelName, '%?%')],
            ['title', 'LIKE', $finder->escapeLike($spaName, '%?%')],
        ];

        $threads = $finder
            ->whereOr($conditions)->fetch();

        $threadModelSpaValues = array();

        foreach ($threads as $key => $threadVal) {
            $threadModelSpaValues[$key]['modelName'] = '';
            $threadModelSpaValues[$key]['spaName'] = '';

            if (stripos($threadVal->title, "Review") !== false) {
                // if (stripos($threadVal->title, $modelName) !== false) {
                $threadModelSpaValues[$key]['modelName'] = $modelName;
            }

            if (stripos($threadVal->title, $spaName) !== false) {
                $threadModelSpaValues[$key]['spaName'] = $spaName;
            }
        }

        echo "<pre>";
        var_dump($threadModelSpaValues);
        exit;

        $viewParams = [
            'thread' => $thread,
            'threadModelSpaValues' => $threadModelSpaValues
        ];
        return $this->view('XF:Thread\Suggestion', 'fs_thread_model_spa_suggestion', $viewParams);
    }

    public function getModelAndSpaName(\XF\Entity\Thread $thread)
    {
        $client = \XF::app()->http()->client();

        $endpointUrl = "https://api.openai.com/v1/chat/completions";

        // echo "<pre>";
        // var_dump($options->fs_chat_gpt_api_key);
        // exit;
        $options = \XF::options();

        $apiKey = $options->fs_chat_gpt_api_key;

        // $payload = json_encode($paymentParams, JSON_UNESCAPED_SLASHES);

        $body = [
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an assistant that extracts spa and model names from sentences.'
                ],
                [
                    'role' => 'user',
                    'content' => 'On this line "' . $thread->title . '" I want to know model name and spa name in format:\n\nmodel name : y\nspa name : x'
                    // 'content' => 'On this line "Review: Green Spa - Olivia" I want to know model name and spa name in format:\n\nmodel name : y\nspa name : x'
                    // 'content' => \XF::phrase('fs_model_spa_thread_title', ['title' => $thread->title])
                ]
            ]
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $apiKey,
        ];

        try {
            $response = $client->post($endpointUrl, [
                'headers' => $headers,
                'body' => json_encode($body)
            ]);

            $data = $response->getBody()->getContents();

            if ($response->getStatusCode() != 200) {

                throw new \XF\PrintableException('Unexpected status code: ' . $response->getStatusCode());
            }

            return json_decode($data, true);
        } catch (\Exception $ex) {
            throw new \RuntimeException('CoinPayments API call failed: ' . $ex->getMessage());
        }
    }
}
