<?php

namespace FS\ForumListLayout\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Forum extends XFCP_Forum 
{
	public function actionSort()
	{
            
            $nodeRepo = $this->getNodeRepo();
            $nodeTree = $nodeRepo->createNodeTree($nodeRepo->getCategoryNodeList(null, 'NodeType'));


            if ($this->isPost())
            {   
                $nodeIds = array_column($this->filter('nodes', 'json-array'),'id');

                $visitor = \XF::visitor();
                $visitor->fastUpdate('node_ids',$nodeIds);

                return $this->redirect($this->getDynamicRedirect());
            }
            else
            {
                $viewParams = [
                        'nodeTree' => $nodeTree
                ];
                return $this->view('XF:Node\Sort', 'fs_fll_node_sort', $viewParams);
            }
	}

}
