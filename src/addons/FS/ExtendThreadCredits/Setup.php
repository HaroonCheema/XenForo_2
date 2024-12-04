<?php

namespace FS\ExtendThreadCredits;

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
		$this->createTable('xf_deleted_user_purchase_log', function (\XF\Db\Schema\Create $table) {
			$table->addColumn('id', 'int')->autoIncrement();
			$table->addColumn('package_name', 'varchar', 50)->setDefault(''); 
			$table->addColumn('visitor_id', 'int')->setDefault(0); 
			$table->addColumn('reason_of_deletion', 'varchar', 255)->nullable();
			$table->addColumn('time', 'int')->setDefault(0); 
			$table->addColumn('user_credit_package_id', 'int')->setDefault(0); 
			$table->addColumn('credit_package_id', 'int')->nullable()->setDefault(NULL); 
			$table->addColumn('user_id', 'int')->setDefault(0); 
			$table->addColumn('purchase_request_key', 'varchar', 32)->nullable()->setDefault(NULL); 
			$table->addColumn('extra', 'blob');
			$table->addColumn('total_credits', 'int')->setDefault(0); 
			$table->addColumn('used_credits', 'int')->setDefault(0);
			$table->addColumn('remaining_credits', 'int')->setDefault(0); 
			$table->addColumn('purchased_at', 'int')->setDefault(0); 
			$table->addColumn('expires_at', 'int')->setDefault(0); 
		
			// Add an index for user_id
			$table->addKey('user_id', 'user_id');
		});
	}
	public function installStep2()
    {
        $this->schemaManager()->alterTable('xf_user', function(Alter $table)
        {
            $table->addColumn('special_credit', 'int')->setDefault(0);
        });
    }
	public function installStep3()
{
    $this->createTable('xf_user_special_credit_log', function (\XF\Db\Schema\Create $table) {
        $table->addColumn('user_special_credit_id', 'int')->autoIncrement();
        $table->addColumn('user_id', 'int');
		$table->addColumn('moderator_id', 'int')->setDefault(0);
		$table->addColumn('given_at', 'int')->setDefault(0);
        $table->addColumn('reason', 'varchar', 255)->nullable();     
        // Add foreign keys
        $table->addKey('user_id', 'user_id');

    });
}
public function uninstallStep1()
{
	$this->schemaManager()->dropTable('xf_deleted_user_purchase_log');
}

public function uninstallStep2()
{
	$this->schemaManager()->dropTable('xf_user_special_credit_log');
}

public function uninstallStep3()
{
	$this->schemaManager()->alterTable('xf_user', function (Alter $table) {
		$table->dropColumns(['special_credit']);
	});
}
}

