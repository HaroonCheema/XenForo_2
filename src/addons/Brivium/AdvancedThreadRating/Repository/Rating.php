<?php

namespace Brivium\AdvancedThreadRating\Repository;

use XF\Entity\Thread;
use XF\Entity\User;
use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Rating extends Repository
{

	protected static $userRated = [];

	public function findUserRatedForThreadView(Thread $thread)
	{
		$finder = $this->finder('Brivium\AdvancedThreadRating:Rating');
		$finder->where([
			'thread_id' => $thread->thread_id,
			'rating_status' => 1,
		]);
		$finder->with('User');
		$finder->setDefaultOrder('rating_date', 'DESC');
		return $finder;
	}

	public function findAllRatings(array $with = null)
	{
		if($with === null)
		{
			$visitor = \XF::visitor();
			$with = [
				'Thread', 'Thread.Forum', 'Thread.Forum.Node', 'Thread.Forum.Node.Permissions|' . $visitor->permission_combination_id,
				'User', 'User.Profile', 'User.Privacy',
			];

			if($visitor->user_id)
			{
				$with[] = 'Likes|' . $visitor->user_id;
			}
		}
		$finder = $this->finder('Brivium\AdvancedThreadRating:Rating');
		if(!empty($with))
		{
			$finder->with($with);
		}
		$finder->setDefaultOrder('rating_date', 'DESC');
		return $finder;
	}

	public function findNewRatings()
	{
		$finder = $this->findAllRatings();
		$finder->where('rating_status', 1);
		return $finder;
	}

	public function findReviewsByThread(Thread $thread)
	{
		$finder = $this->finder('Brivium\AdvancedThreadRating:Rating');

		$finder->where([
			'thread_id' => $thread->thread_id
		]);

		if(!$thread->canViewDeleteRating())
		{
			$finder->where([
				'rating_status' => 1,
			]);
		}

		if(!$thread->isRatingInReview())
		{
			$finder->where('message', '<>', null);
			$finder->where('message', '<>', '');
		}

		$finder->with(['User', 'User.Profile', 'User.Privacy']);
		if ($this->app()->options()->showMessageOnlineStatus)
		{
			$finder->with('User.Activity');
		}

		$userId = \XF::visitor()->user_id;
		if ($userId)
		{
			$finder->with('Likes|' . $userId);
		}
		$finder->setDefaultOrder('rating_date', 'DESC');

		return $finder;
	}

	public function findRatingsByUser(User $user = null)
	{
		if(!$user)
		{
			$user = \XF::visitor();
		}
		$finder = $this->finder('Brivium\AdvancedThreadRating:Rating');

		$finder->where([
			'user_id' => $user->user_id,
			'rating_status' => true,
		]);

		$finder->with(['User', 'User.Profile', 'User.Privacy']);
		if ($this->app()->options()->showMessageOnlineStatus)
		{
			$finder->with('User.Activity');
		}

		$userId = \XF::visitor()->user_id;
		if ($userId)
		{
			$finder->with('Likes|' . $userId);
		}
		$finder->setDefaultOrder('rating_date', 'DESC');
		return $finder;
	}

	public function findReceiveRatingsByUser(User $user = null)
	{
		if(!$user)
		{
			$user = \XF::visitor();
		}
		$finder = $this->finder('Brivium\AdvancedThreadRating:Rating');

		$finder->where([
			'Thread.user_id' => $user->user_id,
			'Thread.discussion_state' => 'visible',
			'rating_status' => true,
		]);

		$finder->with(['User', 'User.Profile', 'User.Privacy']);
		if ($this->app()->options()->showMessageOnlineStatus)
		{
			$finder->with('User.Activity');
		}

		$userId = \XF::visitor()->user_id;
		if ($userId)
		{
			$finder->with('Likes|' . $userId);
		}
		$finder->setDefaultOrder('rating_date', 'DESC');
		return $finder;
	}

	public function sendModeratorActionAlert(\Brivium\AdvancedThreadRating\Entity\Rating $rating, $action, $reason = '', array $extra = [])
	{
		if (!$rating->user_id || !$rating->User)
		{
			return false;
		}

		$extra = array_merge([
			'title' => $rating->Thread->title,
			'prefix_id' => $rating->Thread->prefix_id,
			'link' => $this->app()->router('public')->buildLink('nopath:bratr-ratings', $rating),
			'threadLink' => $this->app()->router('public')->buildLink('nopath:threads', $rating->Thread),
			'reason' => $reason
		], $extra);

		/** @var \XF\Repository\UserAlert $alertRepo */
		$alertRepo = $this->repository('XF:UserAlert');
		$alertRepo->alert($rating->User, 0, '', 'user', $rating->user_id, "brivium_thread_rating_{$action}", $extra);
		return true;
	}

	public function countRatedThreadByEmail($email, $threadId)
	{
		return $this->db()->fetchOne('
			SELECT COUNT(*)
			FROM xf_brivium_thread_rating
			WHERE (email = ?) AND (thread_id = ?)
		', [$email, $threadId]);
	}
	public function countUserRatedThread($userId, $threadId)
	{
		if(!isset(self::$userRated[$userId]))
		{
			self::$userRated[$userId] = $this->db()->fetchPairs('
				SELECT thread_id, COUNT(thread_rating_id)
				FROM xf_brivium_thread_rating
				WHERE (user_id = ?)
				GROUP BY thread_id
			', $userId);
		}

		if(!empty(self::$userRated[$userId][$threadId]))
		{
			return self::$userRated[$userId][$threadId];
		}
		return 0;
	}

	protected $weightedThreshold = 10;
	protected $weightedAverage = 3;

	public function rebuildThreads()
	{
		$db = $this->db();

		$db->query('
			UPDATE xf_thread
			LEFT JOIN (
				SELECT rating.thread_id
					, SUM(IF(rating.message <> "" AND rating.message IS NOT NULL, 1, 0)) as review_count
					, count(rating.thread_rating_id) AS rating_count
					, sum(rating.rating) AS rating_sum
				FROM xf_brivium_thread_rating AS rating
				WHERE rating.rating_status = 1
				GROUP BY rating.thread_id
			) AS group_rating ON (group_rating.thread_id = xf_thread.thread_id)
			SET 
				xf_thread.brivium_review_count = IF(group_rating.thread_id IS NULL, 0, group_rating.review_count),
				xf_thread.brivium_rating_count = IF(group_rating.thread_id IS NULL, 0, group_rating.rating_count),
				xf_thread.brivium_rating_sum = IF(group_rating.thread_id IS NULL, 0, group_rating.rating_sum),
				xf_thread.brivium_rating_weighted = IF(group_rating.thread_id IS NULL, 0, (?*?+group_rating.rating_sum)/(?+group_rating.rating_count))
		', [$this->weightedThreshold, $this->weightedAverage, $this->weightedThreshold]);
	}

	public function rebuildReceivers()
	{
		$db = $this->db();
		$db->query('
			UPDATE xf_user
			LEFT JOIN (
				SELECT thread.user_id as receive_user_id
					, count(rating.thread_rating_id) AS rating_count
					, SUM(rating.rating) as total_rating
				FROM xf_brivium_thread_rating AS rating
				INNER JOIN xf_thread AS thread ON
					(thread.thread_id = rating.thread_id)
				WHERE (rating.rating_status = 1) AND (thread.user_id > 0)
				GROUP BY thread.user_id
			) AS group_rating ON (group_rating.receive_user_id = xf_user.user_id)
			SET
				xf_user.bratr_receive_rating_count = IF(group_rating.receive_user_id IS NULL, 0, group_rating.rating_count),
				xf_user.bratr_receive_ratings = IF(group_rating.receive_user_id IS NULL, 0, group_rating.total_rating)
		');
	}

	public function rebuildGivers()
	{
		$db = $this->db();
		$db->query('
			UPDATE xf_user
			LEFT JOIN (
				SELECT rating.user_id as giver_user_id
					, SUM(rating.rating) as total_rating
				FROM xf_brivium_thread_rating AS rating
				WHERE (rating.rating_status = 1) AND (rating.user_id > 0)
				GROUP BY rating.user_id
			) AS group_rating ON (group_rating.giver_user_id = xf_user.user_id)
			SET
				xf_user.bratr_ratings = IF(group_rating.giver_user_id IS NULL, 0, group_rating.total_rating)
		');
	}
}