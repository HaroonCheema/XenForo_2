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

        $app = \xf::app();

        if ($data['count_reactions'] != $forumInput['count_reactions']) {

            $setVal = $forumInput['count_reactions'] ? 1 : 0;

            $app->jobManager()->enqueueUnique('forum_reaction_' . $data['node_id'], 'FS\ExcludeReactionScore:Reaction', ['node_id' => $data['node_id'], 'count_reactions' => $setVal], false);
        }

        $data->fastUpdate('count_reactions', $forumInput['count_reactions']);

        return parent::saveTypeData($form, $node, $data);
    }
}
