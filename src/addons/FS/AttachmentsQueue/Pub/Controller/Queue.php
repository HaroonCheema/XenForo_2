<?php

namespace FS\AttachmentsQueue\Pub\Controller;

use XF;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Repository;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\Exception;
use XF\Pub\Controller\AbstractController;

class Queue extends AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertRegistrationRequired();

		$visitor = XF::visitor();
		if (!$visitor->is_admin || !$visitor->is_moderator) {

			throw $this->exception($this->noPermission());
		}
	}

	public function actionIndex()
	{
		$pendingAttachments = $this->finder('XF:Attachment')->where('content_type', 'post')->order('attachment_id', 'DESC')
			->where('attachment_state', 'pending');

		$page = $this->filterPage();
		$perPage = 15;
		$pendingAttachments->limitByPage($page, $perPage);
		$total = $pendingAttachments->total();

		$this->assertValidPage($page, $perPage, $total, 'attachment-queue/');

		$redirect = $this->getDynamicRedirect($this->buildLink('attachment-queue/', null, ['page' => $page]), false);

		$viewParams = [
			'pendingAttachments' => $pendingAttachments->fetch(),
			'total' => $total,
			'page' => $page,
			'perPage' => $perPage,
			'redirect' => $redirect
		];

		return $this->view('FS\AttachmentsQueue:Queue\Index', 'fs_attachment_queue_list', $viewParams);
	}

	public function actionSave()
	{
		$this->assertPostOnly();

		$input = $this->filter([
			'attachments' => 'array',
		]);

		$attachments = array_filter($input['attachments'], function ($value) {
			return $value !== "pending";
		});

		if (count($attachments)) {
			foreach ($attachments as $attachmentId => $attachmentState) {

				$attachment = $this->assertAttachmentExists($attachmentId);

				if (!$attachment) {
					continue;
				}

				$attachment->bulkSet([
					'attachment_state' => $attachmentState,
				]);

				$attachment->save();
			}

			$this->repository("FS\AttachmentsQueue:AttachmentQueueRepo")->rebuildPendingAttachmentCounts();
		}

		$redirect = $this->getDynamicRedirect('attachment-queue/');
		return $this->redirect($redirect);
	}

	protected function assertAttachmentExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('XF:Attachment', $id, $with, $phraseKey);
	}
}
