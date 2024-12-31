<?php

namespace OzzModz\Badges\Admin\Controller;

use OzzModz\Badges\Addon;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class UserBadge extends AbstractController
{
	public function actionIndex()
	{
		$page = $this->filterPage();
		$perPage = 20;

		/** @var \OzzModz\Badges\Repository\UserBadge $userBadgeRepo */
		$userBadgeRepo = $this->repository(Addon::shortName('UserBadge'));

		$userBadgeFinder = $userBadgeRepo->findUserBadges()
			->with('User', true)
			->with('AwardingUser')
			->with('Badge', true);

		$this->applyFilters($userBadgeFinder);
		$filters = $this->getFilterInput(true);
		$entries = $userBadgeFinder->limitByPage($page, $perPage);

		$viewParams = [
			'entries' => $entries->fetch(),
			'filters' => $filters,

			'page' => $page,
			'perPage' => $perPage,
			'total' => $entries->total()
		];
		return $this->view(Addon::shortName('UserBadge\Listing'), Addon::prefix('user_badge_list'), $viewParams);
	}

	public function actionRefineSearch()
	{
		/** @var \OzzModz\Badges\Repository\Badge $badgeRepo */
		$badgeRepo = $this->repository(Addon::shortName('Badge'));

		return $this->view(Addon::shortName('UserBadge\RefineSearch'),
			'ozzmodz_badges_user_badge_refine_search', [
				'badgeData' => $badgeRepo->getBadgesOptionsData(),
				'datePresets' => \XF::language()->getDatePresets(),
				'conditions' => $this->getFilterInput(),
			]);
	}

	protected function getFilterInput($removeEmpty = false): array
	{
		$input = $this->filter([
			'username' => 'str',
			'awarded_username' => 'str',
			'badge_id' => 'uint',
			'start' => 'datetime',
			'end' => 'datetime',
		]);

		if ($removeEmpty)
		{
			$input = array_filter($input);
		}

		return $input;
	}

	protected function applyFilters(\OzzModz\Badges\Finder\UserBadge $finder)
	{
		$filters = $this->getFilterInput();

		if ($filters['username'])
		{
			$finder->where('User.username', 'LIKE', $finder->escapeLike($filters['username'], '%?%'));
		}
		if ($filters['awarded_username'])
		{
			$finder->where('AwardingUser.username', 'LIKE', $finder->escapeLike($filters['awarded_username'], '%?%'));
		}

		if ($filters['badge_id'])
		{
			$finder->where('badge_id', '=', $filters['badge_id']);
		}

		if ($filters['start'])
		{
			$finder->where('award_date', '>', $filters['start']);
		}
		if ($filters['end'])
		{
			$finder->where('award_date', '<', $filters['end']);
		}
	}

	public function actionToggle()
	{
		/** @var \XF\ControllerPlugin\Toggle $plugin */
		$plugin = $this->plugin('XF:Toggle');
		return $plugin->actionToggle(Addon::shortName('UserBadge'), 'featured');
	}

	public function actionDelete(ParameterBag $params)
	{
		$userBadge = $this->assertUserBadgeExists($params->user_badge_id);

		/** @var \XF\ControllerPlugin\Delete $deletePlugin */
		$deletePlugin = $this->plugin('XF:Delete');
		return $deletePlugin->actionDelete(
			$userBadge,
			$this->buildLink('ozzmodz-badges-user-badge/delete', $userBadge),
			$this->buildLink('ozzmodz-badges-user-badge'),
			$this->buildLink('ozzmodz-badges-user-badge'),
			$userBadge->getContentTitle()
		);
	}

	public function actionBatchUpdate()
	{
		$this->assertPostOnly();

		$userBadgeIds = $this->filter('user_badge_ids', 'array-uint');
		$total = count($userBadgeIds);

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
				'userBadgeIds' => $userBadgeIds
			];

			return $this->view(
				Addon::shortName('UserBadge\BatchUpdate'),
				Addon::prefix('user_badge_batch_delete_confirm'),
				$viewParams
			);
		}

		$this->app->jobManager()->enqueueUnique('ozzmodzBadgesUserBadgeAction', Addon::shortName('UserBadgeAction'), [
			'total' => $total,
			'actions' => [$action => true],
			'userBadgeIds' => $userBadgeIds,
		]);

		return $this->redirect($this->buildLink('ozzmodz-badges-user-badge', null, ['success' => true]));
	}

	/**
	 * @param $id
	 * @param $with
	 * @param $phraseKey
	 * @return \XF\Mvc\Entity\Entity|\OzzModz\Badges\Entity\UserBadge
	 * @throws \XF\Mvc\Reply\Exception
	 */
	protected function assertUserBadgeExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists(Addon::shortName('UserBadge'), $id, $with, $phraseKey);
	}
}