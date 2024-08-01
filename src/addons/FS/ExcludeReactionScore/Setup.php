<?php

namespace FS\ExcludeReactionScore;

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

            $sm->alterTable('xf_forum', function (Alter $table) {
                $table->addColumn('count_reactions', 'tinyint', 3)->setDefault(1);
            });
        }

        public function uninstallStep1() 
        {
            $sm = $this->schemaManager();

            $sm->alterTable('xf_forum', function (Alter $table) {
                $table->dropColumns(['count_reactions']);
            });
        }
}