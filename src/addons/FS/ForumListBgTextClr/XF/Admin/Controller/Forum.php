<?php

namespace FS\ForumListBgTextClr\XF\Admin\Controller;

use XF\Mvc\FormAction;
use XF\Entity\AbstractNode;
use XF\Entity\Node;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Forum extends XFCP_Forum
{
    protected function saveTypeData(FormAction $form, Node $node, AbstractNode $data)
    {
        $node->txt_clr = $this->filter('node.txt_clr', 'str');
        $node->bg_clr = $this->filter('node.bg_clr', 'str');
        $node->only_title = $this->filter('node.only_title', 'bool');
        return parent::saveTypeData($form, $node, $data);
    }
}
