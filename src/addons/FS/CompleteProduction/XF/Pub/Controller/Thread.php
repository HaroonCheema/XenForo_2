<?php

namespace FS\CompleteProduction\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Thread extends XFCP_Thread
{
	public function actionCompleteProduction(ParameterBag $params)
	{

		$thread = $this->assertViewableThread($params->thread_id);
		if (!$thread->canCompleteProduction()) {
			return $this->noPermission();
		}

		if ($this->isPost()) {
			$message = \XF::phrase('fs_complete_product_text');

			$this->upgradeProductStatus($thread, $message);

			$thread->bulkSet([
				'is_product_completed' => 1,
				'prefix_id' => \XF::options()->fs_complete_production_prefix_id ?? 0
			]);
			$thread->save();

			return $this->redirect($this->buildLink('threads', $thread));
		} else {
			$viewParams = [
				'thread' => $thread,

			];
			return $this->view('XF:Thread\Approve', 'fs_production_complete_product', $viewParams);
		}
	}

	public function actionReceiveMoney(ParameterBag $params)
	{

		$thread = $this->assertViewableThread($params->thread_id);
		if (!$thread->canReceiveMoney()) {
			return $this->noPermission();
		}

		if ($this->isPost()) {

			$message = \XF::phrase('fs_product_money_received_text');

			$this->upgradeProductStatus($thread, $message);

			$thread->bulkSet([
				'is_transfer_received' => 1,
				'prefix_id' => \XF::options()->fs_receive_money_prefix_id ?? 0
			]);
			$thread->save();

			return $this->redirect($this->buildLink('threads', $thread));
		} else {
			$viewParams = [
				'thread' => $thread,
			];
			return $this->view('XF:Thread\Approve', 'fs_production_receive_money', $viewParams);
		}
	}

	protected function upgradeProductStatus(\XF\Entity\Thread $thread, $message)
	{
		$isPreRegReply = $thread->canReplyPreReg();

		if (!$thread->canReply($error) && !$isPreRegReply) {
			return $this->noPermission($error);
		}

		$replier = $this->setupProductReply($thread, $message);
		$replier->checkForSpam();

		if (!$replier->validate($errors)) {
			return $this->error($errors);
		}
		$this->assertNotFlooding('post');

		if ($isPreRegReply) {
			/** @var \XF\ControllerPlugin\PreRegAction $preRegPlugin */
			$preRegPlugin = $this->plugin('XF:PreRegAction');
			return $preRegPlugin->actionPreRegAction(
				'XF:Thread\Reply',
				$thread,
				$this->getPreRegReplyActionData($replier)
			);
		}

		$post = $replier->save();

		$this->finalizeThreadReply($replier);

		return true;
	}

	protected function setupProductReply(\XF\Entity\Thread $thread, $message = 'empty')
	{

		/** @var \XF\Service\Thread\Replier $replier */
		$replier = $this->service('XF:Thread\Replier', $thread);

		$replier->setMessage($message);

		if ($thread->Forum->canUploadAndManageAttachments()) {
			$replier->setAttachmentHash($this->filter('attachment_hash', 'str'));
		}

		if ($thread->canReplyPreReg()) {
			// only returns true when pre-reg replying is the only option
			$replier->setIsPreRegAction(true);
		}

		return $replier;
	}
}
