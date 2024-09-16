<?php
namespace Brivium\AdvancedThreadRating\XF\Entity;

use XF\Mvc\Entity\Structure;

class Thread extends XFCP_Thread
{

	public function canViewUserRated(&$error = null)
	{
		return \XF::visitor()->hasNodePermission($this->node_id, 'BRATR_viewRateInThread');
	}

	public function canViewDeleteRating(&$error = null)
	{
		$visitor = \XF::visitor();
		$nodeId = $this->node_id;
		if(!$visitor->hasNodePermission($nodeId, 'BRATR_hardDeleteAnyRated') && !$visitor->hasNodePermission($nodeId, 'BRATR_softDeleteAnyRated'))
		{
			return false;
		}
		return true;
	}
	public function isReviewForm(&$error = null)
	{
		return \XF::visitor()->hasNodePermission($this->node_id, 'BRATR_threadReviewForm');
	}

	public function isMessageRequired(&$error = null)
	{
		return $this->isReviewForm($error) && \XF::visitor()->hasNodePermission($this->node_id, 'BRATR_textReviewRequired');
	}

	public function minimumCharter(&$error = null)
	{
		if(!$this->isMessageRequired($error))
		{
			return 0;
		}

		return max(1, \XF::visitor()->hasNodePermission($this->node_id, 'BRATR_reviewMinchar'));
	}

	public function canSendAnonymous(&$error = null)
	{
		return $this->isReviewForm($error) && \XF::visitor()->hasNodePermission($this->node_id, 'BRATR_sendAnonymous');
	}

	public function canDisplayThreadRating(&$error = null)
	{
		if(!$this->brivium_rating_count)
		{
			return false;
		}

		if($this->discussion_type == 'resource' && $this->app()->options()->BRATR_disableResources)
		{
			return false;
		}
		return \XF::visitor()->hasNodePermission($this->node_id, 'BRATR_displayThread');
	}

	public function isDisplayReviewTab(&$error = null)
	{
		if(!$this->getBriviumReviewCounter())
		{
			return false;
		}
		if($this->discussion_type == 'resource' && $this->app()->options()->BRATR_disableResources)
		{
			return false;
		}
		return \XF::visitor()->hasNodePermission($this->node_id, 'BRATR_displayReviewTab');
	}

	public function isRatingInReview(&$error = null)
	{
		return \XF::visitor()->hasNodePermission($this->node_id, 'BRATR_ratingInReview');
	}

	public function canRating(&$error = null)
	{
		if($this->discussion_type == 'resource' && $this->app()->options()->BRATR_disableResources)
		{
			return false;
		}
		$visitor = \XF::visitor();

		if($this->user_id && $this->user_id == $visitor->user_id)
		{
			if(!$visitor->hasNodePermission($this->node_id, 'BRATR_rateOwnThread'))
			{
				return false;
			}
		}elseif(!$visitor->hasNodePermission($this->node_id, 'BRATR_rateThread'))
		{
			return false;
		}
		return !$this->isLimitRated(null, $error);
	}

	public function canResetRating(&$error = null)
	{
		$visitor = \XF::visitor();
		if(!$visitor->user_id || !$this->brivium_rating_count)
		{
			return false;
		}
		return $visitor->hasNodePermission($this->node_id, 'BRATR_canResetThread');
	}

	public function isLimitRated($guestEmail = null, &$error = null)
	{
		$visitor = \XF::visitor();
		$limitRated = $visitor->hasNodePermission($this->node_id, 'BRATR_limitRating');
		if($limitRated < 0)
		{
			return false;
		}

		$limitRated = max(1, $limitRated);
		$ratingRepo = $this->app()->repository('Brivium\AdvancedThreadRating:Rating');

		if(!$visitor->user_id)
		{
			if($guestEmail && $limitRated <= $ratingRepo->countRatedThreadByEmail($guestEmail, $this->thread_id))
			{
				$error = \XF::phrase('BRATR_you_have_already_rated_this_thread');
				return true;
			}
			return false;
		}elseif($limitRated <= $ratingRepo->countUserRatedThread($visitor->user_id, $this->thread_id))
		{
			$error = \XF::phrase('BRATR_you_have_already_rated_this_thread');
			return true;
		}
		return false;
	}

	public function mustRepliedToRating(&$error = null)
	{
		$visitor = \XF::visitor();

		if(!$visitor->user_id || !$visitor->hasNodePermission($this->node_id, 'BRATR_mustReplied'))
		{
			return false;
		}

		$postRepo = $this->app()->repository('XF:Post');
		if($postRepo->countRepliedInThreadByUserId($visitor->user_id, $this->thread_id))
		{
			return false;
		}

		$error = \XF::phrase('BRATR_you_must_replied_to_rating');
		return true;
	}

	protected function _postDelete()
	{
		parent::_postDelete();

		$filters = [
			'thread_id' => $this->thread_id
		];

		$jobManager = $this->app()->jobManager();
		$id = $jobManager->enqueueUnique('BRATR_postDeleteThread', 'Brivium\AdvancedThreadRating:DeleteRating', ['filters' => $filters], true);
		$jobManager->runById($id, \XF::config('jobMaxRunTime'));
	}

	public function getBriviumRatingAvg()
	{
		if(!$this->brivium_rating_count)
		{
			return 0;
		}
		return round($this->brivium_rating_sum / $this->brivium_rating_count, 1);
	}


	public function getBriviumReviewCounter()
	{
		if($this->isRatingInReview())
		{
			return $this->brivium_rating_count;
		}

		return $this->brivium_review_count;
	}

	public static function getStructure(Structure $structure)
	{
		$structure = parent::getStructure($structure);

		$structure->getters += [
			'brivium_rating_avg' => true,
			'brivium_review_counter' => true,
		];
		$structure->columns += [
			'brivium_review_count' => ['type' => self::UINT, 'default' => 0],
			'brivium_rating_count' => ['type' => self::UINT, 'default' => 0],
			'brivium_rating_sum' => ['type' => self::UINT, 'default' => 0],
			'brivium_rating_weighted' => ['type' => self::FLOAT, 'default' => 0],
		];

		return $structure;
	}
}