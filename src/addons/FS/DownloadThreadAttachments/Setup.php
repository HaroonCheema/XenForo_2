<?php

namespace FS\DownloadThreadAttachments;

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
             $this->alterTables(); 
	}

	public function uninstallStep1()
	{
                $sm = $this->schemaManager();

                $sm->alterTable('xf_user_group', function(Alter $table)
                {
                    $table->dropColumns(['download_size_limit', 'daily_download_size_limit', 'weekly_download_size_limit']);
                });
                
                $sm->alterTable('xf_user', function(Alter $table)
                {
                    $table->dropColumns(['daily_download_size', 'weekly_download_size','overall_download_size']);
                });
	}
        
        
        public function alterTables()
        {
            $sm = $this->schemaManager();
                
            $sm->alterTable('xf_user_group', function(Alter $table)
            {
                $table->addColumn('download_size_limit', 'tinyint', 3)->unsigned()->setDefault(0)->comment('size in gigaBytes');
                $table->addColumn('daily_download_size_limit', 'tinyint', 3)->unsigned()->setDefault(0)->comment('size in gigaBytes');
                $table->addColumn('weekly_download_size_limit', 'tinyint', 3)->unsigned()->setDefault(0)->comment('size in gigaBytes');
            });
            
            $sm->alterTable('xf_user', function(Alter $table)
            {
                $table->addColumn('daily_download_size', 'bigint')->setDefault(0)->comment('size in bytes');
                $table->addColumn('weekly_download_size', 'bigint')->setDefault(0)->comment('size in bytes');
                $table->addColumn('overall_download_size', 'bigint')->setDefault(0)->comment('size in bytes');
            });
        }
        

        public function upgrade1000400Step1() 
        {            
            $this->alterTables(); 
        }
        
        
        public function upgrade1000500Step1() 
        {            
            $sm = $this->schemaManager();

            $sm->alterTable('xf_user_group', function(Alter $table)
            {
                $table->addColumn('download_size_limit', 'tinyint', 3)->unsigned()->setDefault(0)->comment('size in gigaBytes');
            });
        }
       
        
}