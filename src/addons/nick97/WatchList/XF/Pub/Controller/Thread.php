<?php

namespace nick97\WatchList\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{

	public function actionWatchList(ParameterBag $params)
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id) {
			return $this->noPermission();
		}

		$thread = $this->assertViewableThread($params->thread_id);

		if ($this->isPost()) {
			if ($this->filter('stop', 'bool')) {
				$thread->fastUpdate('watch_list', 0);
			} else {
				$thread->fastUpdate('watch_list', 1);
			}

			$redirect = $this->redirect($this->buildLink('threads', $thread));
			$redirect->setJsonParam('switchKey', $this->filter('stop', 'bool') ? 'watch' : 'unwatch');
			return $redirect;
		} else {
			$viewParams = [
				'thread' => $thread,
			];
			return $this->view('XF:Thread\WatchList', 'fs_watch_list_thread_watch_list', $viewParams);
		}
	}


	public function actionMyWatchList(ParameterBag $params)
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id) {
			return $this->noPermission();
		}

		$thread = $this->assertViewableThread($params->thread_id);

		if ($this->isPost()) {
			$thread->fastUpdate('watch_list', 0);

			$redirect = $this->redirect($this->buildLink('watch-list/my'));
			return $redirect;
		} else {
			$viewParams = [
				'thread' => $thread,
			];
			return $this->view('XF:Thread\WatchList', 'nick97_trakt_thread_my_watch_list', $viewParams);
		}
	}
}
