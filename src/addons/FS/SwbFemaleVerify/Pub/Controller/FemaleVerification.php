<?php

namespace FS\SwbFemaleVerify\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class FemaleVerification extends AbstractController
{
	public function actionAdd()
	{
		$visitor = \XF::visitor();

		if (!$visitor->user_id) {

			return $this->noPermission();
		}

		if ($this->isPost()) {

			$input = $this->filterInputs();

			$insert = $this->finder('FS\SwbFemaleVerify:FemaleVerification')->where('user_id', $visitor['user_id'])->fetchOne();

			if (!$insert) {
				$insert = $this->em()->create('FS\SwbFemaleVerify:FemaleVerification');
				$insert->user_id = $visitor['user_id'];
			}

			$insert->female_state = "pending";

			$insert->save();

			$this->saveImage($insert);

			return $this->redirect($this->buildLink('members', $visitor));
		}

		$viewParams = [];

		return $this->view('FS\SwbFemaleVerify:FemaleVerification\Add', 'fs_female_verification_add', $viewParams);
	}

	protected function saveImage($verify)
	{
		$govImage = $this->request->getFile('govImage', false, false);
		$selfiImage = $this->request->getFile('selfiImage', false, false);
		$paperImage = $this->request->getFile('paperImage', false, false);

		if ($govImage) {
			$uploadService = $this->service('FS\SwbFemaleVerify:Upload', $verify);

			if (!$uploadService->setImageFromUpload($govImage)) {
				throw $this->exception($this->error($uploadService->getError()));
			}

			if (!$uploadService->setImageFromUpload($selfiImage)) {
				throw $this->exception($this->error($uploadService->getError()));
			}

			if (!$uploadService->setImageFromUpload($paperImage)) {
				throw $this->exception($this->error($uploadService->getError()));
			}

			if (!$uploadService->setImageFromUpload($govImage)) {
				throw $this->exception($this->error($uploadService->getError()));
			}

			if (!$uploadService->uploadImage("govImage")) {
				return $this->error(\XF::phrase('new_image_could_not_be_processed'));
			}

			if (!$uploadService->setImageFromUpload($selfiImage)) {
				throw $this->exception($this->error($uploadService->getError()));
			}

			if (!$uploadService->uploadImage("selfiImage")) {
				return $this->error(\XF::phrase('new_image_could_not_be_processed'));
			}

			if (!$uploadService->setImageFromUpload($paperImage)) {
				throw $this->exception($this->error($uploadService->getError()));
			}

			if (!$uploadService->uploadImage("paperImage")) {
				return $this->error(\XF::phrase('new_image_could_not_be_processed'));
			}
		}
	}

	protected function filterInputs()
	{

		$govImage = $this->request->getFile('govImage', false, false);
		$selfiImage = $this->request->getFile('selfiImage', false, false);
		$paperImage = $this->request->getFile('paperImage', false, false);

		if (!($govImage && $selfiImage && $paperImage)) {
			throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
		}

		return true;
	}
}
