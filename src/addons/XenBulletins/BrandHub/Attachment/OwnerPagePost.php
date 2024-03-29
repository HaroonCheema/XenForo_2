<?php

namespace XenBulletins\BrandHub\Attachment;

use XF\Entity\Attachment;
use XF\Mvc\Entity\Entity;
use XF\Attachment\AbstractHandler;

class OwnerPagePost extends AbstractHandler
{
	public function getContainerWith()
	{
		return ['OwnerPage', 'User'];
	}

	public function canView(Attachment $attachment, Entity $container, &$error = null)
	{
		/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $container */
		if (!$container->canView())
		{
			return false;
		}

		return $container->canViewAttachments($error);
	}

	public function canManageAttachments(array $context, &$error = null)
	{
		$ownerPage = $this->getOwnerPageFromContext($context);
		return ($ownerPage && $ownerPage->canUploadAndManageAttachmentsOnOwnerPage());
	}

	public function onAttachmentDelete(Attachment $attachment, Entity $container = null)
	{
		if (!$container)
		{
			return;
		}

		/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $container */
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

		$ownerPage = $this->getOwnerPageFromContext($context);
		if ($ownerPage && $ownerPage->canUploadVideosOnOwnerPage())
		{
			$constraints = $attachRepo->applyVideoAttachmentConstraints($constraints);
		}

		return $constraints;
	}

	public function getContainerIdFromContext(array $context)
	{
		return isset($context['post_id']) ? intval($context['post_id']) : null;
	}

	public function getContext(Entity $entity = null, array $extraContext = [])
	{
		if ($entity instanceof \XenBulletins\BrandHub\Entity\OwnerPagePost)
		{
			$extraContext['post_id'] = $entity->post_id;
		}
		else if ($entity instanceof \XenBulletins\BrandHub\Entity\OwnerPage)
		{
			$extraContext['owner_page_id'] = $entity->page_id;
		}
		else
		{
			throw new \InvalidArgumentException("Entity must be OwnerPagePost or OwnerPage");
		}

		return $extraContext;
	}

	protected function getOwnerPageFromContext(array $context)
	{
		$em = \XF::em();

		if (!empty($context['post_id']))
		{
			/** @var \XenBulletins\BrandHub\Entity\OwnerPagePost $ownerPagePost */
			$ownerPagePost = $em->find('XenBulletins\BrandHub:OwnerPagePost', intval($context['post_id']), ['OwnerPage']);
			if (!$ownerPagePost || !$ownerPagePost->canView() || !$ownerPagePost->canEdit())
			{
				return null;
			}

			$ownerPage = $ownerPagePost->OwnerPage;
		}
		else if (!empty($context['owner_page_id']))
		{
			/** @var \XenBulletins\BrandHub\Entity\OwnerPage $ownerPage */
			$ownerPage = $em->find('XenBulletins\BrandHub:OwnerPage', intval($context['owner_page_id']));
			if (!$ownerPage)
			{
				return null;
			}
		}

		return $ownerPage ?? null;
	}
}