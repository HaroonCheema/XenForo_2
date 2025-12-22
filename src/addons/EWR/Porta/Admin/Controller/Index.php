<?php

namespace EWR\Porta\Admin\Controller;

use XF\Mvc\ParameterBag;

class Index extends \XF\Admin\Controller\AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission('EWRporta');
	}
	
	public function actionIndex(ParameterBag $params)
	{
		return $this->view('EWR\Porta:Index', 'EWRporta_index');
	}
	
	public function actionPromote(ParameterBag $params)
	{
		if ($this->isPost())
		{
			$threads = \XF::finder('XF:Thread')
				->where('node_id', $this->filter('node_id', 'uint'))
				->fetch();
				
			foreach ($threads AS $thread)
			{
				if (!$thread->PortaArticle)
				{
					$article = $this->em()->create('EWR\Porta:Article');
					$article->thread_id = $thread->thread_id;
					$article->article_date = $thread->post_date;
					$article->save();
				}
			}
			
			return $this->redirect($this->buildLink('ewr-porta/articles'));
		}
		
		$nodeRepo = \XF::repository('XF:Node');
		$nodeTree = $nodeRepo->getNodeOptionsData(true, 'Forum', 'option');
		$nodeTree = array_map(function($v) {
			$v['label'] = \XF::escapeString($v['label']);
			return $v;
		}, $nodeTree);
		
		$viewParams = [
			'nodeTree' => $nodeTree
		];
		return $this->view('EWR\Porta:Index\Promote', 'EWRporta_index_promote', $viewParams);
	}
}