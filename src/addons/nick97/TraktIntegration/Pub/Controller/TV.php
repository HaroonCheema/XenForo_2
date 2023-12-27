<?php

namespace nick97\TraktIntegration\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;
use XF\Util\File;

class TV extends \Snog\TV\Pub\Controller\TV
{
	public function actionSync(ParameterBag $params)
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id) {
			return $this->noPermission();
		}

		$thread = $this->assertViewableThread($params->thread_id);

		if ($this->isPost()) {
			$typeCreator = \XF::service('Snog\TV:Thread\TypeData\TvCreator', $thread, 42525);

			$tvCreator = $typeCreator->getTvCreator();

			$tvId = $thread->TV->tv_id;

			$threadId = $thread->thread_id;

			\xf::db()->delete('xf_snog_tv_thread', 'thread_id = ?', $thread->thread_id);

			\xf::db()->delete('xf_snog_tv_crew', 'tv_id = ?', $tvId);
			\xf::db()->delete('xf_snog_tv_cast', 'tv_id = ?', $tvId);

			$casts = $this->finder('Snog\TV:Cast')->where('tv_id', $tvId)->fetch();

			if (count($casts)) {

				$this->deleteMovies($casts);
			}

			$Crews = $this->finder('Snog\TV:Crew')->where('tv_id', $tvId)->fetch();

			if (count($Crews)) {

				$this->deleteMovies($Crews);
			}

			$Ratings = $this->finder('Snog\TV:Rating')->where('thread_id', $thread->thread_id)->fetch();

			if (count($Ratings)) {

				$this->deleteMovies($Ratings);
			}

			$tvCreator->setTvId($tvId);

			$thread->setOption('tvData', $tvCreator->getTvData());

			$tvCreator->save();

			$movie = $this->finder('Snog\TV:TV')->where('thread_id', 42525)->fetchOne();
			$movie->fastUpdate('thread_id', $threadId);
			$thread->fastUpdate('title', $thread->TV->tv_title);

			return $this->redirect($this->buildLink('threads', $thread));
		} else {
			$viewParams = [
				'thread' => $thread,
			];
			return $this->view('nick97\TraktIntegration:TV\Sync', 'nick97_trakt_tv_sync_confirms', $viewParams);
		}
	}

	public function deleteMovies($datas)
	{
		foreach ($datas as $data) {

			$data->delete();
		}
	}
}
