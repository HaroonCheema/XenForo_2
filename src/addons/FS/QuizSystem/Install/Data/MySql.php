<?php

namespace FS\QuizSystem\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql {

    public function getTables() {
        $tables = [];

        $tables['fs_quiz_category'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('category_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 100);
            $table->addColumn('description', 'text');
            $table->addColumn('parent_category_id', 'int')->setDefault(0);
            $table->addColumn('display_order', 'int')->setDefault(0);
            $table->addColumn('field_cache', 'mediumblob');
            $table->addColumn('lft', 'int')->setDefault(0);
            $table->addColumn('rgt', 'int')->setDefault(0);
            $table->addColumn('depth', 'smallint', 5)->setDefault(0);
            $table->addColumn('breadcrumb_data', 'blob');
            $table->addColumn('quiz_count', 'int')->setDefault(0);
            $table->addColumn('layout_type', 'varchar', 20)->setDefault('list_view');
            $table->addKey(['parent_category_id', 'lft']);
            $table->addKey(['lft', 'rgt']);
            $table->addPrimaryKey('category_id');
        };
        
         $tables['fs_quiz_category_field'] = function (Create $table) {
            $table->addColumn('category_id', 'int')->unsigned();
            $table->addColumn('field_id', 'varbinary', 25);
            $table->addPrimaryKey(['category_id', 'field_id']);
        };

       

        return $tables;
    }

    public function getData() {
        $data = [];

        $data['fs_quiz_category'] = "
            INSERT INTO 
                `fs_quiz_category`
                (`category_id`, `title`, `description`, `parent_category_id`, `display_order`, `layout_type`,`lft`, `rgt`, `depth`, `breadcrumb_data`, `quiz_count`, `field_cache`)
             VALUES
                (1, 'Example category', 'This is an example Quiz category.', 0, 100, 'grid_view',3, 6, 0, '[]', 0, '');
        ";
        return $data;
    }
}
