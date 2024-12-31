<?php

namespace OzzModz\Badges\XF\Pub\Controller;

class Account extends XFCP_Account
{
	protected function savePrivacyProcess(\XF\Entity\User $visitor)
	{
		$form = parent::savePrivacyProcess($visitor);
		$input = $this->filter([
			'option' => [
				'ozzmodz_badges_email_on_award' => 'bool'
			]
		]);

		/** @var \XF\Entity\UserOption $userOptions */
		$userOptions = $visitor->getRelationOrDefault('Option');
		$form->setupEntityInput($userOptions, $input['option']);
		return $form;
	}

	protected function preferencesSaveProcess(\XF\Entity\User $visitor)
	{
		$form = parent::preferencesSaveProcess($visitor);
		$input = $this->filter(['option' => ['ozzmodz_badges_email_on_award' => 'bool']]);

		/** @var \XF\Entity\UserOption $userOptions */
		$userOptions = $visitor->getRelationOrDefault('Option');
		$form->setupEntityInput($userOptions, $input['option']);
		return $form;
	}
}