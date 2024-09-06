<?php

namespace FS\SwbFemaleVerify;

/**
 * Class Listener
 *
 * @package FS\SwbFemaleVerify
 */
class Listener
{

	/**
	 * Called after the global \XF\App object has been setup. This will fire regardless of the
	 * application type.
	 *
	 * @param \XF\App $app Global App object.
	 * @throws \XF\Db\Exception
	 */
	public static function appSetup(\XF\App $app)
	{
		$container = $app->container();

		$container['fsPendingFemalesCount'] = $app->fromRegistry(
			'fsPendingFemalesCount',
			function (\XF\Container $c) {
				/** @var \FS\SwbFemaleVerify\Repository\FemaleVerify $storeRepo */
				$storeRepo = $c['em']->getRepository(Addon::shortName('FemaleVerify'));
				return $storeRepo->rebuildPendingCounts();
			}
		);
	}


	/**
	 * Called at the end of the the Public \XF\Pub\App object startup process.
	 *
	 * @param \XF\Pub\App $app Public App object.
	 */
	public static function appPubStartEnd(\XF\Pub\App $app)
	{
		$visitor = \XF::visitor();
		if ($visitor->is_admin || $visitor->is_moderator) {
			$session = $app->session();
			$registryWithdrawCounts = $app->container()->fsPendingFemalesCount;
			$session->fsPendingFemalesCount = $registryWithdrawCounts;
		}
	}
}
