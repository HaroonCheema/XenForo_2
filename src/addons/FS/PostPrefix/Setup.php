<?php

namespace FS\PostPrefix;

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
       
            $sm->alterTable('xf_post', function(Alter $table)
            {
                  $table->addColumn('sv_prefix_ids', 'mediumblob')->nullable()->setDefault(null);
            });            
            
            $sm->createTable('fs_post_prefixes', function(Create $table)
            {       
                $table->addColumn('post_id','int', 10);
                $table->addColumn('prefix_id','int', 10);
                
                $table->addPrimaryKey(['post_id', 'prefix_id']);
            });
            
            $this->changeTemplateModificationsStatus(0);
            
        }

        public function uninstallStep1() 
        {
            $sm = $this->schemaManager();

            $sm->alterTable('xf_post', function(Alter $table)
            {
                $table->dropColumns(['sv_prefix_ids']);     
            });
            
            $sm->dropTable('fs_post_prefixes');
            
            $this->changeTemplateModificationsStatus(1);
        }
        
        

        public function changeTemplateModificationsStatus($status)
        {
            $modificationKeys = [
                'sv_multiprefix_forum_post_quick_thread',
                'sv_multiprefix_thread_edit',
                'sv_multiprefix_thread_move'

            ];
            

           $templateModifications =  $this->app()->finder('XF:TemplateModification')->where('modification_key',$modificationKeys)->fetch();
                    
           foreach ($templateModifications as $templateModifications)
           {
               $templateModifications->enabled = $status;
               $templateModifications->save();
           }
           
        }

        public function upgrade1010600Step1()
        {
            $this->db()->update(
                'xf_route', // Table name
                ['format' => ':int<thread_id,title>/:page'],
                'route_type = ? AND route_prefix = ? AND sub_name = ?', 
                ['public', 'threads', ''] 
            );
        }
}