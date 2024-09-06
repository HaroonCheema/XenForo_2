<?php


namespace FS\SwbFemaleVerify\Finder;


use XF\Entity\User;
use XF\Mvc\Entity\Finder;

class FemaleVerify extends Finder
{
	public function byUser($userId)
	{
		if ($userId instanceof User) {
			$userId = $userId->user_id;
		}

		$this->where('user_id', '=', $userId);
		return $this;
	}

	public function onlyPending()
	{
		$this->where('female_state', '=', 'pending');
		return $this;
	}
}
