<?php

namespace  FS\Colour\Admin\Controller;
use XF\Entity\Node;
use XF\Mvc\FormAction;
class Forum extends XFCP_Forum
{
protected function saveTypeData(FormAction $form, Node $node, \XF\Entity\AbstractNode $data)
	{
        $input = $this->filter([
			'node' => [
				'color_title' => 'str',
				'color_code' => 'str'
			],
		]);
        $form->basicEntitySave($node, $input['node']);

parent::saveTypeData($form,$node,$data);

      
    }
}