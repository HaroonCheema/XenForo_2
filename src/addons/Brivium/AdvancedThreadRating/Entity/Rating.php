<?php
namespace Brivium\AdvancedThreadRating\Entity;

use XF\BbCode\RenderableContentInterface;
use XF\Entity\QuotableInterface;
use XF\Entity\User;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class Rating extends Entity
{
	protected $weightedThreshold = 10;
	protected $weightedAverage = 3;

	public function canView(&$error = null)
	{
		if (!$this->Thread || !$this->Thread->canView($error))
		{
			return false;
		}

		if(!$this->rating_status)
		{
			return $this->Thread->canViewDeleteRating($error);
		}
		return true;
	}

	public function isVisible()
	{
		return ($this->Thread
			&& $this->Thread->discussion_state == 'visible'
		);
	}

	public function canViewAnonymous()
	{
		return (\XF::visitor()->user_id && (\XF::visitor()->user_id == $this->user_id || \XF::visitor()->canBypassUserPrivacy()));
	}

	public function isIgnored()
	{
		return \XF::visitor()->isIgnoring($this->user_id);
	}

	public function canEdit(&$error = null)
	{
		$visitor = \XF::visitor();
		$nodeId = $this->Thread->node_id;
		if($visitor->hasNodePermission($nodeId, 'BRATR_editRated'))
		{
			return true;
		}

		if($visitor->user_id && $this->user_id == $visitor->user_id && $visitor->hasNodePermission($nodeId, 'BRATR_editOwnRated'))
		{
			$editLimit = $visitor->hasNodePermission($nodeId, 'BRATR_timeRatingEdit');
			if ($editLimit != -1 && (!$editLimit || $this->rating_date < \XF::$time - 60 * $editLimit))
			{
				$timeExpired = $this->rating_date + 60 * $editLimit;
				$error = \XF::phraseDeferred('BRATR_the_time_limit_to_edit_this_rating_has_expired_at_x', ['timeExpired' => \XF::language()->dateTime($timeExpired)]);
				return false;
			}
			return true;
		}
		return false;
	}

	public function canDelete($type = 'soft', &$error = null)
	{
		if(!$this->rating_status || $this->encode)
		{
			return false;
		}

		$visitor = \XF::visitor();
		$nodeId = $this->Thread->node_id;

		if ($type == 'hard')
		{
			return $visitor->hasNodePermission($nodeId, 'BRATR_hardDeleteAnyRated');
		}

		if($visitor->hasNodePermission($nodeId, 'BRATR_softDeleteAnyRated'))
		{
			return true;
		}

		if($visitor->user_id && $this->user_id == $visitor->user_id && $visitor->hasNodePermission($nodeId, 'BRATR_softDeleteOwnRated'))
		{
			$editLimit = $visitor->hasNodePermission($nodeId, 'BRATR_timeRatingEdit');
			if ($editLimit != -1 && (!$editLimit || $this->rating_date < \XF::$time - 60 * $editLimit))
			{
				$timeExpired = $this->rating_date + 60 * $editLimit;
				$error = \XF::phraseDeferred('BRATR_the_time_limit_to_edit_this_rating_has_expired_at_x', ['timeExpired' => \XF::language()->dateTime($timeExpired)]);
				return false;
			}
			return true;
		}

		return false;
	}

	public function canUndelete(&$error = null)
	{
		if($this->rating_status || $this->encode)
		{
			return false;
		}

		$visitor = \XF::visitor();
		$nodeId = $this->Thread->node_id;

		if($visitor->hasNodePermission($nodeId, 'BRATR_softDeleteAnyRated') || $visitor->hasNodePermission($nodeId, 'BRATR_hardDeleteAnyRated'))
		{
			return true;
		}

		if($visitor->user_id && $this->user_id == $visitor->user_id && $visitor->hasNodePermission($nodeId, 'BRATR_softDeleteOwnRated'))
		{
			$editLimit = $visitor->hasNodePermission($nodeId, 'BRATR_timeRatingEdit');
			if ($editLimit != -1 && (!$editLimit || $this->rating_date < \XF::$time - 60 * $editLimit))
			{
				$timeExpired = $this->rating_date + 60 * $editLimit;
				$error = \XF::phraseDeferred('BRATR_the_time_limit_to_edit_this_rating_has_expired_at_x', ['timeExpired' => \XF::language()->dateTime($timeExpired)]);
				return false;
			}
			return true;
		}
		return false;
	}

	public function softDelete($reason = '', User $byUser = null)
	{
		if(!$this->rating_status)
		{
			return false;
		}

		$byUser = $byUser ?: \XF::visitor();

		$this->rating_status = 0;

		/** @var \XF\Entity\DeletionLog $deletionLog */
		$deletionLog = $this->getRelationOrDefault('DeletionLog');
		$deletionLog->setFromUser($byUser);
		$deletionLog->delete_reason = $reason;

		$this->save();
		return true;
	}

	public function unDelete()
	{
		if($this->rating_status)
		{
			return false;
		}
		$this->rating_status = 1;
		$this->save();
		return true;
	}

	public function canWarn(&$error = null)
	{
		if($this->warning_id || !$this->user_id)
		{
			return false;
		}

		if($this->User->is_admin || $this->User->is_moderator)
		{
			return false;
		}

		$visitor = \XF::visitor();
		$nodeId = $this->Thread->node_id;
		return $visitor->user_id && $visitor->hasNodePermission($nodeId, 'BRATR_warn');
	}

	public function canLike(&$error = null)
	{
		$visitor = \XF::visitor();
		$nodeId = $this->Thread->node_id;
		if(!$visitor->user_id || !$this->rating_status)
		{
			return false;
		}

		if($visitor->user_id == $this->user_id)
		{
			$error = \XF::phrase('liking_own_content_cheating');
			return false;
		}

		return $visitor->hasNodePermission($nodeId, 'BRATR_canLikeRating');
	}

	public function canReport(&$error = null)
	{
		$visitor = \XF::visitor();
		$nodeId = $this->Thread->node_id;
		return $visitor->user_id && $visitor->hasNodePermission($nodeId, 'BRATR_canReportRating');
	}

	public function canManageRating(&$error = null)
	{
		return \XF::visitor()->hasNodePermission($this->Thread->node_id, 'BRATR_manageRated');
	}

	public function canConfirm(&$error = null)
	{
		if(!$this->waitConfirm())
		{
			return false;
		}


		$visitor = \XF::visitor();
		$nodeId = $this->Thread->node_id;

		return $visitor->hasNodePermission($nodeId, 'BRATR_hardDeleteAnyRated')
			|| $visitor->hasNodePermission($nodeId, 'BRATR_softDeleteAnyRated')
			|| $visitor->hasNodePermission($nodeId, 'BRATR_editRated');
	}

	public function isDelete()
	{
		return (!$this->rating_status && !$this->encode);
	}

	public function waitConfirm()
	{
		return (!$this->rating_status && $this->encode);
	}

	public function isLiked()
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id)
		{
			return false;
		}
		
		return isset($this->Likes[$visitor->user_id]);
	}

	protected function _preSave()
	{
		$encode = $this->get('encode');
		if($this->isUpdate() && $encode && $this->isChanged('rating_status') && $this->rating_status)
		{
			$this->set('encode', '');
		}
	}

	protected function _postSave()
	{
		$this->updateRatingToThread();
		$this->updateRatingToActionUser();
		$this->updateRatingToUserReceive();
		$this->createPost();
		$this->sendNotifications();
		$this->sendEmail();
		$this->removeNotices();
	}

	protected function _postDelete()
	{
		$this->updateRatingToThread(true);
		$this->updateRatingToActionUser(true);
		$this->updateRatingToUserReceive(true);

		$alertRepo = $this->repository('XF:UserAlert');
		$alertRepo->fastDeleteAlertsForContent('brivium_thread_rating', $this->thread_rating_id);

		if (!$this->rating_status == 'deleted' && $this->DeletionLog)
		{
			$this->DeletionLog->delete();
		}
		if ($this->Post)
		{
			$this->Post->delete();
		}
	}

	protected function updateRatingToThread($isDelete = false)
	{
		$thread = $this->Thread;
		if(!$thread || $thread->isDeleted())
		{
			return;
		}

		$ratingSum = $thread->brivium_rating_sum;
		$ratingCount = $thread->brivium_rating_count;
		$reviewCount = $thread->brivium_review_count;

		if ($this->isInsert() && $this->rating_status)
		{
			$ratingSum += $this->rating;
			$ratingCount += 1;
			$reviewCount += $this->message ? 1 : 0;
		}
		elseif ($this->isUpdate())
		{
			if($this->isChanged('rating_status'))
			{
				if($this->rating_status)
				{
					$ratingSum += $this->rating;
					$ratingCount += 1;
					$reviewCount += $this->message ? 1 : 0;
				}else
				{
					$ratingSum -= $this->getExistingValue('rating');
					$ratingCount -= 1;
					$reviewCount -= $this->getExistingValue('message') ? 1 : 0;
				}
			}elseif($this->rating_status)
			{
				if($this->isChanged('message'))
				{
					if(!$this->getExistingValue('message') && $this->message)
					{
						$reviewCount += 1;
					}elseif($this->getExistingValue('message') && !$this->message)
					{
						$reviewCount -= 1;
					}
				}

				if($this->isChanged('rating'))
				{
					$ratingSum += ($this->rating - $this->getExistingValue('rating'));
				}
			}
		}
		elseif ($isDelete && $this->rating_status)
		{
			$ratingSum -= $this->getExistingValue('rating');
			$ratingCount -= 1;
			$reviewCount -= $this->getExistingValue('message') ? 1 : 0;
		}
		else
		{
			return;
		}

		$thread->brivium_rating_sum = max(0, $ratingSum);
		$thread->brivium_rating_count = max(0, $ratingCount);
		$thread->brivium_review_count = max(0, $reviewCount);

		$threshold = $this->weightedThreshold;
		$average = $this->weightedAverage;
		$thread->brivium_rating_weighted = ($threshold * $average + $thread->brivium_rating_sum) / ($threshold + $thread->brivium_rating_count);
		$thread->save();
	}

	protected function updateRatingToUserReceive($isDelete = false)
	{
		if(!$this->Thread)
		{
			return;
		}
		$user = $this->Thread->User;
		if(!$user)
		{
			return;
		}

		$receiveRatings = $user->bratr_receive_ratings;
		$receiveRatingCount = $user->bratr_receive_rating_count;

		if ($this->isInsert() && $this->rating_status)
		{
			$receiveRatings += $this->rating;
			$receiveRatingCount += 1;
		}
		elseif ($this->isUpdate())
		{
			if($this->isChanged('rating_status'))
			{
				if($this->rating_status)
				{
					$receiveRatings += $this->rating;
					$receiveRatingCount += 1;
				}else
				{
					$receiveRatings -= $this->getExistingValue('rating');
					$receiveRatingCount -= 1;
				}
			}elseif($this->rating_status && $this->isChanged('rating'))
			{
				$receiveRatings += ($this->rating - $this->getExistingValue('rating'));
			}
		}
		elseif ($isDelete && $this->rating_status)
		{
			$receiveRatings -= $this->getExistingValue('rating');
			$receiveRatingCount -= 1;
		}
		else
		{
			return;
		}

		$user->bratr_receive_ratings = max(0, $receiveRatings);
		$user->bratr_receive_rating_count = max(0, $receiveRatingCount);
		$user->save();
	}

	protected function updateRatingToActionUser($isDelete = false)
	{
		$user = $this->User;
		if(!$user)
		{
			return false;
		}

		$giveRating = $user->bratr_ratings;
		if ($this->isInsert() && $this->rating_status)
		{
			$giveRating += $this->rating;
		}
		elseif ($this->isUpdate())
		{
			if($this->isChanged('rating_status'))
			{
				if($this->rating_status)
				{
					$giveRating += $this->rating;
				}else
				{
					$giveRating -= $this->getExistingValue('rating');
				}
			}elseif($this->rating_status && $this->isChanged('rating'))
			{
				$giveRating += ($this->rating - $this->getExistingValue('rating'));
			}
		}
		elseif ($isDelete && $this->rating_status)
		{
			$giveRating -= $this->getExistingValue('rating');
		}
		else
		{
			return;
		}

		$user->bratr_ratings = max(0, $giveRating);
		$user->save();
	}

	public function createPost()
	{
		$postToThread = $this->app()->options()->BRARS_postToThread;
		if(empty($postToThread) || empty($postToThread['enabled']))
		{
			return;
		}

		if(!$this->rating_status)
		{
			return;
		}
		if(!$this->isInsert() && !($this->isUpdate() && $this->isChanged('rating_status') && !$this->Post))
		{
			return;
		}

		if($this->User)
		{
			$actionUser = $this->User;
		}else
		{
			$userRepo = $this->repository('XF:User');
			$actionUser = $userRepo->getGuestUser($this->username);
		}

		$thread = $this->Thread;
		$postContent = $this->getPostContent();

		 return \XF::asVisitor($actionUser, function() use ($postContent, $thread)
		{
			$error = $errors = null;
			if (!$thread->canReply($error))
			{
				return;
			}

			$message = \XF\Html\Renderer\BbCode::renderFromHtml($postContent);
			$message =  \XF::cleanString($message);

			/** @var \XF\Service\Thread\Replier $replier */
			$replier = $this->app()->service('XF:Thread\Replier', $thread);
			$replier->setMessage($message);
			$replier->checkForSpam();

			$post = $replier->getPost();

			$bulkSetData = [
				'bratr_star' => $this->rating,
				'thread_rating_id' => $this->thread_rating_id
			];
			if($this->is_anonymous)
			{
				$bulkSetData += [
					'user_id' => 0,
					'username' => \XF::phrase('anonymous')
				];
			}
			$post->bulkSet($bulkSetData);
			if (!$replier->validate($errors))
			{
				return;
			}
			$replier->save();
			
			return true;
		});
	}

	protected function getPostContent()
	{
		$postToThread = $this->app()->options()->BRARS_postToThread;
		if(empty($postToThread['content']))
		{
			return '';
		}

		return str_replace('{message}', $this->message, trim($postToThread['content']));
	}

	public function sendNotifications()
	{
		if(!$this->rating_status || !($this->isInsert() || ($this->isUpdate() && $this->isChanged('encode') && $this->encode == '')))
		{
			return false;
		}

		$finder = $this->finder('XF:ThreadWatch');
		$finder->where('thread_id', $this->thread_id)
			->where('User.user_state', '=', 'valid')
			->where('User.is_banned', '=', 0);

		$activeLimit = $this->app()->options()->watchAlertActiveOnly;
		if (!empty($activeLimit['enabled']))
		{
			$finder->where('User.last_activity', '>=', \XF::$time - 86400 * $activeLimit['days']);
		}
		$finder->with(['User'], true);
		$watches = $finder->fetch();
		if(!$watches->count())
		{
			return false;
		}

		/** @var \XF\Repository\UserAlert $alertRepo */
		$alertRepo = $this->repository('XF:UserAlert');

		foreach($watches as $watch)
		{
			$user = $watch->User;
			$alertRepo->alert(
				$user, $this->user_id, $this->username, 'brivium_thread_rating', $this->thread_rating_id, 'insert'
			);
		}
	}

	public function sendEmail()
	{
		if(!$this->isInsert() || !$this->encode || !$this->email)
		{
			return false;
		}

		$mailer = $this->app()->mailer();

		$mail = $mailer->newMail();
		$mail->setTo($this->email);
		$mail->setTemplate('BRATR_confirmation_thread_rating', [
			'rating' => $this,
			'thread' => $this->Thread
		]);
		$mail->send();
		$this->app()->session()->set('bratr_confirmEmail', $this->email);
	}

	public function removeNotices()
	{
		if($this->isUpdate() && $this->isChanged('encode') && $this->encode == '')
		{
			$this->app()->session()->remove('bratr_confirmEmail');
		}
	}

	public function getUser($isManagement = false)
	{
		$user = $this->User;
		$anonymous = \XF::phrase('anonymous')->render();

		if(!$user)
		{
			$username = $this->username;
			if($isManagement)
			{
				$username =  sprintf('%s (%s)', $username, $this->email);
			}
			if($this->is_anonymous)
			{
				if($isManagement || $this->canViewAnonymous())
				{
					$username =  sprintf('%s (%s - %s)', $username, $this->username, $this->email);
				}else
				{
					$username = $anonymous;
				}
			}

			return $this->repository('XF:User')->getGuestUser($username);
		}
		if(!$this->is_anonymous)
		{
			return $user;
		}
		$user = clone $user;
		if($isManagement || $this->canViewAnonymous())
		{
			$user->username = $anonymous . ' ('.$user->username.')';
		}else
		{
			return $this->repository('XF:User')->getGuestUser($anonymous);
			//$user->username = $anonymous;
		}
		return $user;
	}

	protected function verifyMessage(&$message)
	{
		$message = trim($message);
		$thread = $this->Thread;

		$minimumCharter = $thread->minimumCharter();
		if($minimumCharter < 1)
		{
			return true;
		}

		if(!strlen($message))
		{
			$this->error(\XF::phrase('BRATR_please_provide_review_with_your_rating'), 'message');
			return false;
		}

		if(utf8_strlen($message) < $minimumCharter)
		{
			$this->error(\XF::phrase('BRATR_please_enter_message_with_more_than_x_characters', ['count' => $minimumCharter]), 'message');
			return false;
		}
		return true;
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_brivium_thread_rating';
		$structure->shortName = 'Brivium\AdvancedThreadRating:Rating';
		$structure->contentType = 'brivium_thread_rating';
		$structure->primaryKey = 'thread_rating_id';
		$structure->columns = [
			'thread_rating_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'thread_id' => ['type' => self::UINT, 'required' => true],
			'user_id' => ['type' => self::UINT, 'default' => 0],
			'username' => ['type' => self::STR, 'maxLength' => 50, 'required' => 'please_enter_valid_name'],
			'email' => ['type' => self::STR, 'maxLength' => 200, 'default' => ''],
			'rating' => ['type' => self::UINT, 'default' => 0],
			'rating_date' => ['type' => self::UINT, 'default' => \XF::$time],
			'rating_status' => ['type' => self::BOOL, 'default' => 1],
			'message' => ['type' => self::STR, 'default' => ''],
			'warning_id' => ['type' => self::UINT, 'default' => 0],
			'warning_message' => ['type' => self::STR, 'default' => ''],
			'is_anonymous' => ['type' => self::BOOL, 'default' => 0],
			'encode' => ['type' => self::STR, 'maxLength' => 36, 'default' => ''],
			'likes' => ['type' => self::UINT, 'forced' => true, 'default' => 0],
			'like_users' => ['type' => self::SERIALIZED_ARRAY, 'default' => []],
		];
		$structure->behaviors = [
			'XF:Likeable' => ['stateField' => 'rating_status'],
			'XF:NewsFeedPublishable' => [
				'usernameField' => 'username',
				'dateField' => 'rating_date'
			]
		];
		$structure->relations = [
			'Thread' => [
				'entity' => 'XF:Thread',
				'type' => self::TO_ONE,
				'conditions' => 'thread_id',
				'primary' => true,
				'with' => ['User', 'Forum', 'Forum.Node']
			],
			'Post' => [
				'entity' => 'XF:Post',
				'type' => self::TO_ONE,
				'conditions' => 'thread_rating_id',
				'primary' => true,
			],
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true
			],
			'Likes' => [
				'entity' => 'XF:LikedContent',
				'type' => self::TO_MANY,
				'conditions' => [
					['content_type', '=', 'brivium_thread_rating'],
					['content_id', '=', '$thread_rating_id']
				],
				'key' => 'like_user_id',
				'order' => 'like_date'
			],
			'DeletionLog' => [
				'entity' => 'XF:DeletionLog',
				'type' => self::TO_ONE,
				'conditions' => [
					['content_type', '=', 'brivium_thread_rating'],
					['content_id', '=', '$thread_rating_id']
				],
				'primary' => true
			]
		];
		return $structure;
	}
}