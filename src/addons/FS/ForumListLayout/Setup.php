<?php

namespace FS\ForumListLayout;

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
      
        $sm->alterTable('xf_user', function(Alter $table) 
        {
             $table->addColumn('node_ids', 'mediumblob')->nullable()->setDefault(null);  
        });
    }
    

    public function uninstallStep1() 
    {
        $sm = $this->schemaManager();
        
        $sm->alterTable('xf_user', function(Alter $table) 
        {
             $table->dropColumns(['node_ids']);
        });
    }
    
    public function upgrade1000500Step1() 
    {            
        $sm = $this->schemaManager();
      
        $sm->alterTable('xf_user', function(Alter $table) 
        {
             $table->addColumn('node_ids', 'mediumblob')->nullable()->setDefault(null);  
        });
    }
   
}