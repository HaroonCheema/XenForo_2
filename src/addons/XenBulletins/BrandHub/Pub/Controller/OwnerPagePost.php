<?php

namespace XenBulletins\BrandHub\Pub\Controller;

use XF\Pub\Controller\AbstractController;
use XF\Mvc\ParameterBag;
use XF\Mvc\RouteMatch;

//                \XenBulletins\BrandHub\Service\OwnerPagePost\Creator

class OwnerPagePost extends AbstractController
{
	public function actionIndex(ParameterBag $params)
	{
		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);

		if ($this->filter('_xfWithData', 'bool'))
		{
			$this->request->set('_xfDisableInlineMod', true);
			return $this->rerouteController(__CLASS__, 'show', $params);
		}

		$ownerPagePostRepo = $this->getOwnerPagePostRepo();

		$ownerPagePostFinder = $ownerPagePostRepo->findOwnerPagePostsOnOwnerPage($ownerPagePost->OwnerPage);
		$ownerPagePostsTotal = $ownerPagePostFinder->where('post_date', '>', $ownerPagePost->post_date)->total();

		$page = floor($ownerPagePostsTotal / $this->options()->messagesPerPage) + 1;

		return $this->redirectPermanently(
			$this->buildLink('owners', $ownerPagePost->OwnerPage, ['page' => $page]) . '#profile-post-' . $ownerPagePost->post_id
		);
	}

	public function actionShow(ParameterBag $params)
	{
		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);

		$ownerPagePostRepo = $this->getOwnerPagePostRepo();
		$ownerPagePost = $ownerPagePostRepo->addCommentsToOwnerPagePost($ownerPagePost);

		/** @var \XF\Repository\Attachment $attachmentRepo */
		$attachmentRepo = $this->repository('XF:Attachment');
		$attachmentRepo->addAttachmentsToContent([$ownerPagePost->post_id => $ownerPagePost], 'bh_ownerPage_post');

		if ($ownerPagePost->canUploadAndManageAttachments())
		{
			$ownerPagePostAttachData = [$ownerPagePost->post_id => $attachmentRepo->getEditorData('bh_ownerPage_post_comment', $ownerPagePost)];
		}

		$viewParams = [
			'profilePost' => $ownerPagePost,
			'showTargetUser' => true,
			'canInlineMod' => $ownerPagePost->canUseInlineModeration(),
			'allowInlineMod' => !$this->request->get('_xfDisableInlineMod'),
			'profilePostAttachData' => $ownerPagePostAttachData ?? []
		];
		return $this->view('XenBulletins\BrandHub:OwnerPagePost\Show', 'bh_owner_page_post', $viewParams);
	}

	public function actionEdit(ParameterBag $params)
	{
		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);
		if (!$ownerPagePost->canEdit($error))
		{
			return $this->noPermission($error);
		}

		$noInlineMod = $this->filter('_xfNoInlineMod', 'bool');

		if ($this->isPost())
		{
			$editor = $this->setupEdit($ownerPagePost);
			$editor->checkForSpam();

			if (!$editor->validate($errors))
			{
				return $this->error($errors);
			}
			$editor->save();

			$this->finalizeEdit($editor);

			if ($this->filter('_xfWithData', 'bool') && $this->filter('_xfInlineEdit', 'bool'))
			{
				$ownerPagePosts = [$ownerPagePost->post_id => $ownerPagePost];

				/** @var \XF\Repository\Attachment $attachmentRepo */
				$attachmentRepo = $this->repository('XF:Attachment');
				$attachmentRepo->addAttachmentsToContent($ownerPagePosts, 'bh_ownerPage_post');

				if ($ownerPagePost->canUploadAndManageAttachments())
				{
					$attachmentData = $attachmentRepo->getEditorData('bh_ownerPage_post_comment', $ownerPagePost);
				}
				else
				{
					$attachmentData = null;
				}

				$viewParams = [
					'profilePost' => $ownerPagePost,

					'noInlineMod' => $noInlineMod,

					'attachmentData' => $attachmentData,
				];
				$reply = $this->view('XF:ProfilePost\EditNewProfilePost', 'bh_owner_page_post_edit_new_post', $viewParams);
				$reply->setJsonParam('message', \XF::phrase('your_changes_have_been_saved'));
				return $reply;
			}
			else
			{
				return $this->redirect($this->buildLink('owner-page-posts', $ownerPagePost));
			}
		}
		else
		{
			if ($ownerPagePost->OwnerPage->canUploadAndManageAttachmentsOnOwnerPage())
			{
				/** @var \XF\Repository\Attachment $attachmentRepo */
				$attachmentRepo = $this->repository('XF:Attachment');
				$attachmentData = $attachmentRepo->getEditorData('bh_ownerPage_post', $ownerPagePost);
			}
			else
			{
				$attachmentData = null;
			}

			$viewParams = [
				'profilePost' => $ownerPagePost,
				'ownerPage' => $ownerPagePost->OwnerPage,

				'quickEdit' => $this->filter('_xfWithData', 'bool'),
				'noInlineMod' => $noInlineMod,

				'attachmentData' => $attachmentData,
			];
                        
			return $this->view('XF:ProfilePost\Edit', 'bh_owner_page_post_edit', $viewParams);
		}
	}

	public function actionDelete(ParameterBag $params)
	{
		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);
		if (!$ownerPagePost->canDelete('soft', $error))
		{
			return $this->noPermission($error);
		}

		if ($this->isPost())
		{
			$type = $this->filter('hard_delete', 'bool') ? 'hard' : 'soft';
			$reason = $this->filter('reason', 'str');

			if (!$ownerPagePost->canDelete($type, $error))
			{
				return $this->noPermission($error);
			}

			/** @var \XenBulletins\BrandHub\Service\OwnerPagePost\Deleter $deleter */
			$deleter = $this->service('XenBulletins\BrandHub:OwnerPagePost\Deleter', $ownerPagePost);

			if ($this->filter('author_alert', 'bool') && $ownerPagePost->canSendModeratorActionAlert())
			{
				$deleter->setSendAlert(true, $this->filter('author_alert_reason', 'str'));
			}

			$deleter->delete($type, $reason);

			$this->plugin('XF:InlineMod')->clearIdFromCookie('bh_ownerPage_post', $ownerPagePost->post_id);

			return $this->redirect(
				$this->getDynamicRedirect($this->buildLink('owners', $ownerPagePost->OwnerPage), false)
			);
		}
		else
		{
			$viewParams = [
				'profilePost' => $ownerPagePost,
				'ownerPage' => $ownerPagePost->OwnerPage
			];
			return $this->view('XF:ProfilePost\Delete', 'bh_owner_page_post_delete', $viewParams);
		}
	}

	public function actionUndelete(ParameterBag $params)
	{
		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);

		/** @var \XF\ControllerPlugin\Undelete $plugin */
		$plugin = $this->plugin('XF:Undelete');
		return $plugin->actionUndelete(
			$ownerPagePost,
			$this->buildLink('owner-page-posts/undelete', $ownerPagePost),
			$this->buildLink('owner-page-posts', $ownerPagePost),
			\XF::phrase('owner_page_post_by_x', ['name' => $ownerPagePost->username]),
			'message_state'
		);
	}

	public function actionIp(ParameterBag $params)
	{
		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);
		$breadcrumbs = $this->getOwnerPagePostBreadcrumbs($ownerPagePost);

		/** @var \XF\ControllerPlugin\Ip $ipPlugin */
		$ipPlugin = $this->plugin('XF:Ip');
		return $ipPlugin->actionIp($ownerPagePost, $breadcrumbs);
	}

	public function actionReport(ParameterBag $params)
	{
		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);
		if (!$ownerPagePost->canReport($error))
		{
			return $this->noPermission($error);
		}

		/** @var \XF\ControllerPlugin\Report $reportPlugin */
		$reportPlugin = $this->plugin('XF:Report');
		return $reportPlugin->actionReport(
			'bh_ownerPage_post', $ownerPagePost,
			$this->buildLink('owner-page-posts/report', $ownerPagePost),
			$this->buildLink('owner-page-posts', $ownerPagePost)
		);
	}

	public function actionReact(ParameterBag $params)
	{
		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);

		/** @var \XF\ControllerPlugin\Reaction $reactionPlugin */
		$reactionPlugin = $this->plugin('XF:Reaction');
		return $reactionPlugin->actionReactSimple($ownerPagePost, 'owner-page-posts');
	}

	public function actionReactions(ParameterBag $params)
	{
		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);

		$breadcrumbs = $this->getOwnerPagePostBreadcrumbs($ownerPagePost);

		/** @var \XF\ControllerPlugin\Reaction $reactionPlugin */
		$reactionPlugin = $this->plugin('XF:Reaction');
		return $reactionPlugin->actionReactions(
			$ownerPagePost,
			'owner-page-posts/reactions',
			null, $breadcrumbs
		);
	}

	public function actionWarn(ParameterBag $params)
	{
		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);

		if (!$ownerPagePost->canWarn($error))
		{
			return $this->noPermission($error);
		}

		$breadcrumbs = $this->getOwnerPagePostBreadcrumbs($ownerPagePost);

		/** @var \XF\ControllerPlugin\Warn $warnPlugin */
		$warnPlugin = $this->plugin('XF:Warn');
		return $warnPlugin->actionWarn(
			'bh_ownerPage_post', $ownerPagePost,
			$this->buildLink('owner-page-posts/warn', $ownerPagePost),
			$breadcrumbs
		);
	}

	/**
	 * @param \XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost
	 *
	 * @return \XenBulletins\BrandHub\Service\OwnerPagePostComment\Creator
	 */
	protected function setupOwnerPagePostComment(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost)
	{
		$message = $this->plugin('XF:Editor')->fromInput('message');

		/** @var \XenBulletins\BrandHub\Service\OwnerPagePostComment\Creator $creator */
		$creator = $this->service('XenBulletins\BrandHub:OwnerPagePostComment\Creator', $ownerPagePost);
		$creator->setContent($message);

		if ($ownerPagePost->canUploadAndManageAttachments())
		{
			$creator->setAttachmentHash($this->filter('attachment_hash', 'str'));
		}

		return $creator;
	}

	protected function finalizeOwnerPagePostComment(\XenBulletins\BrandHub\Service\OwnerPagePostComment\Creator $creator)
	{
		$creator->sendNotifications();
	}

	public function actionAddComment(ParameterBag $params)
	{
		$this->assertPostOnly();

		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);
		if (!$ownerPagePost->canComment($error))
		{
			return $this->noPermission($error);
		}

		$creator = $this->setupOwnerPagePostComment($ownerPagePost);
		$creator->checkForSpam();

		if (!$creator->validate($errors))
		{
			return $this->error($errors);
		}
		$this->assertNotFlooding('post');
		$comment = $creator->save();

		$this->finalizeOwnerPagePostComment($creator);

		if ($this->filter('_xfWithData', 'bool') && $this->request->exists('last_date') && $ownerPagePost->canView())
		{
			$ownerPagePostRepo = $this->getOwnerPagePostRepo();

			$lastDate = $this->filter('last_date', 'uint');

			/** @var \XF\Mvc\Entity\Finder $ownerPagePostCommentList */
			$ownerPagePostCommentList = $ownerPagePostRepo->findNewestCommentsForOwnerPagePost($ownerPagePost, $lastDate);
			$ownerPagePostComments = $ownerPagePostCommentList->fetch();

			// put the posts into oldest-first order
			$ownerPagePostComments = $ownerPagePostComments->reverse(true);

			$viewParams = [
				'profilePost' => $ownerPagePost,
				'profilePostComments' => $ownerPagePostComments
			];
			$view = $this->view('XF:Member\NewProfilePostComments', 'bh_owner_page_post_new_owner_page_post_comments', $viewParams);
			$view->setJsonParam('lastDate', $ownerPagePostComments->last()->comment_date);
			return $view;
		}
		else
		{
			return $this->redirect($this->buildLink('owner-page-posts/comments', $comment));
		}
	}

	public function actionLoadPrevious(ParameterBag $params)
	{
		$ownerPagePost = $this->assertViewableOwnerPagePost($params->post_id);

		$repo = $this->getOwnerPagePostRepo();

		$comments = $repo->findOwnerPagePostComments($ownerPagePost)
			->with('full')
			->where('comment_date', '<', $this->filter('before', 'uint'))
			->order('comment_date', 'DESC')
			->limit(20)
			->fetch()
			->reverse();

		if ($comments->count())
		{
			$firstCommentDate = $comments->first()->comment_date;

			$moreCommentsFinder = $repo->findOwnerPagePostComments($ownerPagePost)
				->where('comment_date', '<', $firstCommentDate);

			$loadMore = ($moreCommentsFinder->total() > 0);
		}
		else
		{
			$firstCommentDate = 0;
			$loadMore = false;
		}

		$viewParams = [
			'profilePost' => $ownerPagePost,
			'comments' => $comments,
			'firstCommentDate' => $firstCommentDate,
			'loadMore' => $loadMore
		];
		return $this->view('XF:ProfilePost\LoadPrevious', 'bh_owner_page_post_comments', $viewParams);
	}

	public function actionComments(ParameterBag $params)
	{
		$comment = $this->assertViewableComment($params->post_comment_id);
		$ownerPagePost = $this->assertViewableOwnerPagePost($comment->post_id);

		$ownerPagePostRepo = $this->getOwnerPagePostRepo();

		$ownerPagePostFinder = $ownerPagePostRepo->findOwnerPagePostsOnOwnerPage($ownerPagePost->OwnerPage);
		$ownerPagePostTotal = $ownerPagePostFinder->where('post_date', '>', $ownerPagePost->post_date)->total();

		$page = floor($ownerPagePostTotal / $this->options()->messagesPerPage) + 1;

		$commentId = $comment->post_comment_id;
		$anchor = '#profile-post-comment-' . $commentId;
		if (!isset($ownerPagePost->latest_comment_ids[$commentId]))
		{
			$anchor = '#profile-post-' . $ownerPagePost->post_id;
		}

		return $this->redirectPermanently(
			$this->buildLink('owners', $ownerPagePost->OwnerPage, ['page' => $page]) . $anchor
		);
	}

	public function actionCommentsShow(ParameterBag $params)
	{
		$comment = $this->assertViewableComment($params->post_comment_id);

		$viewParams = [
			'comment' => $comment,
			'profilePost' => $comment->OwnerPagePost,
		];
		return $this->view('XF:ProfilePost\Comments\Show', 'bh_owner_page_post_comment', $viewParams);
	}

	public function actionCommentsEdit(ParameterBag $params)
	{
		$comment = $this->assertViewableComment($params->post_comment_id);
		if (!$comment->canEdit($error))
		{
			return $this->noPermission($error);
		}

		/** @var \XF\Repository\Attachment $attachmentRepo */
		$attachmentRepo = $this->repository('XF:Attachment');

		if ($this->isPost())
		{
			$editor = $this->setupCommentEdit($comment);
			$editor->checkForSpam();

			if (!$editor->validate($errors))
			{
				return $this->error($errors);
			}
			$editor->save();

			$this->finalizeCommentEdit($editor);

			if ($this->filter('_xfWithData', 'bool') && $this->filter('_xfInlineEdit', 'bool'))
			{


				$viewParams = [
					'profilePost' => $comment->OwnerPagePost,
					'comment' => $comment
				];
				$reply = $this->view('XF:ProfilePost\Comments\EditNewComment', 'bh_owner_page_post_comment_edit_new_comment', $viewParams);
				$reply->setJsonParam('message', \XF::phrase('your_changes_have_been_saved'));
				return $reply;
			}
			else
			{
				return $this->redirect($this->buildLink('owner-page-posts/comments', $comment));
			}
		}
		else
		{
			$ownerPagePost = $comment->OwnerPagePost;

			if ($ownerPagePost->canUploadAndManageAttachments())
			{
				$attachmentData = $attachmentRepo->getEditorData('bh_ownerPage_post_comment', $comment);
			}
			else
			{
				$attachmentData = null;
			}

			$viewParams = [
				'comment' => $comment,
				'profilePost' => $ownerPagePost,
				'quickEdit' => $this->responseType() == 'json',
				'attachmentData' => $attachmentData
			];
			return $this->view('XF:ProfilePost\Comments\Edit', 'bh_owner_page_post_comment_edit', $viewParams);
		}
	}

	public function actionCommentsDelete(ParameterBag $params)
	{
		$comment = $this->assertViewableComment($params->post_comment_id);
		if (!$comment->canDelete('soft', $error))
		{
			return $this->noPermission($error);
		}

		if ($this->isPost())
		{
			$type = $this->filter('hard_delete', 'bool') ? 'hard' : 'soft';
			$reason = $this->filter('reason', 'str');

			if (!$comment->canDelete($type, $error))
			{
				return $this->noPermission($error);
			}
                        
			/** @var \XenBulletins\BrandHub\Service\OwnerPagePostComment\Deleter $deleter */
			$deleter = $this->service('XenBulletins\BrandHub:OwnerPagePostComment\Deleter', $comment);

			if ($this->filter('author_alert', 'bool') && $comment->canSendModeratorActionAlert())
			{
				$deleter->setSendAlert(true, $this->filter('author_alert_reason', 'str'));
			}

			$deleter->delete($type, $reason);

			return $this->redirect(
				$this->getDynamicRedirect($this->buildLink('owner-page-posts', $comment), false)
			);
		}
		else
		{
			$viewParams = [
				'comment' => $comment,
				'profilePost' => $comment->OwnerPagePost
			];
			return $this->view('XF:ProfilePost\Comments\Delete', 'bh_owner_page_post_comment_delete', $viewParams);
		}
	}

	public function actionCommentsUndelete(ParameterBag $params)
	{
		$comment = $this->assertViewableComment($params->post_comment_id);

		/** @var \XF\ControllerPlugin\Undelete $plugin */
		$plugin = $this->plugin('XF:Undelete');
		return $plugin->actionUndelete(
			$comment,
			$this->buildLink('owner-page-posts/comments/undelete', $comment),
			$this->buildLink('owner-page-posts/comments', $comment),
			\XF::phrase('owner_page_post_comment_by_x', ['username' => $comment->username]),
			'message_state'
		);
	}

	public function actionCommentsApprove(ParameterBag $params)
	{
		$this->assertValidCsrfToken($this->filter('t', 'str'));

		$comment = $this->assertViewableComment($params->post_comment_id);
		if (!$comment->canApproveUnapprove($error))
		{
			return $this->noPermission($error);
		}

		/** @var \XenBulletins\BrandHub\Service\OwnerPagePostComment\Approver $approver */
		$approver = \XF::service('XenBulletins\BrandHub:OwnerPagePostComment\Approver', $comment);
		$approver->approve();

		return $this->redirect($this->buildLink('owner-page-posts/comments', $comment));
	}

	public function actionCommentsUnapprove(ParameterBag $params)
	{
		$this->assertValidCsrfToken($this->filter('t', 'str'));

		$comment = $this->assertViewableComment($params->post_comment_id);
		if (!$comment->canApproveUnapprove($error))
		{
			return $this->noPermission($error);
		}

		$comment->message_state = 'moderated';
		$comment->save();

		return $this->redirect($this->buildLink('owner-page-posts/comments', $comment));
	}

	public function actionCommentsWarn(ParameterBag $params)
	{
		$comment = $this->assertViewableComment($params->post_comment_id);
		if (!$comment->canWarn($error))
		{
			return $this->noPermission($error);
		}

		$breadcrumbs = $this->getOwnerPagePostBreadcrumbs($comment->OwnerPagePost);

		/** @var \XF\ControllerPlugin\Warn $warnPlugin */
		$warnPlugin = $this->plugin('XF:Warn');
		return $warnPlugin->actionWarn(
			'bh_ownerPage_post_comment', $comment,
			$this->buildLink('owner-page-posts/comments/warn', $comment),
			$breadcrumbs
		);
	}

	public function actionCommentsIp(ParameterBag $params)
	{
		$comment = $this->assertViewableComment($params->post_comment_id);
		$breadcrumbs = $this->getOwnerPagePostBreadcrumbs($comment->OwnerPagePost);

		/** @var \XF\ControllerPlugin\Ip $ipPlugin */
		$ipPlugin = $this->plugin('XF:Ip');
		return $ipPlugin->actionIp($comment, $breadcrumbs);
	}

	public function actionCommentsReport(ParameterBag $params)
	{
		$comment = $this->assertViewableComment($params->post_comment_id);
		if (!$comment->canReport($error))
		{
			return $this->noPermission($error);
		}

		/** @var \XF\ControllerPlugin\Report $reportPlugin */
		$reportPlugin = $this->plugin('XF:Report');
		return $reportPlugin->actionReport(
			'bh_ownerPage_post_comment', $comment,
			$this->buildLink('owner-page-posts/comments/report', $comment),
			$this->buildLink('owner-page-posts/comments', $comment)
		);
	}

	public function actionCommentsReact(ParameterBag $params)
	{
		$comment = $this->assertViewableComment($params->post_comment_id);

		/** @var \XF\ControllerPlugin\Reaction $reactionPlugin */
		$reactionPlugin = $this->plugin('XF:Reaction');
		return $reactionPlugin->actionReactSimple($comment, 'owner-page-posts/comments');
	}

	public function actionCommentsReactions(ParameterBag $params)
	{
		$comment = $this->assertViewableComment($params->post_comment_id);

		$breadcrumbs = $this->getOwnerPagePostBreadcrumbs($comment->OwnerPagePost);

		/** @var \XF\ControllerPlugin\Reaction $reactionPlugin */
		$reactionPlugin = $this->plugin('XF:Reaction');
		return $reactionPlugin->actionReactions(
			$comment,
			'owner-page-posts/comments/reactions',
			null, $breadcrumbs
		);
	}

	/**
	 * @param \XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost
	 *
	 * @return \XenBulletins\BrandHub\Service\OwnerPagePost\Editor
	 */
	protected function setupEdit(\XF\Mvc\Entity\Entity $ownerPagePost)
	{
		$message = $this->plugin('XF:Editor')->fromInput('message');

		/** @var \XenBulletins\BrandHub\Service\OwnerPagePost\Editor $editor */
		$editor = $this->service('XenBulletins\BrandHub:OwnerPagePost\Editor', $ownerPagePost);
		$editor->setMessage($message);

		if ($ownerPagePost->canUploadAndManageAttachments())
		{
			$editor->setAttachmentHash($this->filter('attachment_hash', 'str'));
		}

		if ($this->filter('author_alert', 'bool') && $ownerPagePost->canSendModeratorActionAlert())
		{
			$editor->setSendAlert(true, $this->filter('author_alert_reason', 'str'));
		}

		return $editor;
	}

	protected function finalizeEdit(\XenBulletins\BrandHub\Service\OwnerPagePost\Editor $editor)
	{
	}

	/**
	 * @param \XenBulletins\BrandHub\Entity\OwnerPagePostComment $comment
	 *
	 * @return \XenBulletins\BrandHub\Service\OwnerPagePostComment\Editor
	 */
	protected function setupCommentEdit(\XenBulletins\BrandHub\Entity\OwnerPagePostComment $comment)
	{
		$message = $this->plugin('XF:Editor')->fromInput('message');

		/** @var \XenBulletins\BrandHub\Service\OwnerPagePostComment\Editor $editor */
		$editor = $this->service('XenBulletins\BrandHub:OwnerPagePostComment\Editor', $comment);
		$editor->setMessage($message);

		$ownerPagePost = $comment->OwnerPagePost;

		if ($ownerPagePost->canUploadAndManageAttachments())
		{
			$editor->setAttachmentHash($this->filter('attachment_hash', 'str'));
		}

		if ($this->filter('author_alert', 'bool') && $comment->canSendModeratorActionAlert())
		{
			$editor->setSendAlert(true, $this->filter('author_alert_reason', 'str'));
		}

		return $editor;
	}

	protected function finalizeCommentEdit(\XenBulletins\BrandHub\Service\OwnerPagePostComment\Editor $editor)
	{
	}

	protected function getOwnerPagePostBreadcrumbs(\XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost)
	{
		$breadcrumbs = [
			[
				'href' => $this->buildLink('owners', $ownerPagePost->OwnerPage),
				'value' => $ownerPagePost->OwnerPage->title
			]
		];

		return $breadcrumbs;
	}

	/**
	 * @param $postId
	 * @param array $extraWith
	 *
	 * @return \XenBulletins\BrandHub\Entity\OwnerPagePost
	 *
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertViewableOwnerPagePost($postId, array $extraWith = [])
	{
		$extraWith[] = 'User';
		$extraWith[] = 'OwnerPage';
//		$extraWith[] = 'ProfileUser.Privacy';
		$extraWith = array_unique($extraWith);

		/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost */
		$ownerPagePost = $this->em()->find('XenBulletins\BrandHub:OwnerPagePost', $postId, $extraWith);
		if (!$ownerPagePost)
		{
			throw $this->exception($this->notFound(\XF::phrase('requested_owner_page_post_not_found')));
		}
		if (!$ownerPagePost->canView($error))
		{
			throw $this->exception($this->noPermission($error));
		}

		return $ownerPagePost;
	}

	/**
	 * @param $commentId
	 * @param array $extraWith
	 *
	 * @return \XenBulletins\BrandHub\Entity\OwnerPagePostComment
	 *
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertViewableComment($commentId, array $extraWith = [])
	{
		$extraWith[] = 'User';
		$extraWith[] = 'OwnerPagePost.OwnerPage';
//		$extraWith[] = 'ProfilePost.ProfileUser.Privacy';
		array_unique($extraWith);

                /** @var \XenBulletins\BrandHub\Entity\OwnerPagePostComment $comment */
		$comment = $this->em()->find('XenBulletins\BrandHub:OwnerPagePostComment', $commentId, $extraWith);
		if (!$comment)
		{
			throw $this->exception($this->notFound(\XF::phrase('requested_comment_not_found')));
		}
		if (!$comment->canView($error))
		{
			throw $this->exception($this->noPermission($error));
		}

		return $comment;
	}

	/**
	 * @return \XenBulletins\BrandHub\Repository\OwnerPagePost
	 */
        
        protected function getOwnerPagePostRepo()
        {
                return $this->repository('XenBulletins\BrandHub:OwnerPagePost');
        }

	public static function getActivityDetails(array $activities)
	{
		return \XF::phrase('viewing_owner_pages');
	}
}
