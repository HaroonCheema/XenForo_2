<?php

namespace SV\MultiPrefix\XF\Pub\Controller;

use SV\MultiPrefix\XF\Entity\Forum;
use SV\MultiPrefix\XF\Entity\Thread;
use XF\Entity\ConversationMaster;
use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

/**
 * Extends \XF\Pub\Controller\Conversation
 */
class Conversation extends XFCP_Conversation
{
    protected function getTargetThreadFromCopierInput(ConversationMaster $conversation, array $input)
    {
        $prefixes = \is_array($input['prefix_id']) ? $input['prefix_id'] : [$input['prefix_id']];
        $input['prefix_id'] = \reset($prefixes);
        /** @noinspection PhpUndefinedMethodInspection */
        /** @var Thread $thread */
        $thread = parent::getTargetThreadFromCopierInput($conversation, $input);
        $thread->sv_prefix_ids = $prefixes;

        return $thread;
    }

    protected function getConversationCopyInput()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $input = parent::getConversationCopyInput();
        $input['prefix_id'] = $this->filter('prefix_id', 'array-uint');

        return $input;
    }

    public function actionCopyToThread(ParameterBag $parameterBag)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $response = parent::actionCopyToThread($parameterBag);
        if ($response instanceof View)
        {
            /** @var AbstractCollection $nodes */
            $nodes = $response->getParam('nodes');

            /** @var \XF\Entity\Node $lastNode */
            $lastNode = $nodes->first();
            if ($lastNode && $lastNode->Data instanceof \XF\Entity\Forum)
            {
                /** @var Forum $forum */
                $forum = $lastNode->Data;
                $response->setParam('defaultPrefixes', $forum->sv_default_prefix_ids);
            }
        }

        return $response;
    }
}