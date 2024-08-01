<?php

namespace FS\ExcludeReactionScore\XF\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;


class Forum extends XFCP_Forum
{
    protected function saveTypeData(FormAction $form, \XF\Entity\Node $node, \XF\Entity\AbstractNode $data)
    {
        $forumInput = $this->filter([
            'count_reactions' => 'bool',
        ]);

        if ($data['count_reactions'] != $forumInput['count_reactions']) {

            $threadFinder = \xf::finder('XF:Thread')->where('node_id', $data['node_id']);

            $threadIds = $threadFinder->pluckfrom('thread_id')->fetch()->toArray();

            if (count($threadIds)) {
                $postFinder = \xf::finder('XF:Post')->where('thread_id', $threadIds);

                $postIds = $postFinder->pluckfrom('post_id')->fetch()->toArray();

                if (count($postIds)) {

                    $postIdsStr = implode(", ", $postIds);

                    $setVal = $forumInput['count_reactions'] ? 1 : 0;

                    $db = \xf::db();

                    $db->update(
                        'xf_reaction_content',
                        ['is_counted' => $setVal],
                        "content_id IN ({$postIdsStr})"
                    );

                    \xf::app()->jobManager()->enqueueUnique('reactionChange' . time(), 'XF:ReactionScore');
                }
            }
        }

        return parent::saveTypeData($form, $node, $data);
    }
}
