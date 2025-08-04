<?php

namespace FS\SendMailFromTable\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class EmailLogs extends AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertRegistrationRequired();

		$visitor = \XF::visitor();

		if (!$visitor->is_admin || !$visitor->is_moderator) {
			throw $this->exception(
				$this->noPermission()
			);
		}
	}

	public function actionIndex(ParameterBag $params)
	{

		$finder = $this->finder('FS\SendMailFromTable:CronEmailLogs')->order('id', 'DESC');

		$page = $params->page;
		$perPage = 15;

		$finder->limitByPage($page, $perPage);

		$viewParams = [
			'emailLogs' => $finder->fetch(),

			'page' => $page,
			'perPage' => $perPage,
			'total' => $finder->total(),
		];

		return $this->view('FS\SendMailFromTable:EmailLogs\Index', 'fs_email_logs_index', $viewParams);
	}

	public function actionDetail(ParameterBag $params)
	{
		$cromEmailLog = $this->assertDataExists($params->id);

		$emailLogs = \XF::finder('FS\SendMailFromTable:MidNightEmails')
			->where('id', $cromEmailLog['email_ids'])
			->order('id', 'DESC');

		$page = $params->page;

		$viewParams = [
			'emailLogsDetail' => $emailLogs->fetch(),

			'page' => $page,
			'perPage' => $emailLogs->total(),
			'total' => $emailLogs->total(),
		];

		return $this->view('FS\SendMailFromTable:EmailLogs\Index', 'fs_email_logs_details', $viewParams);
	}

	public function actionSend(ParameterBag $params)
	{
		$midNightEmail = $this->assertEmailDataExists($params->id);

		$message = \XF::options()->fs_send_message_on_whatsapp;

		$phoneNum = $midNightEmail['phone_no'];

		if (!$message || !$phoneNum) {
			$this->noPermission();
		}

		$cleanPhone = preg_replace('/[^0-9]/', '', $phoneNum);

		$encodedMessage = urlencode($message);

		$whatsAppUrl = "https://wa.me/{$cleanPhone}?text={$encodedMessage}";

		return $this->redirect($whatsAppUrl);
	}

	/**
	 * @param string $id
	 * @param array|string|null $with
	 * @param null|string $phraseKey
	 *
	 * @return \FS\SendMailFromTable\Entity\EmailTemplates
	 */
	protected function assertDataExists($id, array $extraWith = [], $phraseKey = null)
	{
		return $this->assertRecordExists('FS\SendMailFromTable:CronEmailLogs', $id, $extraWith, $phraseKey);
	}

	protected function assertEmailDataExists($id, array $extraWith = [], $phraseKey = null)
	{
		return $this->assertRecordExists('FS\SendMailFromTable:MidNightEmails', $id, $extraWith, $phraseKey);
	}
}
