<?php

namespace FS\UserProfileAddFields;

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

	public function installstep1()
	{
		$this->alterTable('xf_user_profile', function (Alter $table) {
			$table->addColumn('sotd', 'text');
			$table->addColumn('sotd_img', 'text');
			$table->addColumn('sotd_link', 'text');
			$table->addColumn('sotd_date', 'int');
			$table->addColumn('sotd_hide', 'tinyint');
			$table->addColumn('sotd_streak', 'int');
			$table->addColumn('review_count', 'int');
			$table->addColumn('wardrobe_icon', 'text');
			$table->addColumn('wardrobe_hide', 'int');
		});
	}

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_user_profile', function (Alter $table) {
			$table->dropColumns(['sotd', 'sotd_img', 'sotd_link', 'sotd_date', 'sotd_hide', 'sotd_streak', 'review_count', 'wardrobe_icon', 'wardrobe_hide']);
		});
	}
}
