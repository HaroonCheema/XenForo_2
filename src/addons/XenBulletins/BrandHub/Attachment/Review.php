<?php

namespace XenBulletins\BrandHub\Attachment;

use XF\Attachment\AbstractHandler;
use XF\Entity\Attachment;
use XF\Mvc\Entity\Entity;

class Review extends AbstractHandler
{
	public function getContainerWith()
	{
		$visitor = \XF::visitor();

//		return ['Attachment'];
	}

	public function canView(Attachment $attachment, Entity $container, &$error = null)
	{
		
		return $container->canView();
	}

	public function canManageAttachments(array $context, &$error = null)
	{

		return true;
	}

	public function validateAttachmentUpload(\XF\Http\Upload $upload, \XF\Attachment\Manipulator $manipulator)
	{
          
		if (!$upload->getTempFile())
		{
			return;
		}

		$extension = $upload->getExtension();

		$repo = \XF::repository('XenBulletins\BrandHub:Item');

              
                
		$mediaType = $repo->getMediaTypeFromExtension($extension);

		if (in_array($mediaType, ['audio', 'image', 'video']))
		{
			$visitor = \XF::visitor();
			$constraints = $manipulator->getConstraints();

			$thisFileSize = $runningTotal = $upload->getFileSize();
			$newAttachments = $manipulator->getNewAttachments();
			if (count($newAttachments))
			{
				foreach ($newAttachments AS $attachment)
				{
					/** @var \XF\Entity\Attachment $attachment */
					$runningTotal += intval($attachment->getFileSize());
				}
			}
		}
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
		$em = \XF::em();

		if (!empty($context['item_rating_id']))
		{
			
			$itemRating = $em->find('XenBulletins\BrandHub:ItemRating', intval($context['item_rating_id']));
			return $itemRating->getAttachmentConstraints();
		}
		else
		{
			$itemRating = $em->create('XenBulletins\BrandHub:ItemRating');
			return $itemRating->getAttachmentConstraints();
		}
	}

	public function getContainerIdFromContext(array $context)
	{
		return isset($context['item_rating_id']) ? intval($context['item_rating_id']) : null;
	}

	public function getContainerLink(Entity $container, array $extraParams = [])
	{
		return \XF::app()->router('public')->buildLink(\XF::options()->bh_main_route.'/item/#reviews', $container, $extraParams);
	}

	public function getContext(Entity $entity = null, array $extraContext = [])
	{

		if ($entity instanceof \XenBulletins\BrandHub\Entity\ItemRating)
		{
			$extraContext['item_rating_id'] = $entity->item_rating_id;
		}
		else if (!$entity)
		{
			// need nothing
		}
		else
		{
			throw new \InvalidArgumentException("Entity must be media, record or category");
		}

		return $extraContext;
	}
}