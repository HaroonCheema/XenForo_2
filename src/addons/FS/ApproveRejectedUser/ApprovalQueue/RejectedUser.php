<?php

namespace FS\ApproveRejectedUser\ApprovalQueue;

use XF\ApprovalQueue\AbstractHandler;
use XF\Entity\ApprovalQueue;
use XF\Mvc\Entity\Entity;

class RejectedUser extends AbstractHandler
{
	protected function canViewContent(Entity $content, &$error = null)
	{
		return true;
	}

	protected function canActionContent(Entity $content, &$error = null)
	{
		return \XF::visitor()->canApproveRejectUser();
	}

	public function getEntityWith()
	{
		return ['Profile', 'PreRegAction'];
	}

	public function getTemplateData(ApprovalQueue $unapprovedItem)
	{
		$templateData = parent::getTemplateData($unapprovedItem);

		/** @var \XF\Entity\User $user */
		$user = $unapprovedItem->Content;
		$templateData['user'] = $user;

		$preRegAction = $user->PreRegAction;
		if ($preRegAction) {
			$templateData['preRegAction'] = $preRegAction;
			$templateData['preRegHandler'] = $preRegAction->getHandler();
		}

		// If we suspect this user to be a spammer, let's also grab their recent change logs.
		// This will highlight spam-like changes to their account they made after being sent to the approval queue.
		if ($user->isPossibleSpammer()) {
			$changeRepo = \XF::repository('XF:ChangeLog');
			$changeFinder = $changeRepo->findChangeLogsByContent('user', $user->user_id);

			// just get 5 most recent - ignore "protected" entries as these are set by the system
			$changes = $changeFinder->where('protected', 0)->fetch(5);
			$changeRepo->addDataToLogs($changes);

			$templateData['changesGrouped'] = $changeRepo->groupChangeLogs($changes);
		}

		return $templateData;
	}

	public function actionApprove(\XF\Entity\User $user)
	{
		$user->user_state = 'valid';
		$user->save();

		\XF::app()->logger()->logModeratorAction('user', $user, 'approved');

		$finder = \XF::finder('XF:ApprovalQueue');
		$userExist = $finder
			->where('content_type', 'fs_rejected_user')
			->where('content_id', $user->user_id)
			->fetchOne();

		if ($userExist) {
			$userExist->delete();
		}

		$notify = $this->getInput('notify', $user->user_id);
		if ($notify && $user->email) {
			\XF::app()->mailer()->newMail()
				->setTemplate('user_account_approved', ['user' => $user])
				->setToUser($user)
				->send();
		}

		/** @var \XF\Service\User\RegistrationComplete $regComplete */
		$regComplete = \XF::app()->service('XF:User\RegistrationComplete', $user);
		$regComplete->triggerCompletionActions();
	}
}
