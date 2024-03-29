<?php

namespace XenBulletins\BrandHub\Attachment;

use XF\Entity\Attachment;
use XF\Mvc\Entity\Entity;
use XF\Attachment\AbstractHandler;

class OwnerPagePostComment extends AbstractHandler
{
	public function getContainerWith()
	{
		return ['OwnerPagePost', 'User'];
	}

	public function canView(Attachment $attachment, Entity $container, &$error = null)
	{
		/** @var \XenBulletins\BrandHub\Entity\OwnerPagePostComment $container */
		if (!$container->canView())
		{
			return false;
		}

		return $container->canViewAttachments($error);
	}

	public function canManageAttachments(array $context, &$error = null)
	{
		$ownerPagePost = $this->getOwnerPagePostFromContext($context);
		return ($ownerPagePost && $ownerPagePost->canUploadAndManageAttachments());
	}

	public function onAttachmentDelete(Attachment $attachment, Entity $container = null)
	{
		if (!$container)
		{
			return;
		}

		/** @var \XenBulletins\BrandHub\Entity\OwnerPagePostComment $container */
		$container->attach_count--;
		$container->save();

		// TODO: phrase for attachment_deleted
		\XF::app()->logger()->logModeratorAction($this->contentType, $container, 'attachment_deleted', [], false);
	}

	public function getConstraints(array $context)
	{
		/** @var \XF\Repository\Attachment $attachRepo */
		$attachRepo = \XF::repository('XF:Attachment');

		$constraints = $attachRepo->getDefaultAttachmentConstraints();

		$ownerPagePost = $this->getOwnerPagePostFromContext($context);
		if ($ownerPagePost && $ownerPagePost->canUploadVideos())
		{
			$constraints = $attachRepo->applyVideoAttachmentConstraints($constraints);
		}

		return $constraints;
	}

	public function getContainerIdFromContext(array $context)
	{
		return isset($context['post_comment_id']) ? intval($context['post_comment_id']) : null;
	}

	public function getContext(Entity $entity = null, array $extraContext = [])
	{
		if ($entity instanceof \XenBulletins\BrandHub\Entity\OwnerPagePostComment)
		{
			$extraContext['post_comment_id'] = $entity->post_comment_id;
		}
		else if ($entity instanceof \XenBulletins\BrandHub\Entity\OwnerPagePost)
		{
			$extraContext['post_id'] = $entity->post_id;
		}
		else
		{
			throw new \InvalidArgumentException("Entity must be OwnerPagePostComment or OwnerPagePost");
		}

		return $extraContext;
	}

	protected function getOwnerPagePostFromContext(array $context)
	{
		$em = \XF::em();

		if (!empty($context['post_comment_id']))
		{
                        /** @var \XenBulletins\BrandHub\Entity\OwnerPagePostComment $ownerPagePostComment */
			$ownerPagePostComment = $em->find('XenBulletins\BrandHub:OwnerPagePostComment', intval($context['post_comment_id']), ['OwnerPagePost']);
			if (!$ownerPagePostComment || !$ownerPagePostComment->canView() || !$ownerPagePostComment->canEdit())
			{
				return null;
			}

			$ownerPagePost = $ownerPagePostComment->OwnerPagePost;
		}
		else if (!empty($context['post_id']))
		{
			/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost */
			$ownerPagePost = $em->find('XenBulletins\BrandHub:OwnerPagePost', intval($context['post_id']));
			if (!$ownerPagePost)
			{
				return null;
			}
		}

		return $ownerPagePost;
	}
}