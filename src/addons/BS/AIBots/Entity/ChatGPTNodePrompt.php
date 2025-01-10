<?php

namespace BS\AIBots\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int $prompt_id
 * @property int $node_id
 * @property int $bot_id
 * @property string $prompt
 */
class ChatGPTNodePrompt extends Entity
{
    protected function _postSave()
    {
        $this->getNodePromptRepo()->rebuildPromptsCache();
    }

    protected function _postDelete()
    {
        $this->getNodePromptRepo()->rebuildPromptsCache();
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_bs_ai_bot_chat_gpt_node_prompt';
        $structure->shortName = 'BS\AIBots:ChatGPTNodePrompt';
        $structure->primaryKey = 'prompt_id';
        $structure->columns = [
            'prompt_id' => ['type' => self::UINT, 'autoIncrement' => true],
            'node_id' => ['type' => self::UINT, 'required' => true],
            'bot_id' => ['type' => self::UINT, 'required' => true],
            'prompt' => ['type' => self::STR, 'default' => ''],
        ];
        $structure->getters = [];
        $structure->relations = [
            'Node' => [
                'entity' => 'XF:Node',
                'type' => self::TO_ONE,
                'conditions' => 'node_id',
                'primary' => true,
            ],
            'Bot' => [
                'entity' => 'BS\AIBots:Bot',
                'type' => self::TO_ONE,
                'conditions' => 'bot_id',
                'primary' => true,
            ],
        ];

        return $structure;
    }

    /**
     * @return \XF\Mvc\Entity\Repository|\BS\AIBots\Repository\ChatGPTNodePrompt
     */
    protected function getNodePromptRepo()
    {
        return $this->repository('BS\AIBots:ChatGPTNodePrompt');
    }
}