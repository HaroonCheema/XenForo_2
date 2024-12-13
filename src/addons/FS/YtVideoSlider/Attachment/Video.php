<?php

namespace FS\YtVideoSlider\Attachment;

use XF\Attachment\AbstractHandler;
use XF\Entity\Attachment;
use XF\Mvc\Entity\Entity;

class Video extends AbstractHandler
{

	public function canView(Attachment $attachment, Entity $container, &$error = null)
	{
		return [];
	}

	public function canManageAttachments(array $context, &$error = null)
	{
		$em = \XF::em();

		/** @var \XFMG\XF\Entity\User $visitor */
		$visitor = \XF::visitor();


		return [];
	}


	public function onAttachmentDelete(Attachment $attachment, Entity $container = null)
	{
		if (!$container) {
			return;
		}

		$container->delete(false);
	}

	public function getConstraints(array $context)
	{
		$em = \XF::em();

		return [];
	}

	public function getContainerIdFromContext(array $context)
	{
		return [];
	}

	public function getContainerLink(Entity $container, array $extraParams = [])
	{
		return [];
	}

	public function getContext(Entity $entity = null, array $extraContext = [])
	{
		$extraContext['video_id'] = $entity->video_id;

		return $extraContext;
	}
}
