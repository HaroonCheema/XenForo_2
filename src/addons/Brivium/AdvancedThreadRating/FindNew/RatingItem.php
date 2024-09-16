<?php
namespace Brivium\AdvancedThreadRating\FindNew;

use Brivium\AdvancedThreadRating\Entity\Rating;
use XF\Entity\FindNew;
use XF\FindNew\AbstractHandler;
use XF\Mvc\Controller;
use XF\Mvc\Entity\Finder;

class RatingItem extends AbstractHandler
{

	public function getRoute()
	{
		return 'whats-new/thread-ratings';
	}

	public function getPageReply(Controller $controller, FindNew $findNew, array $results, $page, $perPage)
	{

		$viewParams = [
			'findNew' => $findNew,

			'page' => $page,
			'perPage' => $perPage,

			'ratings' => $results,
		];
		return $controller->view('Brivium\AdvancedThreadRating:WhatsNew\ThreadRatings', 'BRATR_whats_new_thread_ratings', $viewParams);
	}

	public function getFiltersFromInput(\XF\Http\Request $request)
	{
		$filters = [];

		$visitor = \XF::visitor();
		$followed = $request->filter('followed', 'bool');

		if ($followed && $visitor->user_id)
		{
			$filters['followed'] = true;
		}

		return $filters;
	}

	public function getDefaultFilters()
	{
		return [];
	}

	public function getResultIds(array $filters, $maxResults)
	{
		$ratingFinder = \XF::finder('Brivium\AdvancedThreadRating:Rating')
			->where('rating_status', 1)
			->order('rating_date', 'DESC');

		$this->applyFilters($ratingFinder, $filters);

		$ratings = $ratingFinder->fetch($maxResults);
		$ratings = $this->filterResults($ratings);

		// TODO: consider overfetching or some other permission limits within the query

		return $ratings->keys();
	}

	public function getPageResultsEntities(array $ids)
	{
		$ids = array_map('intval', $ids);

		$ratingFinder = \XF::finder('Brivium\AdvancedThreadRating:Rating')
			->where('thread_rating_id', $ids)
			->with(['User']);
		$userId = \XF::visitor()->user_id;
		if ($userId)
		{
			$ratingFinder->with('Likes|' . $userId);
		}

		return $ratingFinder->fetch();
	}

	protected function filterResults(\XF\Mvc\Entity\ArrayCollection $results)
	{
		$visitor = \XF::visitor();

		return $results->filter(function(Rating $rating) use($visitor)
		{
			return ($rating->canView() && !$visitor->isIgnoring($rating->user_id));
		});
	}

	protected function applyFilters(Finder $ratingFinder, array $filters)
	{
		$visitor = \XF::visitor();

		if (!empty($filters['followed']))
		{
			$following = $visitor->Profile->following;
			$following[] = $visitor->user_id;
			$ratingFinder->where('user_id', $following);
		}
	}

	public function getResultsPerPage()
	{
		return \XF::options()->BRATR_perPage;
	}

	public function isAvailable()
	{
		return true;
	}
}