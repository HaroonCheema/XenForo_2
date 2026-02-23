<?php

namespace FS\AllStates\XF\Admin\Controller;

use XF\Mvc\ParameterBag;
use XF\Mvc\FormAction;

class Category extends XFCP_Category
{

    protected function nodeSaveProcess(\XF\Entity\Node $node)
    {

        $parent = parent::nodeSaveProcess($node);

        if ($upload = $this->request->getFile('stateIcon', false, false)) {
            $this->repository('FS\AllStates:Node')->setIconFromUpload($node, $upload);
        }

        return $parent;
    }

    public function actionDeleteIcon(ParameterBag $params)
    {
        $node = $this->assertNodeExists($params['node_id']);

        if (!$node->getStateIcon()) {
            return $this->error(\XF::phrase('no_icon_to_delete'));
        }

        if ($this->isPost()) {
            \XF\Util\File::deleteFromAbstractedPath('data://stateIcons/' . $node->node_id . '.jpg');

            return $this->redirect($this->buildLink('categories/edit', $node));
        }

        $viewParams = [
            'node' => $node
        ];

        return $this->view('FS\AllStates:DeleteIcon', 'fs_state_delete_icon', $viewParams);
    }
}
