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
}
