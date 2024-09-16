<?php
namespace Brivium\AdvancedThreadRating\Widget;

use Brivium\AdvancedThreadRating\Repository\Rating;
use XF\Widget\AbstractWidget;

class NewRatings extends AbstractWidget
{

	protected $defaultOptions = [
		'limit' => 5,
	];

	public function render()
	{
		$visitor = \XF::visitor();

		$options = $this->options;
		$limit = $options['limit'];

		$router = $this->app->router('public');

		/** @var Rating $ratingRepo */
		$ratingRepo = $this->repository('Brivium\AdvancedThreadRating:Rating');
		$ratingFinder = $ratingRepo->findNewRatings();
		$ratingFinder->limit(max($limit * 2, 10));

		$ratings = $ratingFinder->fetch();
		
		$total = $ratings->count();
		$ratings = $ratings->slice(0, $limit, true);

		$link = $router->buildLink('whats-new/thread-ratings', null, ['skip' => 1]);

		$title = \XF::phrase('widget_def.BRATR_newRatings');
		$viewParams = [
			'title' => $this->getTitle()?:$title,
			'link' => $link,
			'ratings' => $ratings,
			'hasMore' => false
		];
		return $this->renderer('BRATR_new_thread_ratings', $viewParams);
	}

	public function verifyOptions(\XF\Http\Request $request, array &$options, &$error = NULL)
	{
		$options = $request->filter([
			'limit' => 'uint',
		]);
		if ($options['limit'] < 1)
		{
			$options['limit'] = 1;
		}
		return true;
	}
}