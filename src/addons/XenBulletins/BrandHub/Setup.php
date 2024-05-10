<?php

namespace XenBulletins\BrandHub;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
use XenBulletins\BrandHub\Install\Data\MySql;

class Setup extends AbstractSetup {

    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;


//    public function installStep2() 
//    {
//        $sm = $this->schemaManager();
//
//    }
   
    
    public function installStep1() 
    {
        $sm = $this->schemaManager();
        
        foreach ($this->getTables() AS $tableName => $closure) {
            $sm->createTable($tableName, $closure);
        }
        
        
        $sm->alterTable('xf_thread', function(Alter $table) 
        {
            $table->addColumn('item_id', 'int')->setDefault(0);
            $table->addColumn('thread_description', 'text')->comment('BrandHub item thread description');
            $table->addKey('item_id');
        });
        
        $sm->alterTable('xf_forum', function(Alter $table) {
             $table->addColumn('brand_id', 'int')->setDefault(0);
        });
        
        $sm->alterTable('xf_attachment', function(Alter $table) {
             $table->addColumn('page_id', 'int')->setDefault(0);
              $table->addColumn('user_id', 'int')->setDefault(0);
              $table->addColumn('item_main_photo', 'int')->setDefault(0);
             $table->addColumn('page_main_photo', 'int')->setDefault(0);
        });
        
        
        $this->createWidget('bh_highest_rated_items', 'highestRatedInCategory', []);
    
      
    }
        
        
    protected function getTables() 
    {
        $data = new MySql();
        
        return $data->getTables();
    }
    
    
    
    public function uninstallStep1() 
    {
        $sm = $this->schemaManager();

        foreach (array_keys($this->getTables()) AS $tableName) {
            $sm->dropTable($tableName);
        }
        
        $sm->alterTable('xf_thread', function(Alter $table) {
             $table->dropColumns(['item_id','thread_description']);
        });
        
        $sm->alterTable('xf_forum', function(Alter $table) {
            $table->dropColumns(['brand_id']);
        });
        
        $sm->alterTable('xf_attachment', function(Alter $table) {
              $table->dropColumns(['page_id','user_id','item_main_photo','page_main_photo']);
        });
        
        
        $this->deleteWidget('bh_highest_rated_items');
        
        $db = \XF::db();
        $sql = "DELETE FROM xf_attachment WHERE content_type='bh_item'";
        $db->query($sql);
        
        $sql = "DELETE FROM xf_bookmark_item WHERE content_type='bh_item'";
        $db->query($sql);
       
        $sql = "DELETE FROM xf_reaction_content WHERE content_type  ='bh_item'";
        $db->query($sql);
        
    }
    
      public function upgrade1010600Step1() {

        $sm = $this->schemaManager();

        $sm->alterTable('xf_attachment', function(Alter $table) {
              $table->addColumn('item_main_photo', 'int')->setDefault(0);
             $table->addColumn('page_main_photo', 'int')->setDefault(0);
        });
    }
    
    public function upgrade1010800Step1() {

        $sm = $this->schemaManager();

        $sm->alterTable('bh_item', function(Alter $table) {
                $table->addColumn('reaction_score', 'int');
                $table->addColumn('reaction_users', 'mediumblob');
                $table->addColumn('reactions', 'mediumblob');
                $table->addColumn('user_id', 'int');
        });
        
        
        $sm->alterTable('bh_item_subscribe', function(Alter $table) {
            $table->addColumn('create_date', 'int');
        });
        
    }
    
    
    
public function upgrade1020000Step1() {

        $sm = $this->schemaManager();

        $sm->alterTable('bh_owner_page', function(Alter $table) {
                $table->addColumn('reaction_score', 'int');
                $table->addColumn('reaction_users', 'mediumblob');
                $table->addColumn('reactions', 'mediumblob');
        });
        
    }
    
    public function upgrade1020700Step1() {

        $sm = $this->schemaManager();

        $sm->alterTable('bh_item', function(Alter $table) {
                 $table->addColumn('brand_title', 'varchar', 100)->setDefault('');
        });
        
        $this->setBrandTitleInItems();
        
    }
    
    public function setBrandTitleInItems()
    {
        $items = \xf::app()->finder('XenBulletins\BrandHub:Item')->fetch();
        foreach ($items as $item)
        {
            $item->fastUpdate('brand_title',$item->Brand->brand_title);
        }
    }

    
    public function upgrade1020900Step1() 
    {
        $sm = $this->schemaManager();

        $sm->alterTable('xf_thread', function(Alter $table) 
        {
            $table->addColumn('thread_description', 'text')->comment('BrandHub item thread description');
        });
    }
   
    public function upgrade3000100Step1() 
    {
        $sm = $this->schemaManager();

        $sm->alterTable('bh_brand', function(Alter $table) 
        {
            $table->addColumn('owner_count', 'int')->after('view_count')->setDefault(0);
        });
        
        $sm->alterTable('bh_item', function(Alter $table) 
        {
            $table->addColumn('owner_count', 'int')->after('view_count')->setDefault(0);
        });
    }
    
    public function upgrade3000800Step1() 
    {
        $sm = $this->schemaManager();

        $sm->alterTable('bh_item_rating', function(Alter $table) 
        {
            $table->addColumn('reaction_score', 'int')->setDefault(0);
            $table->addColumn('reactions', 'blob');
            $table->addColumn('reaction_users', 'blob');
        });
        
        $sm->alterTable('bh_owner_page', function(Alter $table) 
        {
            $table->addColumn('title', 'varchar', 255)->nullable(true)->after('page_id');
        });
        
    }
    
    
    
    public function upgrade3010000Step1() 
    {
        $sm = $this->schemaManager();
        
        $mysqlData = new MySql();
        
        foreach ($mysqlData->getTables3010000() AS $tableName => $closure) 
        {
            $sm->createTable($tableName, $closure);
        }
    }
    
    
    
    public function upgrade3030000Step1() 
    {
        $sm = $this->schemaManager();
        
        
        $sm->alterTable('xf_thread', function(Alter $table) 
        {
            $table->addKey('item_id');
        });
        
        
        $sm->alterTable('bh_owner_page', function(Alter $table) 
        {
            $table->addKey('item_id');
            $table->addKey('user_id');
        });
        
        
        $sm->alterTable('bh_item_subscribe', function(Alter $table) 
        {
            $table->addKey('item_id');
        });
        
        
        $sm->alterTable('bh_page_subscribe', function(Alter $table) 
        {
            $table->addKey('page_id');
        });
        
        
        $sm->alterTable('bh_item', function(Alter $table) 
        {
            $table->addKey('brand_id');
        });
        
        
        $sm->alterTable('bh_brand_description', function(Alter $table) 
        {
            $table->addKey('brand_id');
        });
        
         
        $sm->alterTable('bh_item_description', function(Alter $table) 
        {
            $table->addKey('item_id');
        });
        
        
        $sm->alterTable('bh_item_rating', function(Alter $table) 
        {
            $table->addKey('item_id');
            $table->addKey('user_id');
        });
        
        
        $sm->alterTable('bh_owner_page_detail', function(Alter $table) 
        {
            $table->addKey('page_id');
        });
        
        
        $sm->alterTable('bh_page_count', function(Alter $table) 
        {
            $table->addKey('page_id');
        });
        
        
        
        
        $sm->createTable('bh_item_view', function (Create $table) 
        {
            $table->engine('MEMORY');

            $table->addColumn('item_id', 'int');
            $table->addColumn('total', 'int');
            $table->addPrimaryKey('item_id');
        });
    }
    
    
    
    public function upgrade3040000Step1() 
    {
            $sm = $this->schemaManager();

            $sm->alterTable('bh_item', function(Alter $table)
            {
                    $table->addColumn('tags', 'mediumtext');
            });
    }
	
   
   
}
