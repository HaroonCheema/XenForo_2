<?php

namespace FS\AddFieldForum\XF\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;


class Forum extends XFCP_Forum
{
    protected function saveTypeData(FormAction $form, \XF\Entity\Node $node, \XF\Entity\AbstractNode $data)
    {
        $parent = parent::saveTypeData($form, $node, $data);

        $forumInput = $this->filter([
            'count_reactions' => 'bool',
        ]);

        $data->fastUpdate('count_reactions', $forumInput['count_reactions']);

        return $parent;
    }
}
