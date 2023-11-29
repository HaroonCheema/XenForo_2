<?php

namespace nick97\WatchList;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installStep1()
	{

		$this->db()->insertBulk('xf_connected_account_provider', [
			[
				'provider_id' => 'nick_trakt',
				'provider_class' => 'nick97\\WatchList:Provider\\Trakt',
				'display_order' => 170,
				'options' => '[]'
			]
		], 'provider_id');
	}

	public function installStep2()
	{
		$db = $this->db();
		$db->insert('xf_forum_type', [
			'forum_type_id' => 'nick97_trakt_movie',
			'handler_class' => 'nick97\WatchList:Movie',
			'addon_id' => 'nick97/WatchList'
		]);

		$db->insert('xf_thread_type', [
			'thread_type_id' => 'nick97_trakt_movie',
			'handler_class' => 'nick97\WatchList:Movie',
			'addon_id' => 'nick97/WatchList'
		]);

		$db->insert('xf_forum_type', [
			'forum_type_id' => 'nick97_trakt_tv',
			'handler_class' => 'nick97\WatchList:TV',
			'addon_id' => 'nick97/WatchList'
		]);

		$db->insert('xf_thread_type', [
			'thread_type_id' => 'nick97_trakt_tv',
			'handler_class' => 'nick97\WatchList:TV',
			'addon_id' => 'nick97/WatchList'
		]);

		/** @var \XF\Repository\ForumType $forumTypeRepo */
		$forumTypeRepo = $this->app->repository('XF:ForumType');
		$forumTypeRepo->rebuildForumTypeCache();

		/** @var \XF\Repository\ThreadType $threadTypeRepo */
		$threadTypeRepo = $this->app->repository('XF:ThreadType');
		$threadTypeRepo->rebuildThreadTypeCache();
	}

	public function uninstallStep1()
	{
		$this->db()->delete('xf_connected_account_provider', "provider_id = 'nick_trakt'");
	}

	public function uninstallStep2()
	{
		$db = $this->db();

		$db->delete('xf_forum_type', 'forum_type_id = ?', 'nick97_trakt_movie');
		$db->delete('xf_thread_type', 'thread_type_id = ?', 'nick97_trakt_movie');

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
