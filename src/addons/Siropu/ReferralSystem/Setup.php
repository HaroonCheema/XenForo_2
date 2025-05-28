<?php

namespace Siropu\ReferralSystem;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
use XF\Util\File;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	public function installStep1()
	{
		$this->schemaManager()->alterTable('xf_user', function(Alter $table)
		{
			$table->addColumn('siropu_rs_referrer_id', 'int')->setDefault(0);
			$table->addColumn('siropu_rs_referral_count', 'int')->setDefault(0);
               $table->addColumn('siropu_rs_referral_rewards', 'blob')->nullable();
			$table->addColumn('siropu_rs_referrer_credit', 'tinyint')->setDefault(0);

			$table->addKey('siropu_rs_referrer_id');
			$table->addKey('siropu_rs_referral_count');
		});
	}
	public function installStep2()
	{
		$sm = $this->schemaManager();

		$sm->createTable('xf_siropu_referral_system_referrer_log', function(\XF\Db\Schema\Create $table)
		{
			$table->addColumn('log_id', 'int')->autoIncrement();
			$table->addColumn('user_id', 'int');
			$table->addColumn('url', 'text');
			$table->addColumn('date', 'int')->setDefault(0);
			$table->addKey('user_id');
		});

		$sm->createTable('xf_siropu_referral_system_referral_tool', function(\XF\Db\Schema\Create $table)
		{
			$table->addColumn('tool_id', 'int')->autoIncrement();
			$table->addColumn('name', 'varchar', 255);
			$table->addColumn('type', 'varchar', 20);
			$table->addColumn('content', 'varchar', 255);
			$table->addColumn('size', 'varchar', 10);
			$table->addColumn('target_url', 'varchar', 255);
			$table->addColumn('click_count', 'int')->setDefault(0);
			$table->addColumn('enabled', 'tinyint', 1)->setDefault(1);
		});

          $this->schemaManager()->createTable('xf_siropu_referral_system_reward_type', function(\XF\Db\Schema\Create $table)
          {
               $table->addColumn('reward_type_id', 'int')->autoIncrement();
               $table->addColumn('name', 'varchar', 255);
               $table->addColumn('type', 'varchar', 20);
               $table->addColumn('currency', 'varchar', 50);
          });
	}
     public function installStep3()
	{
          $this->createWidget(
               'siropu_referral_link',
               'siropu_referral_link',
               [
                    'positions' => ['forum_list_sidebar' => 10]
			],
               'Referral link'
		);

          $this->createWidget(
               'siropu_referral_top_referrers',
               'siropu_referral_top_ref',
               [
                    'positions' => ['forum_list_sidebar' => 10]
			],
               'Top referrers'
		);
     }
     public function installStep4()
     {
          $rewardType = \XF::em()->create('Siropu\ReferralSystem:RewardType');
		$rewardType->bulkSet([
			'name' => 'Trophy Points',
			'type' => 'trophy_points'
		]);
		$rewardType->save();
     }
	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_user', function(Alter $table)
		{
			$table->dropColumns([
                    'siropu_rs_referrer_id',
                    'siropu_rs_referral_count',
                    'siropu_rs_referral_rewards',
                    'siropu_rs_referrer_credit'
               ]);
		});
	}
	public function uninstallStep2()
	{
		$sm = $this->schemaManager();

		$sm->dropTable('xf_siropu_referral_system_referrer_log');
		$sm->dropTable('xf_siropu_referral_system_referral_tool');
		$sm->dropTable('xf_siropu_referral_system_reward_type');
	}
     public function uninstallStep3()
     {
          $this->deleteWidget('siropu_referral_link');
          $this->deleteWidget('siropu_referral_top_referrers');
     }
     public function postUpgrade($previousVersion, array &$stateChanges)
	{
          if ($previousVersion < 1000370)
		{
               $job      = 'Siropu\ReferralSystem:Referral';
               $uniqueId = 'RebuildCount' . $job;
               $id       = \XF::app()->jobManager()->enqueueUnique($uniqueId, $job);
               $router   = \XF::app()->router('admin');

               return \XF::app()->response()->redirect(
                    $router->buildLink('tools/run-job', null, ['only_id' => $id, '_xfRedirect' => $router->buildLink('add-ons')])
               );
          }
	}
}
