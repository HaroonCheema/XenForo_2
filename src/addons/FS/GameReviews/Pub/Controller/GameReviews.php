<?php

namespace FS\GameReviews\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class GameReviews extends AbstractController
{

	public function actionIndex(ParameterBag $params)
	{
		$finder = $this->finder('FS\GameReviews:GameReviews');

		$finder->order('review_id', 'DESC');

		$page = $params->page;
		$perPage = 15;

		$finder->limitByPage($page, $perPage);

		$viewParams = [
			'reviews' => $finder->fetch(),
			'page' => $page,
			'perPage' => $perPage,
			'total' => $finder->total(),
			'totalReturn' => count($finder->fetch()),
		];

		return $this->view('FS\GameReviews:GameReviews\Index', 'fs_game_rating_reviews_all', $viewParams);
	}

	public function actionAdd()
	{
		$visitor = \XF::visitor();

		if (!$visitor->user_id) {

			return $this->noPermission();
		}

		$games = $this->finder('FS\GameReviews:Game')->fetch();

		if ($this->isPost()) {

			$input = $this->filterInputs();

			$insert = $this->finder('FS\GameReviews:GameReviews')->where('user_id', $visitor['user_id'])->where('game_id', $input['game_id'])->fetchOne();

			if (!$insert) {
				$insert = $this->em()->create('FS\GameReviews:GameReviews');
				$insert->game_id = $input['game_id'];
				$insert->user_id = $visitor['user_id'];
			}

			$insert->rating = $input['rating'];
			$insert->message = $input['message'];

			$insert->save();

			$this->saveImage($insert);

			return $this->redirect($this->buildLink('game-rating'));
		}

		$viewParams = [
			"games" => count($games) ? $games : '',
		];

		return $this->view('FS\GameReviews:GameReviews\Add', 'fs_game_rating_add', $viewParams);
	}

	protected function saveImage($rating)
	{
		$uploads['image'] = $this->request->getFile('image', false, false);

		if ($uploads['image']) {
			$uploadService = $this->service('FS\GameReviews:Upload', $rating);

			if (!$uploadService->setImageFromUpload($uploads['image'])) {
				return $this->error($uploadService->getError());
			}

			if (!$uploadService->uploadImage()) {
				return $this->error(\XF::phrase('new_image_could_not_be_processed'));
			}
		}
	}

	protected function filterInputs()
	{
		$input = $this->filter([
			'rating' => 'uint',
			'message' => 'str',
			'game_id' => 'uint',
		]);

		if ($input['rating'] < 1 || $input['rating'] > 5 || !strlen($input['message']) || $input['game_id'] == 0) {
			throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
		}

		return $input;
	}

	public function actionDelete(ParameterBag $params)
	{
		$replyExists = $this->assertDataExists($params->review_id);

		if (!(\XF::visitor()->is_admin || \XF::visitor()->user_id == $replyExists->user_id)) {
			return $this->noPermission();
		}

		/** @var \XF\ControllerPlugin\Delete $plugin */
		$plugin = $this->plugin('XF:Delete');
		return $plugin->actionDelete(
			$replyExists,
			$this->buildLink('game-rating/delete', $replyExists),
			null,
			$this->buildLink('game-rating'),
			"{$replyExists->Game->title}"
		);
	}

	/**
	 * @param string $id
	 * @param array|string|null $with
	 * @param null|string $phraseKey
	 *
	 * @return \FS\GameReviews\Entity\GameReviews
	 */
	protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
	{
		return $this->assertRecordExists('FS\GameReviews:GameReviews', $id, $extraWith, $phraseKey);
	}
}
