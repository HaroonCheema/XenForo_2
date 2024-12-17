<?php

namespace FS\YtVideoSlider\Attachment;

use XF\Attachment\AbstractHandler;
use XF\Entity\Attachment;
use XF\Mvc\Entity\Entity;

class Video extends AbstractHandler
{

	public function canView(Attachment $attachment, Entity $container, &$error = null)
	{
		return true;
	}

	public function canManageAttachments(array $context, &$error = null)
	{
		$em = \XF::em();

		/** @var \XFMG\XF\Entity\User $visitor */
		$visitor = \XF::visitor();


		return true;
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

		// $extensions = [];
		// if (in_array('image', $this->allowed_types))
		// {
		// 	$extensions = array_merge($extensions, Arr::stringToArray($options->xfmgImageExtensions));
		// }
		// if (in_array('video', $this->allowed_types))
		// {
		// 	$extensions = array_merge($extensions, Arr::stringToArray($options->xfmgVideoExtensions));
		// }
		// if (in_array('audio', $this->allowed_types))
		// {
		// 	$extensions = array_merge($extensions, Arr::stringToArray($options->xfmgAudioExtensions));
		// }

		// $total = $this->hasPermission('maxAllowedStorage');
		// $size = $this->hasPermission('maxFileSize');
		// $width = $this->hasPermission('maxImageWidth');
		// $height = $this->hasPermission('maxImageHeight');

		// // Treat both 0 and -1 as unlimited
		// return [
		// 	'extensions' => $extensions,
		// 	'total' => ($total <= 0) ? PHP_INT_MAX : $total * 1024 * 1024,
		// 	'size' => ($size <= 0) ? PHP_INT_MAX : $size * 1024 * 1024,
		// 	'width' => ($width <= 0) ? PHP_INT_MAX : $width,
		// 	'height' => ($height <= 0) ? PHP_INT_MAX : $height,
		// 	'count' => 100
		// ];

		return [];
	}

	public function getContainerIdFromContext(array $context)
	{
		return isset($context['video_id']) ? intval($context['video_id']) : null;
	}

	public function getContainerLink(Entity $container, array $extraParams = [])
	{
		return \XF::app()->router('admin')->buildLink('yt-videos', $container, $extraParams);

		return [];
	}

	public function getContext(Entity $entity = null, array $extraContext = [])
	{
		$extraContext['video_id'] = $entity->video_id;

		return $extraContext;
	}
}
