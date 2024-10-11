<?php

namespace FS\Colour;

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
        $this->schemaManager()->alterTable('xf_node', function(Alter $table)
        {
            $table->addColumn('color_one', 'varchar', 128);
            $table->addColumn('color_two', 'varchar', 128);
        });
        $this->schemaManager()->alterTable('xf_node', function(\XF\Db\Schema\Alter $table) {
            $table->renameColumn('color_one', 'color_title');
            $table->renameColumn('color_two', 'color_code');
        });
    }
    public function uninstallStep1()
    {
        $this->schemaManager()->alterTable('xf_node', function(Alter $table)
        {
            $table->dropColumns('color_title');
            $table->dropColumns('color_code');
        });
    }
}
