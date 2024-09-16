<?php

namespace SV\MultiPrefix\SV\ConversationEssentials\XF\InlineMod\Conversation;

use SV\ConversationEssentials\XF\Entity\ConversationMaster;
use SV\MultiPrefix\XF\Entity\Forum;
use SV\MultiPrefix\XF\Entity\Thread;
use XF\Http\Request;
use XF\Mvc\Entity\AbstractCollection;

/**
 * Extends \SV\ConversationEssentials\XF\InlineMod\Conversation\CopyToThread
 */
class CopyToThread extends XFCP_CopyToThread
{
    public function renderForm(AbstractCollection $entities, \XF\Mvc\Controller $controller)
    {
        $response = parent::renderForm($entities, $controller);

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

        return $response;
    }

    public function getFormOptions(AbstractCollection $entities, Request $request)
    {
        $input = parent::getFormOptions($entities, $request);
        $input['prefix_id'] = $request->filter('prefix_id', 'array-uint');

        return $input;
    }

    protected function getTargetThreadFromCopierInput(ConversationMaster $conversation, array $input)
    {
        $prefixes = \is_array($input['prefix_id']) ? $input['prefix_id'] : [$input['prefix_id']];
        $input['prefix_id'] = \reset($prefixes);
        /** @var Thread $thread */
        $thread = parent::getTargetThreadFromCopierInput($conversation, $input);
        $thread->sv_prefix_ids = $prefixes;

        return $thread;
    }
}
