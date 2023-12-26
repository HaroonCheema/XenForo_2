<?php

namespace nick97\TraktIntegration;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	// ################################## INSTALL ###########################################

	public function installStep1()
	{
		$db = $this->db();
		$db->insert('xf_forum_type', [
			'forum_type_id' => 'nick97_trakt_movies',
			// 'handler_class' => 'nick97\TraktIntegration:Movie',
			'handler_class' => 'Snog\Movies:Movie',
			'addon_id' => 'nick97/TraktIntegration'
		]);

		$db->insert('xf_thread_type', [
			'thread_type_id' => 'nick97_trakt_movies',
			'handler_class' => 'nick97\TraktIntegration:Movie',
			// 'handler_class' => 'Snog\Movies:Movie',
			'addon_id' => 'nick97/TraktIntegration'
		]);

		$db->insert('xf_forum_type', [
			'forum_type_id' => 'nick97_trakt_tv',
			// 'handler_class' => 'nick97\TraktIntegration:TV',
			'handler_class' => 'Snog\TV:TV',
			'addon_id' => 'nick97/TraktIntegration'
		]);

		$db->insert('xf_thread_type', [
			'thread_type_id' => 'nick97_trakt_tv',
			'handler_class' => 'nick97\TraktIntegration:TV',
			// 'handler_class' => 'Snog\TV:TV',
			'addon_id' => 'nick97/TraktIntegration'
		]);

		/** @var \XF\Repository\ForumType $forumTypeRepo */
		$forumTypeRepo = $this->app->repository('XF:ForumType');
		$forumTypeRepo->rebuildForumTypeCache();

		/** @var \XF\Repository\ThreadType $threadTypeRepo */
		$threadTypeRepo = $this->app->repository('XF:ThreadType');
		$threadTypeRepo->rebuildThreadTypeCache();
	}

	// ################################## UNINSTALL ###########################################

	public function uninstallStep1()
	{
		$db = $this->db();
		$db->delete('xf_forum_type', 'forum_type_id = ?', 'nick97_trakt_movies');
		$db->delete('xf_thread_type', 'thread_type_id = ?', 'nick97_trakt_movies');

		$db->delete('xf_forum_type', 'forum_type_id = ?', 'nick97_trakt_tv');
		$db->delete('xf_thread_type', 'thread_type_id = ?', 'nick97_trakt_tv');

		/** @var \XF\Repository\ForumType $forumTypeRepo */
		$forumTypeRepo = $this->app->repository('XF:ForumType');
		$forumTypeRepo->rebuildForumTypeCache();

		/** @var \XF\Repository\ThreadType $threadTypeRepo */
		$threadTypeRepo = $this->app->repository('XF:ThreadType');
		$threadTypeRepo->rebuildThreadTypeCache();
	}
}
