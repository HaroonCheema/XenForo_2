<?php

namespace FH\RazorpayIntegration;

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

		$sm = $this->schemaManager();

		$sm->alterTable('xf_user_upgrade', function (Alter $table) {
			$table->addColumn('fh_paid_registrations_razorpay', 'int', 10)->setDefault(0);
		});

		$sm->alterTable('xf_user', function (Alter $table) {
			$table->addColumn('razorpay_payment_id', 'varchar', 255)->setDefault('');
		});



		//            $providerClass = 'FH\RazorpayIntegration:Razorpay';
		//
		//            $sql = "INSERT INTO xf_payment_provider
		//                                    (provider_id, provider_class, addon_id)
		//                            VALUES
		//                                    ('razorpay', ?, 'FH/RazorpayIntegration')";
		//
		//             \XF::db()->query($sql,$providerClass);


		$sm->createTable('fh_razorpay_paid_registrations', function (Create $table) {
			$table->addColumn('paid_registrations_id', 'int')->autoIncrement();
			$table->addColumn('user_upgrade_id', 'int');
			$table->addColumn('razorpay_order_id', 'varchar', 255);
			$table->addColumn('razorpay_payment_id', 'varchar', 255);
			$table->addColumn('razorpay_signature', 'text');
			$table->addColumn('date', 'int');
			$table->addColumn('user_upgrade_record_id', 'int');
			$table->addKey('razorpay_order_id');
			$table->addKey('razorpay_payment_id');
		});
	}

	public function uninstallStep1()
	{
		//            $sql = "DELETE FROM xf_payment_provider WHERE provider_id='razorpay'";
		//            \XF::db()->query($sql);
		//            


		$sm = $this->schemaManager();

		$sm->alterTable('xf_user_upgrade', function (Alter $table) {
			$table->dropColumns(['fh_paid_registrations_razorpay']);
		});

		$sm->alterTable('xf_user', function (Alter $table) {
			$table->dropColumns(['razorpay_payment_id']);
		});

		$sm->dropTable('fh_razorpay_paid_registrations');
	}


	public function upgrade1000100Step1()
	{
		$sm = $this->schemaManager();

		$sm->alterTable('xf_user', function (Alter $table) {
			$table->addColumn('razorpay_payment_id', 'varchar', 255)->setDefault('');
		});
	}
}
