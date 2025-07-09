<?php

namespace FS\DiscussionThread;

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
		$this->alterTable('xf_node', function (\XF\Db\Schema\Alter $table)
		{
			$table->addColumn('disc_node_id', 'int')->setDefault(0);
		});

		$this->alterTable('xf_thread', function (\XF\Db\Schema\Alter $table)
		{
			$table->addColumn('disc_thread_id', 'int')->setDefault(0);
			$table->addColumn('main_thread_ids', 'text')->nullable();
		});
    }

    public function upgrade1000100Step1()
    {
		$this->alterTable('xf_thread', function (\XF\Db\Schema\Alter $table)
		{
			$table->dropColumns(['disc_thread_id']);

			$table->addColumn('disc_thread_id', 'int')->setDefault(0);
			$table->addColumn('main_thread_ids', 'text')->nullable();
		});
	}

	public function uninstallStep1()
	{
        $this->alterTable('xf_node', function(Alter $table)
        {
            $table->dropColumns(['disc_node_id']);
        });

        $this->alterTable('xf_thread', function(Alter $table)
        {
            $table->dropColumns(['disc_thread_id','main_thread_ids']);
        });
	}
}