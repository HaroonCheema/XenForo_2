<?php

namespace XenBulletins\BrandHub\Entity;

use XF\BbCode\RenderableContentInterface;
use XF\Mvc\Entity\ArrayCollection;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
Use XF\Entity\LinkableInterface;
Use XF\Entity\ReactionTrait;

/**
 * COLUMNS
 * @property int|null post_id
 * @property int owner_page_id
 * @property int user_id
 * @property string username
 * @property int post_date
 * @property string message
 * @property int ip_id
 * @property string message_state
 * @property int attach_count
 * @property int warning_id
 * @property string warning_message
 * @property int comment_count
 * @property int first_comment_date
 * @property int last_comment_date
 * @property array latest_comment_ids
 * @property array|null embed_metadata
 * @property int reaction_score
 * @property array reactions_
 * @property array reaction_users_
 *
 * GETTERS
 * @property array comment_ids
 * @property ArrayCollection|null LatestComments
 * @property mixed Unfurls
 * @property mixed reactions
 * @property mixed reaction_users
 *
 * RELATIONS
 * @property \XenBulletins\BrandHub\Entity\OwnerPage OwnerPage
 * @property \XF\Entity\User User
 * @property \XF\Entity\DeletionLog DeletionLog
 * @property \XF\Entity\ApprovalQueue ApprovalQueue
 * @property \XF\Mvc\Entity\AbstractCollection|\XenBulletins\BrandHub\Entity\OwnerPagePostComment[] Comments
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\Attachment[] Attachments
 * @property \XF\Mvc\Entity\AbstractCollection|\XF\Entity\ReactionContent[] Reactions
 */
class OwnerPagePost extends Entity implements RenderableContentInterface, LinkableInterface
{
	use ReactionTrait;

	public function canView(&$error = null)
	{
		$visitor = \XF::visitor();

		if (!$this->OwnerPage)
		{
			return false;
		}

		if (!$this->OwnerPage->canView($error) || !\XF::visitor()->hasPermission('ownerPagePost', 'view'))
		{
			return false;
		}

		if ($this->message_state == 'moderated')
		{
			if (
				!$visitor->hasPermission('ownerPagePost', 'viewModerated')
				&& (!$visitor->user_id || $visitor->user_id != $this->user_id)
			)
			{
				$error = \XF::phraseDeferred('requested_owner_page_post_not_found');
				return false;
			}
		}
		else if ($this->message_state == 'deleted')
		{
			if (!$visitor->hasPermission('ownerPagePost', 'viewDeleted'))
			{
				$error = \XF::phraseDeferred('requested_owner_page_post_not_found');
				return false;
			}
		}

		return true;
	}

	public function canViewAttachments(&$error = null): bool
	{
		return \XF::visitor()->hasPermission('ownerPagePost', 'viewAttachment');
	}

	public function canUploadAndManageAttachments(): bool
	{
		$ownerPage = $this->OwnerPage;
		if (!$ownerPage)
		{
			return false;
		}
                
                
                $visitor = \XF::visitor();

		return ($visitor->user_id && $visitor->hasPermission('ownerPagePost', 'uploadAttachment'));

//		return $profileUser->canUploadAndManageAttachmentsOnProfile();
	}

	public function canUploadVideos(): bool
	{
		$ownerPage = $this->OwnerPage;
		if (!$ownerPage)
		{
			return false;
		}
                
                $options = $this->app()->options();

		if (empty($options->allowVideoUploads['enabled']))
		{
			return false;
		}

		$visitor = \XF::visitor();

		return ($visitor->user_id && $visitor->hasPermission('ownerPagePost', 'uploadVideo'));

//		return $profileUser->canUploadVideosOnProfile();
	}

	public function canUseInlineModeration(&$error = null)
	{
		$visitor = \XF::visitor();
		return ($visitor->user_id && $visitor->hasPermission('ownerPagePost', 'inlineMod'));
	}

	public function canEdit(&$error = null)
	{
		$visitor = \XF::visitor();

		if (!$visitor->user_id)
		{
			return false;
		}

		if ($visitor->user_id == $this->user_id)
		{
			return $visitor->hasPermission('ownerPagePost', 'editOwn');
		}
		else
		{
			return $visitor->hasPermission('ownerPagePost', 'editAny');
		}
	}

	public function canDelete($type = 'soft', &$error = null)
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id)
		{
			return false;
		}

		if ($type != 'soft' && !$visitor->hasPermission('ownerPagePost', 'hardDeleteAny'))
		{
			return false;
		}

		if ($visitor->hasPermission('ownerPagePost', 'deleteAny'))
		{
			return true;
		}

		return (
			(
				$visitor->user_id == $this->OwnerPage->user_id
				&& $visitor->hasPermission('ownerPagePost', 'manageOwn')
			)
			||
			(
				$visitor->user_id == $this->user_id
				&& $visitor->hasPermission('ownerPagePost', 'deleteOwn')
			)
		);
	}

	public function canUndelete(&$error = null)
	{
		$visitor = \XF::visitor();
		return ($visitor->user_id && $visitor->hasPermission('ownerPagePost', 'undelete'));
	}

	public function canApproveUnapprove(&$error = null)
	{
		$visitor = \XF::visitor();
		return ($visitor->user_id && $visitor->hasPermission('ownerPagePost', 'approveUnapprove'));
	}

	public function canWarn(&$error = null)
	{
		$visitor = \XF::visitor();

		if (!$this->user_id
			|| !$visitor->user_id
			|| $this->user_id == $visitor->user_id
			|| !$visitor->hasPermission('ownerPagePost', 'warn')
		)
		{
			return false;
		}

		if ($this->warning_id)
		{
			$error = \XF::phraseDeferred('user_has_already_been_warned_for_this_content');
			return false;
		}

		return ($this->User && $this->User->isWarnable());
	}

	public function canReport(&$error = null, User $asUser = null)
	{
		$asUser = $asUser ?: \XF::visitor();
		return $asUser->canReport($error);
	}

	public function canReact(&$error = null)
	{
		$visitor = \XF::visitor();
		if (!$visitor->user_id)
		{
			return false;
		}

		if ($this->message_state != 'visible')
		{
			return false;
		}

		if ($this->user_id == $visitor->user_id)
		{
			$error = \XF::phraseDeferred('reacting_to_your_own_content_is_considered_cheating');
			return false;
		}

		return $visitor->hasPermission('ownerPagePost', 'react');
	}

	public function canComment(&$error = null)
	{
		$visitor = \XF::visitor();

		return (
			$this->message_state == 'visible'
				&& $visitor->user_id
				&& $visitor->hasPermission('ownerPagePost', 'view')
				&& $visitor->hasPermission('ownerPagePost', 'comment')
//				&& $this->ProfileUser->isPrivacyCheckMet('allow_post_profile', $visitor)
		);
	}

	public function canAttach(&$error = null)
	{
		$visitor = \XF::visitor();

		return (
			$this->message_state == 'visible'
			&& $visitor->user_id
			&& $visitor->hasPermission('ownerPagePost', 'uploadAttachment')
		);
	}

	public function canViewDeletedComments()
	{
		return \XF::visitor()->hasPermission('ownerPagePost', 'viewDeleted');
	}

	public function canViewModeratedComments()
	{
		return \XF::visitor()->hasPermission('ownerPagePost', 'viewModerated');
	}

	public function canSendModeratorActionAlert()
	{
		$visitor = \XF::visitor();

		if (!$visitor->user_id || $visitor->user_id == $this->user_id)
		{
			return false;
		}

		if ($this->message_state != 'visible')
		{
			return false;
		}

		return (
			$visitor->hasPermission('ownerPagePost', 'deleteAny')
			|| $visitor->hasPermission('ownerPagePost', 'editAny')
		);
	}

	public function hasMoreComments()
	{
		if ($this->comment_count > 3)
		{
			return true;
		}

		$visitor = \XF::visitor();

		$canViewDeleted = $visitor->hasPermission('ownerPagePost', 'viewDeleted');
		$canViewModerated = $visitor->hasPermission('ownerPagePost', 'viewModerated');

		if (!$canViewDeleted && !$canViewModerated)
		{
			return false;
		}

		$viewableCommentCount = 0;

		foreach ($this->latest_comment_ids AS $commentId => $state)
		{
			switch ($state[0])
			{
				case 'visible':
					$viewableCommentCount++;
					break;

				case 'moderated':
					if ($canViewModerated)
					{
						$viewableCommentCount++;
					}
					break;

				case 'deleted':
					if ($canViewDeleted)
					{
						$viewableCommentCount++;
					}
					break;
			}

			if ($viewableCommentCount > 3)
			{
				return true;
			}
		}

		return false;
	}

	public function isVisible()
	{
		return ($this->message_state == 'visible');
	}

	public function isAttachmentEmbedded($attachmentId)
	{
		if (!$this->embed_metadata)
		{
			return false;
		}

		if ($attachmentId instanceof Attachment)
		{
			$attachmentId = $attachmentId->attachment_id;
		}

		return isset($this->embed_metadata['attachments'][$attachmentId]);
	}

	public function isIgnored()
	{
		return \XF::visitor()->isIgnoring($this->user_id);
	}

	public function canCleanSpam()
	{
		return (\XF::visitor()->canCleanSpam() && $this->User && $this->User->isPossibleSpammer());
	}

	/**
	 * @return array
	 */
	public function getCommentIds()
	{
		return $this->db()->fetchAllColumn("
			SELECT post_comment_id
			FROM bh_owner_page_post_comment
			WHERE post_id = ?
			ORDER BY comment_date
		", $this->post_id);
	}

	/**
	 * @return ArrayCollection|null
	 */
	public function getLatestComments()
	{
		$this->repository('XenBulletins\BrandHub:OwnerPagePost')->addCommentsToOwnerPagePosts([$this->post_id => $this]);

		if (isset($this->_getterCache['LatestComments']))
		{
			return $this->_getterCache['LatestComments'];
		}
		else
		{
			return $this->_em->getBasicCollection([]);
		}
	}

	public function setLatestComments(array $latest)
	{
		$this->_getterCache['LatestComments'] = $this->_em->getBasicCollection($latest);
	}

	public function commentAdded(OwnerPagePostComment $comment)
	{
		$this->comment_count++;

		if (!$this->first_comment_date || $comment->comment_date < $this->first_comment_date)
		{
			$this->first_comment_date = $comment->comment_date;
		}

		if ($comment->comment_date > $this->last_comment_date)
		{
			$this->last_comment_date = $comment->comment_date;
		}

		$this->rebuildLatestCommentIds();

		unset($this->_getterCache['comment_ids']);
	}

	public function commentRemoved(OwnerPagePostComment $comment)
	{
		$this->comment_count--;

		if ($this->first_comment_date == $comment->comment_date)
		{
			if (!$this->comment_count)
			{
				$this->first_comment_date = 0;
			}
			else
			{
				$this->rebuildFirstCommentInfo();
			}
		}

		if ($this->last_comment_date == $comment->comment_date)
		{
			if (!$this->comment_count)
			{
				$this->last_comment_date = 0;
			}
			else
			{
				$this->rebuildLastCommentInfo();
			}
		}

		$this->rebuildLatestCommentIds();

		unset($this->_getterCache['comment_ids']);
	}

	public function rebuildCounters()
	{
		if (!$this->rebuildFirstCommentInfo())
		{
			// no visible comments, we know we've set the last comment and count to 0
		}
		else
		{
			$this->rebuildLastCommentInfo();
			$this->rebuildCommentCount();
		}

		// since this contains non-visible comments, we always have to rebuild
		$this->rebuildLatestCommentIds();

		return true;
	}

	public function rebuildFirstCommentInfo()
	{
		$firstComment = $this->db()->fetchRow("
			SELECT post_comment_id, comment_date, user_id, username
			FROM bh_owner_page_post_comment
			WHERE post_id = ?
				AND message_state = 'visible'
			ORDER BY comment_date 
			LIMIT 1
		", $this->post_id);

		if (!$firstComment)
		{
			$this->comment_count = 0;
			$this->first_comment_date = 0;
			$this->last_comment_date = 0;
			return false;
		}
		else
		{
			$this->first_comment_date = $firstComment['comment_date'];
			return true;
		}
	}

	public function rebuildLastCommentInfo()
	{
		$lastComment = $this->db()->fetchRow("
			SELECT post_comment_id, comment_date, user_id, username
			FROM bh_owner_page_post_comment
			WHERE post_id = ?
				AND message_state = 'visible'
			ORDER BY comment_date DESC
			LIMIT 1
		", $this->post_id);

		if (!$lastComment)
		{
			$this->comment_count = 0;
			$this->first_comment_date = 0;
			$this->last_comment_date = 0;
			return false;
		}
		else
		{
			$this->last_comment_date = $lastComment['comment_date'];
			return true;
		}
	}

	public function rebuildCommentCount()
	{
		$visibleComments = $this->db()->fetchOne("
			SELECT COUNT(*)
			FROM bh_owner_page_post_comment
			WHERE post_id = ?
				AND message_state = 'visible'
		", $this->post_id);

		$this->comment_count = $visibleComments;

		return $this->comment_count;
	}

	public function rebuildLatestCommentIds()
	{
		$this->latest_comment_ids = $this->repository('XenBulletins\BrandHub:OwnerPagePost')->getLatestCommentCache($this);
	}

	public function getBbCodeRenderOptions($context, $type)
	{
		return [
			'entity' => $this,
			'user' => $this->User,
			'treatAsStructuredText' => true,
			'attachments' => $this->attach_count ? $this->Attachments : [],
			'viewAttachments' => $this->canViewAttachments(),
			'unfurls' => $this->Unfurls ?: []
		];
	}

	public function getUnfurls()
	{
		return $this->_getterCache['Unfurls'] ?? [];
	}

	public function setUnfurls($unfurls)
	{
		$this->_getterCache['Unfurls'] = $unfurls;
	}

	protected function _postSave()
	{
		$visibilityChange = $this->isStateChanged('message_state', 'visible');
		$approvalChange = $this->isStateChanged('message_state', 'moderated');
		$deletionChange = $this->isStateChanged('message_state', 'deleted');

		if ($this->isUpdate())
		{
			if ($visibilityChange == 'enter')
			{
				$this->ownrPagePostMadeVisible();

				if ($approvalChange)
				{
					$this->submitHamData();
				}
			}
			else if ($visibilityChange == 'leave')
			{
				$this->ownerPagePostHidden();
			}

			if ($deletionChange == 'leave' && $this->DeletionLog)
			{
				$this->DeletionLog->delete();
			}

			if ($approvalChange == 'leave' && $this->ApprovalQueue)
			{
				$this->ApprovalQueue->delete();
			}
		}

		if ($approvalChange == 'enter')
		{
			$approvalQueue = $this->getRelationOrDefault('ApprovalQueue', false);
			$approvalQueue->content_date = $this->post_date;
			$approvalQueue->save();
		}
		else if ($deletionChange == 'enter' && !$this->DeletionLog)
		{
			$delLog = $this->getRelationOrDefault('DeletionLog', false);
			$delLog->setFromVisitor();
			$delLog->save();
		}

		if ($this->isUpdate() && $this->getOption('log_moderator'))
		{
			$this->app()->logger()->logModeratorChanges('bh_ownerPage_post', $this);
		}
	}

	protected function ownrPagePostMadeVisible()
	{
	}

	protected function ownerPagePostHidden($hardDelete = false)
	{
		/** @var \XF\Repository\UserAlert $alertRepo */
		$alertRepo = $this->repository('XF:UserAlert');
		$alertRepo->fastDeleteAlertsForContent('bh_ownerPage_post', $this->post_id);
		$alertRepo->fastDeleteAlertsForContent('bh_ownerPage_post_comment', $this->comment_ids);
	}

	protected function submitHamData()
	{
		/** @var \XF\Spam\ContentChecker $submitter */
		$submitter = $this->app()->container('spam.contentHamSubmitter');
		$submitter->submitHam('bh_ownerPage_post', $this->post_id);
	}

	protected function _postDelete()
	{
		if ($this->message_state == 'visible')
		{
			$this->ownerPagePostHidden(true);
		}

		if ($this->message_state == 'deleted' && $this->DeletionLog)
		{
			$this->DeletionLog->delete();
		}

		if ($this->message_state == 'moderated' && $this->ApprovalQueue)
		{
			$this->ApprovalQueue->delete();
		}

		if ($this->getOption('log_moderator'))
		{
			$this->app()->logger()->logModeratorAction('bh_ownerPage_post', $this, 'delete_hard');
		}

		/** @var \XF\Repository\Attachment $attachRepo */
		$attachRepo = $this->repository('XF:Attachment');
		$attachRepo->fastDeleteContentAttachments('bh_ownerPage_post', $this->post_id);

		$db = $this->db();
		$commentIds = $this->comment_ids;
		if ($commentIds)
		{
			$quotedIds = $db->quote($commentIds);

			$db->delete('bh_owner_page_post_comment', "post_comment_id IN ({$quotedIds})");
			$db->delete('xf_approval_queue', "content_id IN ({$quotedIds}) AND content_type = 'bh_ownerPage_post_comment'");
			$db->delete('xf_deletion_log', "content_id IN ({$quotedIds}) AND content_type = 'bh_ownerPage_post_comment'");
		}
	}

	public function softDelete($reason = '', User $byUser = null)
	{
		$byUser = $byUser ?: \XF::visitor();

		if ($this->message_state == 'deleted')
		{
			return false;
		}

		$this->message_state = 'deleted';

		/** @var \XF\Entity\DeletionLog $deletionLog */
		$deletionLog = $this->getRelationOrDefault('DeletionLog');
		$deletionLog->setFromUser($byUser);
		$deletionLog->delete_reason = $reason;

		$this->save();

		return true;
	}

	public function getNewComment()
	{
		$comment = $this->_em->create('XenBulletins\BrandHub:OwnerPagePostComment');
		$comment->post_id = $this->post_id;

		return $comment;
	}

	public function getNewContentState()
	{
		$visitor = \XF::visitor();

		if ($visitor->user_id && $visitor->hasPermission('ownerPagePost', 'approveUnapprove'))
		{
			return 'visible';
		}

		if (!$visitor->hasPermission('general', 'submitWithoutApproval'))
		{
			return 'moderated';
		}

		return 'visible';
	}

	/**
	 * @param \XF\Api\Result\EntityResult $result
	 * @param int $verbosity
	 * @param array $options
	 *
	 * @api-out str $username
	 * @api-out str $message_parsed HTML parsed version of the message contents.
	 * @api-out bool $can_edit
	 * @api-out bool $can_soft_delete
	 * @api-out bool $can_hard_delete
	 * @api-out bool $can_react
	 * @api-out bool $can_view_attachments
	 * @api-out string $view_url
	 * @api-out User $ProfileUser <cond> If requested by context, the user this profile post was left for.
	 * @api-out Attachment[] $Attachments <cond> Attachments to this profile post, if it has any.
	 * @api-out ProfilePostComment[] $LatestComments <cond> If requested, the most recent comments on this profile post.
	 * @api-see XF\Entity\ReactionTrait::addReactionStateToApiResult
	 */
//	protected function setupApiResultData(
//		\XF\Api\Result\EntityResult $result, $verbosity = self::VERBOSITY_NORMAL, array $options = []
//	)
//	{
//		$result->username = $this->User ? $this->User->username : $this->username;
//
//		if (!empty($options['with_profile']))
//		{
//			$result->includeRelation('ProfileUser');
//		}
//
//		if (!empty($options['with_latest']))
//		{
//			$result->includeGetter('LatestComments');
//		}
//
//		if ($this->attach_count)
//		{
//			// note that we allow viewing of thumbs and metadata, regardless of permissions, when viewing the
//			// content an attachment is connected to
//			$result->includeRelation('Attachments');
//		}
//
//		$result->message_parsed = $this->app()->bbCode()->render($this->message, 'apiHtml', 'profile_post:api', $this);
//
//		$this->addReactionStateToApiResult($result);
//
//		$result->can_edit = $this->canEdit();
//		$result->can_soft_delete = $this->canDelete();
//		$result->can_hard_delete = $this->canDelete('hard');
//		$result->can_react = $this->canReact();
//		$result->can_view_attachments = $this->canViewAttachments();
//
//		$result->view_url = $this->getContentUrl(true);
//	}

	public function getContentUrl(bool $canonical = false, array $extraParams = [], $hash = null)
	{
		$route = $canonical ? 'canonical:owner-page-posts' : 'owner-page-posts';
		return $this->app()->router('public')->buildLink($route, $this, $extraParams, $hash);
	}

	public function getContentPublicRoute()
	{
		return 'owner-page-posts';
	}

	public function getContentTitle(string $context = '')
	{
		return \XF::phrase('owner_page_post_by_x', ['name' => $this->username]);
	}

	public static function getStructure(Structure $structure)
	{
		$structure->table = 'bh_owner_page_post';
		$structure->shortName = 'XenBulletins\BrandHub:OwnerPagePost';
		$structure->contentType = 'bh_ownerPage_post';
		$structure->primaryKey = 'post_id';
		$structure->columns = [
			'post_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'owner_page_id' => ['type' => self::UINT, 'required' => true, 'api' => true],
			'user_id' => ['type' => self::UINT, 'required' => true, 'api' => true],
			'username' => ['type' => self::STR, 'maxLength' => 50,
				'required' => 'please_enter_valid_name'
			],
			'post_date' => ['type' => self::UINT, 'required' => true, 'default' => \XF::$time, 'api' => true],
			'message' => ['type' => self::STR,
				'required' => 'please_enter_valid_message', 'api' => true
			],
			'ip_id' => ['type' => self::UINT, 'default' => 0],
			'message_state' => ['type' => self::STR, 'default' => 'visible',
				'allowedValues' => ['visible', 'moderated', 'deleted'], 'api' => true
			],
			'attach_count' => ['type' => self::UINT, 'max' => 65535, 'forced' => true, 'default' => 0],
			'warning_id' => ['type' => self::UINT, 'default' => 0],
			'warning_message' => ['type' => self::STR, 'default' => '', 'maxLength' => 255, 'api' => true],
			'comment_count' => ['type' => self::UINT, 'forced' => true, 'default' => 0, 'api' => true],
			'first_comment_date' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'last_comment_date' => ['type' => self::UINT, 'default' => 0, 'api' => true],
			'latest_comment_ids' => ['type' => self::JSON_ARRAY, 'default' => []],
			'embed_metadata' => ['type' => self::JSON_ARRAY, 'nullable' => true, 'default' => null]
		];
		$structure->behaviors = [
			'XF:Reactable' => ['stateField' => 'message_state'],
			'XF:ReactableContainer' => [
				'childContentType' => 'bh_ownerPage_post_comment',
				'childIds' => function($profilePost) { return $profilePost->comment_ids; },
				'stateField' => 'message_state'
			],
//			'XF:Indexable' => [
//				'checkForUpdates' => ['message', 'owner_page_id', 'user_id', 'post_date', 'message_state']
//			],
//			'XF:IndexableContainer' => [
//				'childContentType' => 'bh_ownerPage_post_comment',
//				'childIds' => function($profilePost) { return $profilePost->comment_ids; },
//				'checkForUpdates' => ['owner_page_id', 'message_state']
//			],
//			'XF:NewsFeedPublishable' => [
//				'usernameField' => 'username',
//				'dateField' => 'post_date'
//			]
		];
		$structure->getters = [
			'comment_ids' => true,
			'LatestComments' => true,
			'Unfurls' => true,
		];
		$structure->relations = [
//			'ProfileUser' => [
//				'entity' => 'XF:User',
//				'type' => self::TO_ONE,
//				'conditions' => [['user_id', '=', '$profile_user_id']],
//				'primary' => true
//			],
                        'OwnerPage' => [
				'entity' => 'XenBulletins\BrandHub:OwnerPage',
				'type' => self::TO_ONE,
				'conditions' => [['page_id', '=', '$owner_page_id']],
				'primary' => true
			],
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => 'user_id',
				'primary' => true,
				'api' => true
			],
			'DeletionLog' => [
				'entity' => 'XF:DeletionLog',
				'type' => self::TO_ONE,
				'conditions' => [
					['content_type', '=', 'bh_ownerPage_post'],
					['content_id', '=', '$post_id']
				],
				'primary' => true
			],
			'ApprovalQueue' => [
				'entity' => 'XF:ApprovalQueue',
				'type' => self::TO_ONE,
				'conditions' => [
					['content_type', '=', 'bh_ownerPage_post'],
					['content_id', '=', '$post_id'],
				],
				'primary' => true
			],
			'Comments' => [
				'entity' => 'XenBulletins\BrandHub:OwnerPagePostComment',
				'type' => self::TO_MANY,
				'conditions' => 'post_id',
				'primary' => true
			],
			'Attachments' => [
				'entity' => 'XF:Attachment',
				'type' => self::TO_MANY,
				'conditions' => [
					['content_type', '=', 'bh_ownerPage_post'],
					['content_id', '=', '$post_id']
				],
				'with' => 'Data',
				'order' => 'attach_date'
			]
		];
		$structure->options = [
			'log_moderator' => true
		];

		$structure->withAliases = [
			'full' => [
				'User',
				function()
				{
					$userId = \XF::visitor()->user_id;
					if ($userId)
					{
						return 'Reactions|' . $userId;
					}

					return null;
				}
			],
			'fullOwnerPage' => ['full', 'OwnerPage'],
//			'api' => [
//				'User',
//				'User.api',
//				function($withParams)
//				{
//					if (!empty($withParams['profile']))
//					{
//						return ['ProfileUser.api'];
//					}
//				}
//			]
		];

		static::addReactableStructureElements($structure);

		return $structure;
	}
}