<?php

namespace FS\ZoomMeeting\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql {

    public function getTables() {
        
        
        $tables = [];

        $tables['zoom_category'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('category_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 100);
            $table->addColumn('description', 'text');
            $table->addColumn('parent_category_id', 'int')->setDefault(0);
            $table->addColumn('display_order', 'int')->setDefault(0);
            $table->addColumn('field_cache', 'mediumblob')->nullable(true);;
            $table->addColumn('lft', 'int')->setDefault(0);
            $table->addColumn('rgt', 'int')->setDefault(0);
            $table->addColumn('depth', 'smallint', 5)->setDefault(0);
            $table->addColumn('breadcrumb_data', 'blob');
            $table->addColumn('meeting_count', 'int')->setDefault(0);
            $table->addColumn('layout_type', 'varchar', 20)->setDefault('list_view');
            $table->addKey(['parent_category_id', 'lft']);
            $table->addKey(['lft', 'rgt']);
            $table->addPrimaryKey('category_id');
        };
        
         $tables['zoom_category_field'] = function (Create $table) {
            $table->addColumn('category_id', 'int')->unsigned();
            $table->addColumn('field_id', 'varbinary', 25);
            $table->addPrimaryKey(['category_id', 'field_id']);
        };

        
        $tables['zoom_meetings'] = function (Create $table) {
            
            $table->addColumn('meeting_id', 'int')->autoIncrement();
            $table->addColumn('category_id', 'int');
            $table->addColumn('user_id', 'int');
            $table->addColumn('topic', 'varchar', 250)->setDefault('');
            $table->addColumn('description', 'mediumtext')->setDefault(null)->comment('Supports BB code');
            $table->addColumn('start_time', 'int');
            $table->addColumn('duration', 'int');
            $table->addColumn('end_time', 'int');
            $table->addColumn('timezone', 'varchar', 250)->setDefault('');
            $table->addColumn('z_meeting_id', 'mediumtext')->setDefault(null);
            $table->addColumn('z_start_time', 'mediumtext')->setDefault(null);
            $table->addColumn('z_start_url', 'mediumtext')->setDefault(null);
            $table->addColumn('z_join_url', 'mediumtext')->setDefault(null);
            $table->addColumn('forum_id', 'int')->setDefault(0);
            $table->addColumn('thread_id', 'int')->setDefault(0);
            $table->addColumn('join_usergroup_ids', 'varbinary', 255)->setDefault(null);
            $table->addColumn('alert_duration', 'int')->setDefault(0);
            $table->addColumn('is_alerted', 'int')->setDefault(0);
            $table->addColumn('created_date', 'int');
           
         
        };
        
         $tables['zoom_meeting_register'] = function (Create $table) {


            $table->addColumn('log_id', 'int')->autoIncrement();
            $table->addColumn('username', 'mediumtext')->setDefault(null);
            $table->addColumn('email', 'mediumtext')->setDefault(null);
            $table->addColumn('participant_uuid', 'mediumtext')->setDefault(null);
            $table->addColumn('meeting_id', 'mediumtext')->setDefault(null);
            $table->addColumn('is_host', 'int')->setDefault(0);
            $table->addColumn('join_date', 'int')->setDefault(0);
            $table->addColumn('left_date', 'int')->setDefault(0);
            $table->addPrimaryKey('log_id');
        };
        
        
        

        return $tables;
    }

     public function getData() {
        $data = [];

        $data['zoom_category'] = "
            INSERT INTO 
                `zoom_category`
                (`category_id`, `title`, `description`, `parent_category_id`, `display_order`, `layout_type`,`lft`, `rgt`, `depth`, `breadcrumb_data`, `meeting_count`)
             VALUES
                (1, 'Example category', 'This is an example Zoom category.', 0, 100, 'grid_view',3, 6, 0, '[]', 0);
        ";
        return $data;
    }
}
