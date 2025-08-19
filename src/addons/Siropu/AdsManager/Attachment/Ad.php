<?php

namespace Siropu\AdsManager\Attachment;

use XF\Attachment\AbstractHandler;
use XF\Entity\Attachment;
use XF\Mvc\Entity\Entity;

class Ad extends AbstractHandler
{
	public function canView(Attachment $attachment, Entity $container, &$error = null)
	{
		return true;
	}
	public function canManageAttachments(array $context, &$error = null)
	{
		return true;
	}
	public function onAttachmentDelete(Attachment $attachment, Entity $container = null)
	{
		if (!$container)
		{
			return;
		}
	}
     public function getConstraints(array $context)
	{
		/** @var \XF\Repository\Attachment $attachRepo */
		$attachRepo = \XF::repository('XF:Attachment');

		$constraints = $attachRepo->getDefaultAttachmentConstraints();

		$forum = $this->getForumFromContext($context);
		if ($forum && $forum->canUploadVideos())
		{
			$constraints = $attachRepo->applyVideoAttachmentConstraints($constraints);
		}

		return $constraints;
	}
	public function getContainerIdFromContext(array $context)
	{
		return isset($context['ad_id']) ? intval($context['ad_id']) : null;
	}
	public function getContainerLink(Entity $container, array $extraParams = [])
	{
		return \XF::app()->router('admin')->buildLink('ads-manager/ads/edit', $container, $extraParams);
	}
	public function getContext(Entity $entity = null, array $extraContext = [])
	{
		if ($entity instanceof \Siropu\AdsManager\Entity\Ad)
		{
			$extraContext['ad_id'] = $entity->ad_id;
		}
		else
		{
			throw new \InvalidArgumentException("Entity must be ad");
		}

		return $extraContext;
	}

     protected function getForumFromContext(array $context)
	{
		$em = \XF::em();
		$forum = null;

		if (!empty($context['node_id']))
		{
			/** @var \XF\Entity\Forum $forum */
			$forum = $em->find('XF:Forum', intval($context['node_id']));
			if (!$forum || !$forum->canView())
			{
				return null;
			}
		}
		else
		{
			return null;
		}

		return $forum;
	}
}
