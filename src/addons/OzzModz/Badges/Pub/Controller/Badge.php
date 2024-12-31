<?php
/**
 * Badges xF2 addon by CMTV
 * Enjoy!
 */

namespace OzzModz\Badges\Pub\Controller;

use OzzModz\Badges\Addon;
use XF;
use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class Badge extends AbstractController
{
	/**
	 * @param ParameterBag $params
	 * @return XF\Mvc\Reply\AbstractReply|XF\Mvc\Reply\View
	 * @throws XF\Mvc\Reply\Exception
	 */
	public function actionAwardedList(ParameterBag $params)
	{
		$badge = $this->assertBadgeExists($params['badge_id']);

		/** @var \OzzModz\Badges\XF\Entity\User $visitor */
		$visitor = XF::visitor();
		if (!$visitor->canViewAwardedBadgesList())
		{
			return $this->noPermission();
		}

		$page = $this->filterPage();
		$perPage = 20;

		$userBadgesFinder = $this->finder(Addon::shortName('UserBadge'))
			->where('badge_id', $params['badge_id'])
			->limitByPage($page, $perPage);

		$breadcrumbs = [
			[
				'href' => $this->buildLink('help'),
				'value' => XF::phrase('help')
			],
			[
				'href' => $this->buildLink('help/ozzmodz_badges'),
				'value' => Addon::phrase('badges')
			]
		];

		$viewParams = [
			'badge' => $badge,
			'userBadges' => $userBadgesFinder->fetch(),

			'breadcrumbs' => $breadcrumbs,

			'page' => $page,
			'perPage' => $perPage,
			'total' => $userBadgesFinder->total()
		];

		return $this->view(
			Addon::shortName('Badge\AwardedList'),
			Addon::prefix('awarded_list'),
			$viewParams
		);
	}

	/**
	 * @param $id
	 * @param null $with
	 * @param null $phraseKey
	 * @return XF\Mvc\Entity\Entity|\OzzModz\Badges\Entity\Badge
	 * @throws XF\Mvc\Reply\Exception
	 * @noinspection PhpReturnDocTypeMismatchInspection
	 */
	protected function assertBadgeExists($id, $with = null, $phraseKey = null)
	{
		return $this->assertRecordExists(Addon::shortName('Badge'), $id, $with, $phraseKey);
	}
}