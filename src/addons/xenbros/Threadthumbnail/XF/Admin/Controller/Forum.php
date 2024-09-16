<?php

namespace xenbros\Threadthumbnail\XF\Admin\Controller;

class Forum extends XFCP_Forum
{
	protected function saveTypeDataNodeiconExtend(\XF\Mvc\FormAction $form, \XF\Entity\Node $node, \XF\Entity\AbstractNode $data)
	{
		$form->setup(function() use ($node)
		{
			$input = $this->filter([
				'node' => [
					'node_attachment_thumb' => 'str',
					'node_thread_thumbnail_height' => 'str',
					'node_thread_thumbnail_width' => 'str',
					'node_default_thread_thumbnail_image' => 'str',
					'node_custom_image_feild' => 'str',
				]
			]);

			$node->node_attachment_thumb = $input['node']['node_attachment_thumb'];
			$node->node_thread_thumbnail_height = $input['node']['node_thread_thumbnail_height'];
			$node->node_thread_thumbnail_width = $input['node']['node_thread_thumbnail_width'];
			$node->node_default_thread_thumbnail_image = $input['node']['node_default_thread_thumbnail_image'];
			$node->node_custom_image_feild = $input['node']['node_custom_image_feild'];
		});
	}

	protected function saveTypeData(\XF\Mvc\FormAction $form, \XF\Entity\Node $node, \XF\Entity\AbstractNode $data)
	{
		parent::saveTypeData($form, $node, $data);
		$this->saveTypeDataNodeiconExtend($form, $node, $data);
	}
}
