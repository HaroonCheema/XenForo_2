<?php

namespace FS\DeleteEmail\XF\Pub\Controller;

class Account extends XFCP_Account
{
	public function actionDeleteEmail()
	{
		$visitor = \XF::visitor();
		$auth = $visitor->Auth->getAuthenticationHandler();
		if (!$auth) {
			return $this->noPermission();
		}

		return $this->message("hello");
	}

	public function actionEmail()
	{
		$visitor = \XF::visitor();
		$auth = $visitor->Auth->getAuthenticationHandler();
		if (!$auth) {
			return $this->noPermission();
		}

		if (!$visitor['email']) {
			throw $this->exception(
				$this->error(\XF::phrase('your_email_may_not_be_changed_at_this_time'))
			);
		}
		return parent::actionEmail();
	}
}
