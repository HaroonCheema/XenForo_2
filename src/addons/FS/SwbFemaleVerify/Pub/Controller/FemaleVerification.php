<?php

namespace FS\SwbFemaleVerify\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class FemaleVerification extends AbstractController
{
	public function actionAdd()
	{
		$visitor = \XF::visitor();

		if (!$visitor->user_id || $visitor->identity_status == 'queue' || $visitor->identity_status == 'sent' || $visitor->account_type == 1) {

			return $this->noPermission();
		}

		if ($this->isPost()) {

			$verifyType = $this->filter('female_identity_type', 'str');

			if ($verifyType == 'images') {
				$this->filterInputsImages();
			} elseif ($verifyType == 'boxes') {
				$input = $this->filterInputs();
			}


			$insert = $this->finder('FS\SwbFemaleVerify:FemaleVerification')->where('user_id', $visitor['user_id'])->fetchOne();

			if (!$insert) {
				$insert = $this->em()->create('FS\SwbFemaleVerify:FemaleVerification');
				$insert->user_id = $visitor['user_id'];
			}

			$insert->female_state = "pending";
			$insert->verify_type = $verifyType;


			if ($verifyType == 'boxes') {

				$insert->boxOne = $input['boxOne'];
				$insert->boxTwo = $input['boxTwo'];
			}

			$insert->save();


			if ($verifyType == 'images') {

				$this->saveImage($insert);
			}

			$visitor->fastupdate('identity_status', 'queue');

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

	protected function filterInputsImages()
	{

		$govImage = $this->request->getFile('govImage', false, false);
		$selfiImage = $this->request->getFile('selfiImage', false, false);
		$paperImage = $this->request->getFile('paperImage', false, false);

		if (!($govImage && $selfiImage && $paperImage)) {
			throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
		}

		return true;
	}

	protected function filterInputs()
	{

		$input = $this->filter([
			'female_identity_type' => 'str',
			'boxOne' => 'str',
			'boxTwo' => 'str',
		]);

		if ($input['female_identity_type'] == '' || $input['boxOne'] == '' || $input['boxTwo'] == '') {
			throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
		}

		return $input;
	}
}
