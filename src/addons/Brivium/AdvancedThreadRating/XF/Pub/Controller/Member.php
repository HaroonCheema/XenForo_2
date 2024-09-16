<?php
namespace Brivium\AdvancedThreadRating\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{

	public function actionBratrRatings(ParameterBag $params)
	{
		$user = $this->assertViewableUser($params->user_id);

		if (!$user->bratr_receive_ratings)
		{
			return $this->noPermission();
		}

		$page = max(1, $params->page);
		$perPage = $this->app->options()->BRATR_perPage;

		$ratingRepo = $this->repository('Brivium\AdvancedThreadRating:Rating');
		$finder = $ratingRepo->findReceiveRatingsByUser($user)
			->limitByPage($page, $perPage);

		$ratings = $finder->fetch();
		$total = $finder->total();

		$endOffset = ($page - 1) * $perPage + $ratings->count();
		
		$viewParams = [
			'user' => $user,
			'ratings' => $ratings,
			'total' => $total,
			'loadMore' => $endOffset < $total,

			'page' => max(1, $page),
		];

		return $this->view('Brivium\AdvancedThreadRating\XF:Member\ReceiveRatings', 'BRATR_receive_ratings', $viewParams);
	}

	public function actionBratrMyRatings(ParameterBag $params)
	{
		$user = \XF::visitor();
		if($params->user_id != $user->user_id)
		{
			return $this->noPermission();
		}
		$page = max(1, $params->page);
		$perPage = $this->app->options()->BRATR_perPage;


		$ratingRepo = $this->repository('Brivium\AdvancedThreadRating:Rating');
		$finder = $ratingRepo->findRatingsByUser($user)
			->limitByPage($page, $perPage);


		$ratings = $finder->fetch();
		$total = $finder->total();

		$endOffset = ($page - 1) * $perPage + $ratings->count();

		$viewParams = [
			'user' => $user,
			'ratings' => $ratings,
			'total' => $total,
			'page' => $page,
			'perPage' => $perPage,
			'loadMore' => $endOffset < $total,
		];
		return $this->view('Brivium\AdvancedThreadRating\XF:Member\MyRatings', 'BRATR_member_my_ratings', $viewParams);
	}
}