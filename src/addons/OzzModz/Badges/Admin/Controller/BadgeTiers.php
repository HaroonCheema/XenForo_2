<?php

namespace OzzModz\Badges\Admin\Controller;

use OzzModz\Badges\Addon;
use OzzModz\Badges\Entity\BadgeTier;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

class BadgeTiers extends \XF\Admin\Controller\AbstractController
{
	protected function preDispatchController($action, ParameterBag $params)
	{
		$this->assertAdminPermission(Addon::prefix());
	}

	public function actionIndex()
	{
		$repo = $this->getBadgeTierRepo();

		$viewParams = [
			'badgeTiers' => $repo->findBadgeTiers()->fetch()
		];

		return $this->view(Addon::shortName('BadgeTiers\List'), Addon::prefix('badge_tier_list'), $viewParams);
	}

	public function badgeTierAddEdit(BadgeTier $badgeTier)
	{
		$viewParams = [
			'badgeTier' => $badgeTier,
		];

		return $this->view(Addon::shortName('BadgeTiers\Edit'), Addon::prefix('badge_tier_edit'), $viewParams);
	}

	public function actionAdd()
	{
		/** @var BadgeTier $badgeTier */
		$badgeTier = $this->em()->create(Addon::shortName('BadgeTier'));
		return $this->badgeTierAddEdit($badgeTier);
	}

	public function actionEdit(ParameterBag $params)
	{
		/** @var BadgeTier $badgeTier */
		$badgeTier = $this->assertBadgeTierExists($params->badge_tier_id);
		return $this->badgeTierAddEdit($badgeTier);
	}

	protected function contentSaveProcess(BadgeTier $badgeTier)
	{
		$form = $this->formAction();

		$input = $this->filter([
			'color' => 'str',
			'css' => 'str',
			'display_order' => 'uint',
		]);

		$form->basicEntitySave($badgeTier, $input);

		$phraseInput = $this->filter([
			'title' => 'str',
		]);

		$form->validate(function (FormAction $form) use ($phraseInput) {
			if ($phraseInput['title'] === '')
			{
				$form->logError(\XF::phrase('please_enter_valid_title'), 'title');
			}
		});

		$form->apply(function () use ($phraseInput, $badgeTier) {
			$phrase = $badgeTier->getMasterTitlePhrase();
			$phrase->phrase_text = $phraseInput['title'];
			$phrase->save();
		});

		return $form;
	}

	/**
	 * @param ParameterBag $params
	 * @return \XF\Mvc\Reply\Redirect
	 * @throws \XF\Mvc\Reply\Exception
	 * @throws \XF\PrintableException
	 */
	public function actionSave(ParameterBag $params)
	{
		if ($params->badge_tier_id)
		{
			$badgeTier = $this->assertBadgeTierExists($params->badge_tier_id);
		}
		else
		{
			/** @var BadgeTier $badgeTier */
			$badgeTier = $this->em()->create(Addon::shortName('BadgeTier'));
		}

		$this->contentSaveProcess($badgeTier)->run();

		return $this->redirect($this->buildLink('ozzmodz-badges-tiers') . $this->buildLinkHash($badgeTier->getEntityId()));
	}

	public function actionDelete(ParameterBag $params)
	{
		/** @var BadgeTier $badgeTier */
		$badgeTier = $this->assertBadgeTierExists($params->badge_tier_id);

		/** @var \XF\ControllerPlugin\Delete $plugin */
		$plugin = $this->plugin('XF:Delete');
		return $plugin->actionDelete(
			$badgeTier,
			$this->buildLink('ozzmodz-badges-tiers/delete', $badgeTier),
			$this->buildLink('ozzmodz-badges-tiers/edit', $badgeTier),
			$this->buildLink('ozzmodz-badges-tiers'),
			$badgeTier->getEntityId()
		);
	}

	/**
	 * @param $id
	 * @param null $with
	 * @param null $phraseKey
	 * @return \XF\Mvc\Entity\Entity|BadgeTier
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertBadgeTierExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists(Addon::shortName('BadgeTier'), $id, $with, $phraseKey);
	}

	/**
	 * @return \XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\BadgeTier
	 */
	protected function getBadgeTierRepo()
	{
		return $this->repository(Addon::shortName('BadgeTier'));
	}
}