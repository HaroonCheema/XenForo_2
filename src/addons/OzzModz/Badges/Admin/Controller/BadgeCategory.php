<?php
/**
 * [VersoBit] Badges
 */

namespace OzzModz\Badges\Admin\Controller;

use OzzModz\Badges\Addon;
use OzzModz\Badges\ControllerPlugin\TitleDescription;
use XF\Admin\Controller\AbstractController;
use XF\ControllerPlugin\Delete;
use XF\Mvc\ParameterBag;

class BadgeCategory extends AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission(Addon::prefix());
	}

	//
	// ACTIONS
	//

	public function actionIndex()
	{
		return $this->redirectPermanently($this->buildLink('ozzmodz-badges'));
	}

	public function actionAdd()
	{
		/** @var \OzzModz\Badges\Entity\BadgeCategory $badgeCategory */
		$badgeCategory = $this->em()->create(Addon::shortName('BadgeCategory'));
		return $this->badgeCategoryAddEdit($badgeCategory);
	}

	public function actionEdit(ParameterBag $params)
	{
		$badgeCategory = $this->assertBadgeCategoryExists($params['badge_category_id']);
		return $this->badgeCategoryAddEdit($badgeCategory);
	}

	public function actionSave(ParameterBag $params)
	{
		$this->assertPostOnly();

		if ($params['badge_category_id'])
		{
			$badgeCategory = $this->assertBadgeCategoryExists($params['badge_category_id']);
		}
		else
		{
			$badgeCategory = $this->em()->create(Addon::shortName('BadgeCategory'));
		}

		$this->badgeCategorySaveProcess($badgeCategory)->run();

		return $this->redirect($this->buildLink('ozzmodz-badges-categories'));
	}

	public function actionDelete(ParameterBag $params)
	{
		$badgeCategory = $this->assertBadgeCategoryExists($params['badge_category_id']);

		/** @var Delete $plugin */
		$plugin = $this->plugin('XF:Delete');

		return $plugin->actionDelete(
			$badgeCategory,
			$this->buildLink('ozzmodz-badges-categories/delete', $badgeCategory),
			$this->buildLink('ozzmodz-badges-categories/edit', $badgeCategory),
			$this->buildLink('ozzmodz-badges'),
			$badgeCategory->title
		);
	}

	//
	// UTIL
	//

	protected function badgeCategoryAddEdit(\OzzModz\Badges\Entity\BadgeCategory $badgeCategory)
	{
		$viewParams = [
			'badgeCategory' => $badgeCategory
		];

		return $this->view(
			Addon::shortName('BadgeCategory\Edit'),
			Addon::prefix('badge_category_edit'),
			$viewParams
		);
	}

	protected function badgeCategorySaveProcess(\OzzModz\Badges\Entity\BadgeCategory $badgeCategory)
	{
		$entityInput = $this->filter([
			'icon_type' => 'str',
			'fa_icon' => 'str',
			'mdi_icon' => 'str',
			'image_url' => 'str',
			'image_url_2x' => 'str',
			'image_url_3x' => 'str',
			'image_url_4x' => 'str',
			'class' => 'str',
			'display_order' => 'uint'
		]);

		$form = $this->formAction();
		$form->basicEntitySave($badgeCategory, $entityInput);

		/** @var TitleDescription $plugin */
		$plugin = $this->plugin(Addon::shortName('TitleDescription'));
		$plugin->saveTitle($form, $badgeCategory);

		return $form;
	}

	/**
	 * @param $id
	 * @param null $with
	 * @param null $phraseKey
	 * @return \OzzModz\Badges\Entity\BadgeCategory|\XF\Mvc\Entity\Entity
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertBadgeCategoryExists($id, $with = null, $phraseKey = null)
	{
		if ($id == 0)
		{
			return $this->getBadgeCategoryRepo()->getDefaultCategory();
		}

		return $this->assertRecordExists(Addon::shortName('BadgeCategory'), $id, $with, $phraseKey);
	}

	/**
	 * @return \XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\BadgeCategory
	 */
	protected function getBadgeCategoryRepo()
	{
		return $this->repository(Addon::shortName('BadgeCategory'));
	}
}