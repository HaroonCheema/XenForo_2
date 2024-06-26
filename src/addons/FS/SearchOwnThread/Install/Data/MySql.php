<?php

namespace FS\SearchOwnThread\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_search_own_thread_list'] = function (Create $table) {
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 50);
            $table->addColumn('description', 'text');
            $table->addColumn('url_portion', 'text');
            $table->addColumn('newer_than', 'text');
            $table->addColumn('older_than', 'text');
            $table->addColumn('min_reply_count', 'int')->setDefault(0);
            $table->addColumn('prefixes', 'mediumblob');
            $table->addColumn('nodes', 'mediumblob');
            $table->addColumn('order', 'text');
            $table->addColumn('display_order', 'int')->setDefault(1);
            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
