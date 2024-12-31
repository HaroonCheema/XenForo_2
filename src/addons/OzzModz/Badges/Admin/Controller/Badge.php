<?php
/**
 * [VersoBit] Badges
 */

namespace OzzModz\Badges\Admin\Controller;

use OzzModz\Badges\Addon;
use OzzModz\Badges\ControllerPlugin\TitleDescription;
use XF;
use XF\Admin\Controller\AbstractController;
use XF\ControllerPlugin\Delete;
use XF\Mvc\FormAction;
use XF\Mvc\ParameterBag;

class Badge extends AbstractController
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
		/** @var \OzzModz\Badges\ControllerPlugin\BadgeList $badgeListPlugin */
		$badgeListPlugin = $this->plugin(Addon::shortName('BadgeList'));

		$viewParams = [
			'totalCategories' => 1 + $this->finder(Addon::shortName('BadgeCategory'))->total(),
			'totalBadges' => $this->finder(Addon::shortName('Badge'))->total(),
			'badgeData' => $badgeListPlugin->getBadgeListData(false),
		];

		return $this->view(
			Addon::shortName('Badge\Listing'),
			Addon::prefix('badge_list'),
			$viewParams
		);
	}

	public function actionAdd()
	{
		/** @var \OzzModz\Badges\Entity\Badge $badge */
		$badge = $this->em()->create(Addon::shortName('Badge'));
		return $this->badgeAddEdit($badge);
	}

	public function actionEdit(ParameterBag $params)
	{
		$badge = $this->assertBadgeExists($params->badge_id);
		return $this->badgeAddEdit($badge);
	}

	protected function badgeAddEdit(\OzzModz\Badges\Entity\Badge $badge)
	{
		$userCriteria = $this->app->criteria('XF:User', $badge->user_criteria);

		/** @var \OzzModz\Badges\Repository\BadgeTier $badgeTierRepo */
		$badgeTierRepo = $this->repository(Addon::shortName('BadgeTier'));

		$badgeRepo = $this->getBadgeRepo();

		// Check if this badge used for stacking
		$stackedBadges = $badgeRepo->findBadgesForList()
			->where('stacking_badge_id', '=', $badge->badge_id)
			->fetch();

		$stackableBadges = $badgeRepo->findBadgesForList()->fetch();

		$viewParams = [
			'badge' => $badge,
			'stackedBadges' => $stackedBadges,
			'stackableBadges' => $stackableBadges,
			'badgeCategories' => $this->getBadgeCategoryRepo()->getBadgeCategoryTitlePairs(),
			'badgeTiers' => $badgeTierRepo->getBadgeTiersOptionsData(),
			'userCriteria' => $userCriteria
		];

		return $this->view(
			Addon::shortName('Badge\Edit'),
			Addon::prefix('badge_edit'),
			$viewParams
		);
	}

	public function actionSave(ParameterBag $params)
	{
		$this->assertPostOnly();

		if ($params->badge_id)
		{
			$badge = $this->assertBadgeExists($params->badge_id);
		}
		else
		{
			$badge = $this->em()->create(Addon::shortName('Badge'));
		}

		$this->badgeSaveProcess($badge)->run();

		return $this->redirect($this->buildLink('ozzmodz-badges'));
	}

	protected function badgeSaveProcess(\OzzModz\Badges\Entity\Badge $badge)
	{
		$badgeInput = $this->filter([
			'user_criteria' => 'array',
			'icon_type' => 'str',
			'fa_icon' => 'str',
			'mdi_icon' => 'str',
			'html_icon' => 'str',
			'image_url' => 'str',
			'image_url_2x' => 'str',
			'image_url_3x' => 'str',
			'image_url_4x' => 'str',
			'class' => 'str',
			'badge_link' => 'str',
			'badge_category_id' => 'uint',
			'badge_tier_id' => 'uint',
			'is_repetitive' => 'bool',
			'repeat_delay' => 'uint',
			'is_revoked' => 'bool',
			'is_manually_awarded' => 'bool',
			'stacking_badge_id' => 'uint',
			'display_order' => 'uint',
			'active' => 'bool'
		]);

		$input = $this->filter([
			'badge_link_attribute_names' => 'array-str',
			'badge_link_attribute_values' => 'array-str'
		]);

		$attributes = [];
		foreach ($input['badge_link_attribute_names'] as $i => $name)
		{
			if (empty($name) || !isset($input['badge_link_attribute_values'][$i]))
			{
				continue;
			}

			$value = $input['badge_link_attribute_values'][$i];
			if (!strlen($value) || !strlen($name))
			{
				continue;
			}

			$attributes[$name] = $value;
		}

		$badge->set('badge_link_attributes', $attributes);

		$form = $this->formAction();
		$form->basicEntitySave($badge, $badgeInput);

		/** @var TitleDescription $plugin */
		$plugin = $this->plugin(Addon::shortName('TitleDescription'));
		$plugin->saveTitleDescription($form, $badge);

		$form->validate(function (FormAction $form) use ($badgeInput, $badge) {
			if (!$badgeInput['icon_type'])
			{
				$form->logError(Addon::phrase('please_select_the_badge_icon_type'), 'icon_type');
			}
			else
			{
				$hasIcon = true;
				switch ($badgeInput['icon_type'])
				{
					case 'fa':
						$hasIcon = !empty($badgeInput['fa_icon']);
						break;
					case 'mdi':
						$hasIcon = !empty($badgeInput['mdi_icon']);
						break;
					case 'html':
						$hasIcon = !empty($badgeInput['html_icon']);
						break;
					case 'asset':
					case 'image':
						$hasIcon = !empty($badgeInput['image_url']);
						break;
				}

				if (!$hasIcon)
				{
					$form->logError(Addon::phrase('please_specify_a_badge_icon_value'));
				}
			}
		});

		return $form;
	}

	public function actionDelete(ParameterBag $params)
	{
		$badge = $this->assertBadgeExists($params->badge_id);

		/** @var Delete $plugin */
		$plugin = $this->plugin('XF:Delete');

		return $plugin->actionDelete(
			$badge,
			$this->buildLink('ozzmodz-badges/delete', $badge),
			$this->buildLink('ozzmodz-badges/edit', $badge),
			$this->buildLink('ozzmodz-badges'),
			$badge->title
		);
	}

	public function actionSort()
	{
		if ($this->isPost())
		{
			$badges = $this->finder(Addon::shortName('Badge'))->fetch();

			foreach ($this->filter('badges', 'array-json-array') as $badgesInCategory)
			{
				$lastOrder = 0;

				foreach ($badgesInCategory as $badgeValue)
				{
					if (!isset($badgeValue['id']) || !isset($badges[$badgeValue['id']]))
					{
						continue;
					}

					$lastOrder += 10;

					/** @var \OzzModz\Badges\Entity\Badge $badge */
					$badge = $badges[$badgeValue['id']];
					$badge->badge_category_id = $badgeValue['parent_id'];
					$badge->display_order = $lastOrder;
					$badge->saveIfChanged();
				}
			}

			return $this->redirect($this->buildLink('ozzmodz-badges'));
		}

		/** @var \OzzModz\Badges\ControllerPlugin\BadgeList $badgeListPlugin */
		$badgeListPlugin = $this->plugin(Addon::shortName('BadgeList'));

		$viewParams = [
			'badgeData' => $badgeListPlugin->getBadgeListData()
		];

		return $this->view(
			Addon::shortName('Badge\Sort'),
			Addon::prefix('badge_sort'),
			$viewParams
		);
	}

	public function actionImport()
	{
		/** @var \XF\ControllerPlugin\Xml $exportPlugin */
		$exportPlugin = $this->plugin('XF:Xml');
		return $exportPlugin->actionImport('ozzmodz-badges', 'badges_export', Addon::shortName('Import'));
	}

	public function actionExport()
	{
		$badgeIds = $this->filter('badge_ids', 'array-uint');
		if ($this->isPost() && !$this->filter('action', 'str'))
		{
			$badges = $this->finder(Addon::shortName('Badge'))
				->where('badge_id', $badgeIds)
				->order(['Category.display_order', 'display_order']);

			/** @var \XF\ControllerPlugin\Xml $exportPlugin */
			$exportPlugin = $this->plugin('XF:Xml');

			return $exportPlugin->actionExport($badges, Addon::shortName('Export'), Addon::shortName('Badge\Export'));
		}

		$viewParams = [
			'badgeIds' => $badgeIds,
		];

		return $this->view(
			Addon::shortName('Badge\Export'),
			Addon::prefix('badge_export'),
			$viewParams
		);
	}

	// Batch actions

	public function actionBatchUpdate()
	{
		$this->assertPostOnly();

		$badgeIds = $this->filter('badge_ids', 'array-uint');
		$total = count($badgeIds);

		if (!$total)
		{
			throw $this->exception($this->error(\XF::phraseDeferred(Addon::phrase('please_select_at_least_one_badge'))));
		}

		$action = $this->filter('action', 'str');
		if ($action == 'export')
		{
			return $this->rerouteController(__CLASS__, 'export');
		}
		elseif (!$this->request->exists('action_confirm') && $action == 'delete')
		{
			$viewParams = [
				'total' => $total,
				'badgeIds' => $badgeIds
			];

			return $this->view(
				Addon::shortName('Badges\BatchUpdate'),
				Addon::prefix('badge_batch_delete_confirm'),
				$viewParams
			);
		}

		$this->app->jobManager()->enqueueUnique('ozzmodzBadgesAction', Addon::shortName('BadgeAction'), [
			'total' => $total,
			'actions' => [$action => true],
			'badgeIds' => $badgeIds,
		]);

		return $this->redirect($this->buildLink('ozzmodz-badges', null, ['success' => true]));
	}

	// Batch award

	protected function getSearcherParams()
	{
		$searcher = $this->searcher('XF:User');

		$viewParams = [
			'criteria' => $searcher->getFormCriteria(),
			'sortOrders' => $searcher->getOrderOptions()
		];
		return $viewParams + $searcher->getFormData();
	}

	/**
	 * @throws XF\Mvc\Reply\Exception
	 */
	protected function prepareAwardData()
	{
		$input = $this->filter([
			'badge_id' => 'uint',

			'reason' => 'str',
			'avoid_duplicates' => 'bool',
		]);

		$badge = null;
		if ($input['badge_id'])
		{
			$badge = $this->assertBadgeExists($input['badge_id']);
		}

		/** @var \XF\ControllerPlugin\UserCriteriaAction $userCriteriaActionPlugin */
		$userCriteriaActionPlugin = $this->plugin('XF:UserCriteriaAction');
		$data = $userCriteriaActionPlugin->getInitializedSearchData();
		$data['input'] = $input;
		$data['badge'] = $badge;

		return $data;
	}

	public function actionAward()
	{
		$this->setSectionContext('ozzmodz_badges');

		$badgeRepo = $this->getBadgeRepo();
		$badges = $badgeRepo->findBadgesForList()->fetch();
		$badges = $badges->filter(function (\OzzModz\Badges\Entity\Badge $badge) {
			return $badge->isAwardable();
		});

		$categories = $this->getBadgeCategoryRepo()->getBadgeCategoriesForList(true);

		/** @var \OzzModz\Badges\ControllerPlugin\BadgeList $badgeListPlugin */
		$badgeListPlugin = $this->plugin(Addon::shortName('BadgeList'));
		$badgeData = $badgeListPlugin->getBadgeListDataParams($badges, $categories);

		$viewParams = [
				'badgeData' => $badgeData,
				'awarded' => $this->filter('awarded', 'uint')
			] + $this->getSearcherParams();

		return $this->view(Addon::shortName('Badges\Award'), Addon::prefix('badge_award'), $viewParams);
	}

	public function actionAwardConfirm()
	{
		$this->setSectionContext('ozzmodz_badges');

		$this->assertPostOnly();

		$data = $this->prepareAwardData();

		$viewParams = [
			'input' => $data['input'],
			'badge' => $data['badge'],
			'total' => $data['total'],
			'criteria' => $data['criteria']
		];
		return $this->view(Addon::shortName('Badges\AwardConfirm'), Addon::prefix('badge_award_confirm'), $viewParams);
	}

	public function actionAwardSubmit()
	{
		$this->setSectionContext('ozzmodz_badges');

		$this->assertPostOnly();

		$data = $this->prepareAwardData();

		$this->app->jobManager()->enqueueUnique('ozzmodzBadgesAward', Addon::shortName('UserBadgeAward'), [
			'criteria' => $data['criteria'],
			'input' => $data['input']
		]);

		return $this->redirect($this->buildLink(
			'ozzmodz-badges/award', null, ['awarded' => $data['total']]
		));
	}

	// Batch unaward

	/**
	 * @throws XF\Mvc\Reply\Exception
	 */
	protected function prepareUnawardData()
	{
		$input = $this->filter([
			'badge_ids' => 'array-uint',
		]);

		if (empty($input['badge_ids']))
		{
			throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
		}

		/** @var \XF\ControllerPlugin\UserCriteriaAction $userCriteriaActionPlugin */
		$userCriteriaActionPlugin = $this->plugin('XF:UserCriteriaAction');
		$data = $userCriteriaActionPlugin->getInitializedSearchData(['ozzmodz_badges_badge_ids' => $input['badge_ids']]);
		$data['input'] = $input;

		return $data;
	}

	public function actionUnaward()
	{
		$this->setSectionContext('ozzmodz_badges');

		$badgeRepo = $this->getBadgeRepo();
		$badges = $badgeRepo->findBadgesForList()->fetch();
		$badges = $badges->filter(function (\OzzModz\Badges\Entity\Badge $badge) {
			return $badge->isAwardable();
		});

		$categories = $this->getBadgeCategoryRepo()->getBadgeCategoriesForList(true);

		/** @var \OzzModz\Badges\ControllerPlugin\BadgeList $badgeListPlugin */
		$badgeListPlugin = $this->plugin(Addon::shortName('BadgeList'));
		$badgeData = $badgeListPlugin->getBadgeListDataParams($badges, $categories);

		$viewParams = [
				'badgeData' => $badgeData,
				'unawarded' => $this->filter('unawarded', 'uint')
			] + $this->getSearcherParams();

		return $this->view(Addon::shortName('Badges\Unaward'), Addon::prefix('badge_unaward'), $viewParams);
	}

	public function actionUnawardConfirm()
	{
		$this->setSectionContext('ozzmodz_badges');

		$this->assertPostOnly();
		$data = $this->prepareUnawardData();

		$viewParams = [
			'input' => $data['input'],
			'total' => $data['total'],
			'criteria' => $data['criteria']
		];
		return $this->view(Addon::shortName('Badges\UnawardConfirm'), Addon::prefix('badge_unaward_confirm'), $viewParams);
	}

	public function actionUnawardSubmit()
	{
		$this->setSectionContext('ozzmodz_badges');

		$this->assertPostOnly();
		$data = $this->prepareUnawardData();

		$this->app->jobManager()->enqueueUnique('ozzmodzBadgesUnaward', Addon::shortName('UserBadgeUnaward'), [
			'criteria' => $data['criteria'],
			'input' => $data['input']
		]);

		return $this->redirect($this->buildLink(
			'ozzmodz-badges/unaward', null, ['unawarded' => $data['total']]
		));
	}

	/**
	 * @param $id
	 * @param null $with
	 * @param null $phraseKey
	 * @return \XF\Mvc\Entity\Entity|\OzzModz\Badges\Entity\Badge
	 * @throws XF\Mvc\Reply\Exception
	 */
	protected function assertBadgeExists($id, $with = null)
	{
		return $this->assertRecordExists(Addon::shortName('Badge'), $id, $with, Addon::prefix('requested_badge_not_found'));
	}

	/**
	 * @return XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\Badge
	 */
	protected function getBadgeRepo()
	{
		return $this->repository(Addon::shortName('Badge'));
	}

	/**
	 * @return XF\Mvc\Entity\Repository|\OzzModz\Badges\Repository\BadgeCategory
	 */
	protected function getBadgeCategoryRepo()
	{
		return $this->repository(Addon::shortName('BadgeCategory'));
	}
}