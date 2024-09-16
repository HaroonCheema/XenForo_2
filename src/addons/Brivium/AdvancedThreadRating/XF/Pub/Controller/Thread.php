<?php
namespace Brivium\AdvancedThreadRating\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{

	public function actionBrRate(ParameterBag $params)
	{
		$visitor = \XF::visitor();
		$thread = $this->assertViewableThread($params->thread_id, ['Watch|' . $visitor->user_id]);

		$error = null;
		if (!$thread->canRating($error))
		{
			return $this->noPermission($error);
		}

		if ($thread->mustRepliedToRating($error))
		{
			return $this->noPermission($error);
		}

		$rating = $this->em()->create('Brivium\AdvancedThreadRating:Rating');

		$inputData = $this->filter([
			'rating' => 'uint',
			'is_anonymous' => 'bool',
			'username' => 'str',
			'email' => 'str',
		]);

		$inputData['thread_id'] = $thread->thread_id;
		$inputData['message'] = $this->plugin('XF:Editor')->fromInput('message');

		$form = $this->formAction();
		if($this->isPost())
		{
			if ($this->filter('no_captcha', 'bool')) // JS is disabled so user hasn't seen Captcha.
			{
				$this->request->set('requires_captcha', true);
				return $this->rerouteController('XF:Thread', 'brRate', $params);
			}
			else if (!$this->captchaIsValid())
			{
				return $this->error(\XF::phrase('did_not_complete_the_captcha_verification_properly'));
			}

			if(!$visitor->user_id)
			{
				// check email
				$validator = $this->app->validator('Email');
				$email = $validator->coerceValue($inputData['email']);
				if (!$validator->isValid($email))
				{
					return $this->error(\XF::phrase('please_enter_valid_email'));
				}

				//check user has email
				$existingUser = $this->finder('XF:User')->where('email', $email)->fetchOne();
				if($existingUser)
				{
					return $this->error(\XF::phrase('BRATR_email_is_already_registered'));
				}

				if($this->app->options()->BRATR_emailConfirmation)
				{
					$inputData['encode'] = \XF::generateRandomString(36);
				}

			}else
			{
				$inputData = [
					'user_id' => $visitor->user_id,
					'username' => $visitor->username,
					'email' => $visitor->email
				] + $inputData;
			}
			$inputData['rating_status'] = empty($inputData['encode']);
			$form->basicEntitySave($rating, $inputData)->run();

			return $this->redirect($this->getDynamicRedirect());
		}
		if(!$thread->minimumCharter() && !$thread->isReviewForm() && $visitor->user_id)
		{
			$inputData = [
				'user_id' => $visitor->user_id,
				'username' => $visitor->username,
				'email' => $visitor->email
			] + $inputData;
			$form->basicEntitySave($rating, $inputData)->run();
			return $this->redirect($this->getDynamicRedirect());
		}

		$rating->bulkSet($inputData);

		$viewParams = [
			'thread' => $thread,
			'rating' => $rating,
		];
		return $this->view('Brivium\AdvancedThreadRating\XF:Thread\Rate', 'BRATR_thread_rate', $viewParams);
	}

	public function actionBrUserRated(ParameterBag $params)
	{
		$thread = $this->assertViewableThread($params->thread_id, ['Forum']);

		$error = null;
		if(!$thread->canViewUserRated($error))
		{
			return $this->noPermission($error);
		}

		$page = $params->page;
		$perPage = $this->app->options()->BRATR_perPage;

		$ratingRepo = $this->repository('Brivium\AdvancedThreadRating:Rating');
		$finder = $ratingRepo->findUserRatedForThreadView($thread)->limitByPage($page, $perPage);


		$ratings = $finder->fetch();
		$total = $finder->total();

		$endOffset = ($page - 1) * $perPage + $ratings->count();

		$viewParams = [
			'thread' => $thread,
			'ratings' => $ratings,

			'total' => $total,
			'page' => max(1, $page),
			'loadMore' => $endOffset < $total,
		];
		return $this->view('Brivium\AdvancedThreadRating\XF:Thread\UserRatedThread', 'BRATR_user_rated_thread', $viewParams);
	}

	public function actionBrReviews(ParameterBag $params)
	{
		$thread = $this->assertViewableThread($params->thread_id, ['Forum']);

		if(!$thread->getBriviumReviewCounter())
		{
			return $this->redirect($this->buildLink('threads', $thread));
		}
		$error = null;
		if(!$thread->isDisplayReviewTab($error))
		{
			return $this->noPermission($error);
		}

		$page = $params->page;
		$perPage = $this->app->options()->BRATR_perPage;

		$ratingRepo = $this->repository('Brivium\AdvancedThreadRating:Rating');
		$finder = $ratingRepo->findReviewsByThread($thread)->limitByPage($page, $perPage);

		$resource = null;

		$addOns = $this->app()->container('addon.cache');

		if($thread->discussion_type == 'resource' && !empty($addOns['XFRM']))
		{
			$resource = $resource = $this->repository('XFRM:ResourceItem')->findResourceForThread($thread)->fetchOne();
			if(!$resource || !$resource->canView())
			{
				$resource = null;
			}
		}

		$ratings = $finder->fetch();
		$total = $finder->total();

		$viewParams = [
			'thread' => $thread,
			'ratings' => $ratings,
			'resource' => $resource,

			'total' => $total,
			'page' => $page,
			'perPage' => $perPage,
			'selected' => 'br-reviews'
		];

		return $this->view('Brivium\AdvancedThreadRating\XF:Thread\Reviews', 'BRATR_thread_reviews', $viewParams);
	}

	public function actionBrResetRating(ParameterBag $params)
	{
		$thread = $this->assertViewableThread($params->thread_id, ['Forum']);
		$error = null;
		if(!$thread->canResetRating($error))
		{
			return $this->noPermission($error);
		}

		if($this->isPost())
		{
			$this->service('Brivium\AdvancedThreadRating:Rating\DeleteRating')->deleteRatingByThread($thread, $this->filter('reason', 'str'));
			return $this->redirect($this->buildLink('threads', $thread));
		}

		$viewParams = [
			'thread' => $thread,
		];
		return $this->view('Brivium\AdvancedThreadRating\XF:Thread\ResetRating', 'BRATR_thread_reset_rating', $viewParams);
	}
}