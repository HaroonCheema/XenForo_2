<?php

namespace FS\AttachmentsQueue;

/**
 * Class Listener
 *
 * @package FS\AttachmentsQueue
 */
class Listener
{
	/**
	 * Called after the global \XF\App object has been setup. This will fire regardless of the
	 * application type.
	 *
	 * @param \XF\App $app Global App object.
	 * @throws \XF\Db\Exception
	 */
	public static function appSetup(\XF\App $app)
	{
		$container = $app->container();

		$container['fsAttachmentsPendingCount'] = $app->fromRegistry(
			'fsAttachmentsPendingCount',
			function (\XF\Container $c) {
				/** @var \FS\AttachmentsQueue\Repository\AttachmentQueueRepo $storeRepo */
				$storeRepo = $c['em']->getRepository("FS\AttachmentsQueue:AttachmentQueueRepo");
				return $storeRepo->rebuildPendingAttachmentCounts();
			}
		);
	}

	/**
	 * Called at the end of the the Public \XF\Pub\App object startup process.
	 *
	 * @param \XF\Pub\App $app Public App object.
	 */
	public static function appPubStartEnd(\XF\Pub\App $app)
	{
		$visitor = \XF::visitor();
		if ($visitor->is_admin || $visitor->is_moderator) {
			$session = $app->session();
			$registryAttachmentCounts = $app->container()->fsAttachmentsPendingCount;
			$session->fsAttachmentsPendingCount = $registryAttachmentCounts;
		}
	}
}
