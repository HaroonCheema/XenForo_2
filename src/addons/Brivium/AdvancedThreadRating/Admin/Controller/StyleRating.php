<?php
namespace Brivium\AdvancedThreadRating\Admin\Controller;

use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

class StyleRating extends \XF\Admin\Controller\AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission('thread');
	}

	public function actionIndex(ParameterBag $params )
	{
		$styleRatingRepo = $this->getStyleRatingRepo();
		$styleRatings = $styleRatingRepo->findStyleRatings();

		$defaultStyle = true;
		if (! empty( $styleRatings))
		{
			foreach($styleRatings as $styleRating)
			{
				if (! empty( $styleRating['status']))
				{
					$defaultStyle = false;
					break;
				}
			}
		}
		$viewParams = array(
			'styleRatings' => $styleRatings,
			'defaultStyle' => $defaultStyle
		);
		return $this->view('Brivium\AdvancedThreadRating:StyleRating\Listing', 'BRATR_style_rating_list', $viewParams);
	}

	public function styleRatingAddEdit(\Brivium\AdvancedThreadRating\Entity\StyleRating $styleRating)
	{
		$viewParams = [
			'styleRating' => $styleRating,
		];
		return $this->view('Brivium\AdvancedThreadRating:StyleRating\Edit', 'BRATR_style_rating_edit', $viewParams);
	}

	public function actionEdit(ParameterBag $params)
	{
		$styleRating = $this->assertStyleRatingExists($params->style_rating_id);
		return $this->styleRatingAddEdit($styleRating);
	}

	public function actionAdd()
	{
		$styleRating = $this->em()->create('Brivium\AdvancedThreadRating:StyleRating');
		return $this->styleRatingAddEdit($styleRating);
	}

	protected function styleRatingSaveProcess(\Brivium\AdvancedThreadRating\Entity\StyleRating $styleRating)
	{
		$form = $this->formAction();

		$input = $this->filter([
			'icon_width' => 'uint',
			'icon_height' => 'uint',
			'icon_second_position' => 'uint',
		]);

		$icon = $this->request->getFile('upload');
		$form->validate(function(FormAction $form) use ($icon, $styleRating)
		{
			if($styleRating->isInsert() && empty($icon))
			{
				$form->logError(\XF::phrase('BRATR_please_upload_style_rating_image'));
			}
		});

		$form->basicEntitySave($styleRating, $input);

		if($icon)
		{
			$form->apply(function(FormAction $form) use ($icon, $styleRating)
			{
				$iconService = $this->service('Brivium\AdvancedThreadRating:Rating\Icon', $styleRating);

				if(!$iconService->setIcon($icon))
				{
					return $form->logError($iconService->getError());
				}
				$iconService->updateIcon();
			});
		}
		return $form;
	}

	public function actionSave(ParameterBag $params)
	{
		$this->assertPostOnly();

		if ($params->style_rating_id)
		{
			$styleRating = $this->assertStyleRatingExists($params->style_rating_id);
		}
		else
		{
			$styleRating = $this->em()->create('Brivium\AdvancedThreadRating:StyleRating');
		}

		$this->styleRatingSaveProcess($styleRating)->run();
		return $this->redirect($this->buildLink('bratr-style-rating'));
	}

	public function actionDelete(ParameterBag $params)
	{
		$styleRating = $this->assertStyleRatingExists($params->style_rating_id);
		if (!$styleRating->preDelete())
		{
			return $this->error($styleRating->getErrors());
		}

		if ($this->isPost())
		{
			$styleRating->delete();
			return $this->redirect($this->buildLink('bratr-style-rating'));
		}
		$viewParams = [
			'styleRating' => $styleRating
		];
		return $this->view('Brivium\AdvancedThreadRating:StyleRating\Delete', 'BRATR_style_rating_delete', $viewParams);
	}

	public function actionToggle()
	{
		$styleRatingId = $this->filter('status', 'uint');
		$this->getStyleRatingRepo()->updateDefaultStyleRating($styleRatingId);
		return $this->message(\XF::phrase('your_changes_have_been_saved'));
	}

	protected function assertStyleRatingExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists('Brivium\AdvancedThreadRating:StyleRating', $id, $with, $phraseKey);
	}

	protected function getStyleRatingRepo()
	{
		return $this->repository('Brivium\AdvancedThreadRating:StyleRating');
	}
}