<?php


namespace FS\SwbFemaleVerify\Repository;

use FS\SwbFemaleVerify\Addon;
use XF;
use XF\Entity\User;
use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class FemaleVerify extends Repository
{
	/**
	 * @param null $state
	 * @return Finder|\FS\SwbFemaleVerify\Finder\FemaleVerify
	 */
	public function findFemales()
	{
		$finder = $this->finder('FS\SwbFemaleVerify:FemaleVerification');
		return $finder->setDefaultOrder('id', 'DESC');
	}

	public function rebuildPendingCounts()
	{
		$cache = [
			'total' => $this->db()->fetchOne("
				SELECT COUNT(*) FROM fs_swb_female_verify
				WHERE `female_state`='pending'
			"),
			'lastModified' => time()
		];

		\XF::registry()->set('fsPendingFemalesCount', $cache);
		return $cache;
	}
}
