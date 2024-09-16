<?php
namespace Brivium\AdvancedThreadRating\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Account extends XFCP_Account
{
	public function actionBratrMyRatings(ParameterBag $params)
	{
		$page = $this->filter('page', 'uint');
		$perPage = $this->app->options()->BRATR_perPage;

		$ratingRepo = $this->repository('Brivium\AdvancedThreadRating:Rating');
		$finder = $ratingRepo->findRatingsByUser()
			->limitByPage($page, $perPage);

		$linkFilters = [];
		if ($start = $this->filter('start', 'datetime'))
		{
			$finder->where('rating_date', '>', $start);
			$linkFilters['start'] = $start;
		}

		if ($end = $this->filter('end', 'datetime'))
		{
			$finder->where('rating_date', '<', $end);
			$linkFilters['end'] = $end;
		}

		if ($linkFilters && $this->isPost())
		{
			return $this->redirect($this->buildLink('account/bratr-my-ratings', null, $linkFilters), '');
		}

		$ratings = $finder->fetch();
		$total = $finder->total();

		$viewParams = [
			'ratings' => $ratings,
			'total' => $total,
			'page' => $page,
			'perPage' => $perPage,

			'linkFilters' => $linkFilters,
			'datePresets' => \XF::language()->getDatePresets(),
		];
		$view = $this->view('Brivium\AdvancedThreadRating\XF:Account\MyRatings', 'BRATR_my_ratings', $viewParams);
		return $this->addAccountWrapperParams($view, 'bratr-my-ratings');
	}
}