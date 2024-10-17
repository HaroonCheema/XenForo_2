<?php

namespace FS\ThreadScoringSystem\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{

    public function getTables()
    {
        $tables = [];

        $tables['fs_thread_scoring_system'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('thread_id', 'int');
            $table->addColumn('user_id', 'int');
            $table->addColumn('points_type', 'varchar', 20);
            $table->addColumn('points', 'int');
            $table->addColumn('percentage', 'int');
            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
