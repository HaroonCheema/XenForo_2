<?php

namespace FS\BanUserChanges\XF\Service\Thread;

class Creator extends XFCP_Creator
{
    public function setBannedUser(\XF\Entity\User $user)
	{
		$this->user = $user;

		$this->thread->user_id = $user->user_id;
		$this->thread->username = $user->username;

		$this->post->user_id = $user->user_id;
		$this->post->username = $user->username;
	}
}
