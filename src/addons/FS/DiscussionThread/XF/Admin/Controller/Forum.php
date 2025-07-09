<?php

namespace FS\DiscussionThread\XF\Admin\Controller;

use XF\Mvc\FormAction;
use XF\Entity\AbstractNode;
use XF\Entity\Node;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Forum extends XFCP_Forum
{
    protected function saveTypeData(FormAction $form, Node $node, AbstractNode $data)
    {
        $node->disc_node_id = $this->filter('node.disc_node_id', 'uint');
        parent::saveTypeData($form, $node, $data);

        // $node = $this->assertNodeExists($data->node_id);
        // $node->fastUpdate('disc_node_id', $this->filter('node.disc_node_id', 'uint'));

        // parent::saveTypeData($form, $node, $data);
        // $node->fastUpdate('disc_node_id', $this->filter('node.disc_node_id', 'uint'));        
        

    }

    // protected function assertNodeExists($id, $with = null, $phraseKey = null)
    // {
    //     return $this->assertRecordExists('XF:Node', $id, $with, $phraseKey);
    // }
}