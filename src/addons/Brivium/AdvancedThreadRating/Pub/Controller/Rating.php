<?php
namespace Brivium\AdvancedThreadRating\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class Rating extends AbstractController
{

	public function actionManagement(ParameterBag $params)
	{
		if(!\XF::visitor()->is_moderator)
		{
			return $this->noPermission();
		}

		$this->session('forum');

		$page = $params->page;
		$perPage = $this->app->options()->BRATR_perPage;

		$ratingRepo = $this->repository('Brivium\AdvancedThreadRating:Rating');
		$finder = $ratingRepo->findAllRatings()->limitByPage($page, $perPage);

		$linkFilters = [];

		if ($username = $this->filter('username', 'str'))
		{
			$finder->where('username', 'like', $finder->escapeLike($username, '%?%'));
			$linkFilters['username'] = $username;
		}

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
			return $this->redirect($this->buildLink('bratr-ratings/management', null, $linkFilters), '');
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
		return $this->view('Brivium\AdvancedThreadRating:\ManagementRatings', 'BRATR_management_ratings', $viewParams);

	}

	public function actionIndex(ParameterBag $params)
	{
		$rating = $this->assertViewableRating($params->thread_rating_id);

		$thread = $rating->Thread;
		$ratingRepo = $this->getRatingRepo();
		$finder = $ratingRepo->findReviewsByThread($thread);

		$countBefore = $finder->where('rating_date', '<=', $rating->rating_date)->fetch()->count();
		$perPage = $this->app->options()->BRATR_perPage;

		$countBefore--;
		$page = floor($countBefore / $perPage) + 1;
		$link = $this->buildLink('threads/br-reviews', $thread, ['page' => $page]) . '#review-' . $rating->thread_rating_id;
		return $this->redirectPermanently($link);
	}

	public function actionShow(ParameterBag $params)
	{
		$rating = $this->assertViewableRating($params->thread_rating_id);

		$viewParams = [
			'rating' => $rating,
			'thread' => $rating->Thread,
			'user' => $rating->getUser(),
		];
		return $this->view('Brivium\AdvancedThreadRating:Rating\Show', 'BRATR_rating_show', $viewParams);
	}

	public function actionEdit(ParameterBag $params)
	{
		$rating = $this->assertViewableRating($params->thread_rating_id);
		$error = null;
		if (!$rating->canEdit($error))
		{
			return $this->noPermission($error);
		}

		$thread = $rating->Thread;

		if ($this->isPost())
		{

			$form = $this->formAction();

			$inputData = $this->filter([
				'rating' => 'uint',
			]);
			$inputData['message'] = $this->plugin('XF:Editor')->fromInput('message');
			$form->basicEntitySave($rating, $inputData)->run();
			return $this->redirect($this->getDynamicRedirect());
		}

		$viewParams = [
			'rating' => $rating,
			'thread' => $thread,
		];
		return $this->view('Brivium\AdvancedThreadRating:Rating\Edit', 'BRATR_rating_edit', $viewParams);
	}

	public function actionDelete(ParameterBag $params)
	{
		$rating = $this->assertViewableRating($params->thread_rating_id);
		$error = null;
		if (!$rating->canDelete('soft', $error))
		{
			return $this->noPermission($error);
		}

		if ($this->isPost())
		{
			$type = $this->filter('hard_delete', 'bool') ? 'hard' : 'soft';
			$reason = $this->filter('reason', 'str');

			if (!$rating->canDelete($type, $error))
			{
				return $this->noPermission($error);
			}

			if($type == 'soft')
			{
				$result = $rating->softDelete($reason);
			}else
			{
				$result = $rating->delete();
			}

			$sendAlert = $this->filter('author_alert', 'bool');
			$alertReason = $this->filter('author_alert_reason', 'str');

			if($result && $sendAlert && $rating->canSendModeratorActionAlert())
			{
				$ratingRepo = $this->getRatingRepo();
				$ratingRepo->sendModeratorActionAlert($rating, 'delete', $alertReason);
			}
			return $this->redirect($this->getDynamicRedirect());
		}
		$thread = $rating->Thread;
		$viewParams = [
			'rating' => $rating,
			'thread' => $thread,
			'user' => $rating->getUser(),
		];
		return $this->view('Brivium\AdvancedThreadRating:Rating\Delete', 'BRATR_rating_delete', $viewParams);
	}

	public function actionUnDelete(ParameterBag $params)
	{
		$rating = $this->assertViewableRating($params->thread_rating_id);
		$error = null;
		if (!$rating->canUndelete($error))
		{
			return $this->noPermission($error);
		}
		$rating->unDelete();
		return $this->redirect($this->getDynamicRedirect());
	}

	public function actionReport(ParameterBag $params)
	{
		$rating = $this->assertViewableRating($params->thread_rating_id);
		if (!$rating->canReport($error))
		{
			return $this->noPermission($error);
		}

		/** @var \XF\ControllerPlugin\Report $reportPlugin */
		$reportPlugin = $this->plugin('XF:Report');
		return $reportPlugin->actionReport(
			'brivium_thread_rating', $rating,
			$this->buildLink('bratr-ratings/report', $rating),
			$this->buildLink('bratr-ratings', $rating)
		);
	}

	public function actionLike(ParameterBag $params)
	{
		$rating = $this->assertViewableRating($params->thread_rating_id);
		if (!$rating->canLike($error))
		{
			return $this->noPermission($error);
		}

		/** @var \XF\ControllerPlugin\Like $likePlugin */
		$likePlugin = $this->plugin('XF:Like');
		return $likePlugin->actionToggleLike(
			$rating,
			$this->buildLink('bratr-ratings/like', $rating),
			$this->buildLink('bratr-ratings', $rating),
			$this->buildLink('bratr-ratings/likes', $rating)
		);
	}

	public function actionLikes(ParameterBag $params)
	{
		$rating = $this->assertViewableRating($params->thread_rating_id);

		$breadcrumbs = $rating->Thread->getBreadcrumbs();
		$title = \XF::phrase('members_who_liked_message_x', ['position' => $rating->thread_rating_id]);

		/** @var \XF\ControllerPlugin\Like $likePlugin */
		$likePlugin = $this->plugin('XF:Like');
		return $likePlugin->actionLikes(
			$rating,
			['bratr-ratings/likes', $rating],
			$title, $breadcrumbs
		);
	}

	public function actionWarn(ParameterBag $params)
	{
		$rating = $this->assertViewableRating($params->thread_rating_id);

		if (!$rating->canWarn($error))
		{
			return $this->noPermission($error);
		}

		$breadcrumbs = $rating->Thread->getBreadcrumbs();

		/** @var \XF\ControllerPlugin\Warn $warnPlugin */
		$warnPlugin = $this->plugin('XF:Warn');
		return $warnPlugin->actionWarn(
			'brivium_thread_rating', $rating,
			$this->buildLink('bratr-ratings/warn', $rating),
			$breadcrumbs
		);
	}

	public function actionConfirm(ParameterBag $params)
	{
		$rating = $this->assertViewableRating($params->thread_rating_id, [], false);
		if($rating->waitConfirm())
		{
			$encode = $this->filter('c', 'str');
			if(empty($encode) && !$rating->canConfirm($error))
			{
				return $this->noPermission($error);
			}elseif(!empty($encode) && $encode != $rating->encode)
			{
				return $this->error(\XF::phrase('BRATR_confirmation_code_wrong'));
			}

			$rating->bulkSet([
				'rating_status' => 1,
				'encode' => ''
			]);
			$rating->save();

			if(!$rating->canView())
			{
				return $this->redirect($this->buildLink('threads', $rating->Thread), \XF::phrase('BRATR_this_rating_had_been_confirmation'));
			}
		}

		$redirect = $this->buildLink($this->buildLink('bratr-ratings', $rating));
		return $this->redirect($this->getDynamicRedirect($redirect));
	}

	protected function assertViewableRating($ratingId, array $extraWith = [], $isCheckView = true)
	{
		$visitor = \XF::visitor();
		$extraWith[] = 'Thread';
		$extraWith[] = 'Thread.Forum';
		$extraWith[] = 'Thread.Forum.Node';
		$extraWith[] = 'Thread.Forum.Node.Permissions|' . $visitor->permission_combination_id;

		/** @var \Brivium\AdvancedThreadRating\Entity\Rating $rating */
		$rating = $this->em()->find('Brivium\AdvancedThreadRating:Rating', $ratingId, $extraWith);
		if (!$rating)
		{
			throw $this->exception($this->notFound(\XF::phrase('BRATR_requested_rating_not_found')));
		}
		$error = null;
		if ($isCheckView && !$rating->canView($error))
		{
			throw $this->exception($this->noPermission($error));
		}

		$this->plugin('XF:Node')->applyNodeContext($rating->Thread->Forum->Node);

		return $rating;
	}

	/**
	 * @return \XF\Repository\Rating
	 */
	protected function getRatingRepo()
	{
		return $this->repository('Brivium\AdvancedThreadRating:Rating');
	}

	public static function getActivityDetails(array $activities)
	{
		return \XF::phrase('viewing_thread');  // no need to be more specific - this is a fairly infrequent event
	}
}