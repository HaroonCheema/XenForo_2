<?php

namespace FS\UserGroupBatch\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_usergroup_batch'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('batch_id', 'int')->autoIncrement();

            $table->addColumn('title', 'varchar', 100);
            $table->addColumn('desc', 'text');
            $table->addColumn('img_path', 'text');
            $table->addColumn('type_repeat', 'int');
            $table->addColumn('mini_post', 'int');
            $table->addColumn('usergroup_ids', 'varbinary', 255);

            $table->addPrimaryKey('batch_id');
        };

        return $tables;
    }
}
