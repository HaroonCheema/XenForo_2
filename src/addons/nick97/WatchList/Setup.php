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

		$this->schemaManager()->alterTable(
			'xf_user_privacy',
			function (Alter $table) {
				$table->addColumn(
					'allow_view_watchlist',
					'ENUM',
					['everyone', 'members', 'followed', 'none']
				)->setDefault('everyone');
				$table->addColumn(
					'allow_view_stats',
					'ENUM',
					['everyone', 'members', 'followed', 'none']
				)->setDefault('everyone');
			}
		);

		$this->alterTable('xf_thread', function (\XF\Db\Schema\Alter $table) {

			$table->addColumn('watch_list', 'int')->setDefault(0);
		});
	}

	public function uninstallStep1()
	{
		$this->db()->delete('xf_connected_account_provider', "provider_id = 'nick_trakt'");

		$this->schemaManager()->alterTable('xf_thread', function (\XF\Db\Schema\Alter $table) {
			$table->dropColumns(['watch_list']);
		});

		$this->schemaManager()->alterTable(
			'xf_user_privacy',
			function (Alter $table) {
				$table->dropColumns([
					'allow_view_watchlist',
					'allow_view_stats',
				]);
			}
		);
	}
}
