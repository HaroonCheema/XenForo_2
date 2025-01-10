<?php

namespace BS\AIBots\Admin\Controller;

use XF\Admin\Controller\AbstractController;

class ChatGPTNodePrompt extends AbstractController
{
    public function actionIndex()
    {
        $nodeRepo = $this->getNodeRepo();
        $nodeTree = $nodeRepo->createNodeTree($nodeRepo->getFullNodeList());

        $viewParams = array_merge(
            $this->getChatGPTNodePromptRepo()->listPromptsWithBotsGroupedByBotAndNode(),
            compact('nodeTree')
        );

        return $this->view(
            'BS\AIBots:ChatGPTNodePrompt\List',
            'bs_aib_chat_gpt_node_prompt_list',
            $viewParams
        );
    }

    public function actionEdit(\XF\Mvc\ParameterBag $params)
    {
        $node = $this->assertNodeExists($params->node_id);
        if ($node->node_type_id !== 'Forum') {
            return $this->error(\XF::phrase('bs_aib_node_type_must_be_forum'));
        }

        /** @var \BS\AIBots\Entity\Bot $bot */
        $bot = $this->em()->find('BS\AIBots:Bot', $this->filter('bot_id', 'uint'));
        $isValidBot = $bot && $bot->bot_class === \BS\AIBots\Bot\ChatGPT::class;
        if (!$isValidBot) {
            return $this->error(\XF::phrase('bs_aib_bot_not_found'));
        }

        $prompt = $this->getChatGPTNodePromptRepo()->findOrCreatePrompt($node, $bot);
        return $this->view(
            'BS\AIBots:ChatGPTNodePrompt\Edit',
            'bs_aib_chat_gpt_node_prompt_edit',
            compact('prompt', 'node', 'bot')
        );
    }

    public function actionSave(\XF\Mvc\ParameterBag $params)
    {
        $this->assertPostOnly();

        $prompt = $this->assertPromptExists($params->prompt_id);

        $input = $this->filter([
            'prompt' => 'str',
        ]);

        $form = $this->formAction();
        $form->basicEntitySave($prompt, $input);
        $form->run();

        return $this->redirect($this->buildLink('ai-bots/chat-gpt-node-prompts'));
    }

    /**
     * @return \XF\Mvc\Entity\Repository|\BS\AIBots\Repository\ChatGPTNodePrompt
     */
    protected function getChatGPTNodePromptRepo()
    {
        return $this->repository('BS\AIBots:ChatGPTNodePrompt');
    }

    /**
     * @return \XF\Mvc\Entity\Repository|\XF\Repository\Node
     */
    protected function getNodeRepo()
    {
        return $this->repository('XF:Node');
    }

    /**
     * @param int $nodeId
     * @param array $with
     * @param string $phraseKey
     * @return \XF\Mvc\Entity\Entity|\XF\Entity\Node
     */
    protected function assertNodeExists($nodeId, array $with = [], $phraseKey = null)
    {
        return $this->assertRecordExists('XF:Node', $nodeId, $with, $phraseKey);
    }

    /**
     * @param $promptId
     * @param  array  $with
     * @param $phraseKey
     * @return \XF\Mvc\Entity\Entity|\BS\AIBots\Entity\ChatGPTNodePrompt
     * @throws \XF\Mvc\Reply\Exception
     */
    protected function assertPromptExists($promptId, array $with = [], $phraseKey = null)
    {
        return $this->assertRecordExists('BS\AIBots:ChatGPTNodePrompt', $promptId, $with, $phraseKey);
    }
}