<?php


namespace FS\AttachmentsQueue\Repository;

use XF;
use XF\Entity\User;
use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class AttachmentQueueRepo extends Repository
{
	public function rebuildPendingAttachmentCounts()
	{
		$cache = [
			'total' => $this->db()->fetchOne("
				SELECT COUNT(*) FROM xf_attachment
				WHERE `attachment_state`='pending' AND `content_type`='post'
			"),
			'lastModified' => time()
		];

		\XF::registry()->set('fsAttachmentsPendingCount', $cache);

		return $cache;
	}
}
