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
            $table->addColumn('points', 'decimal', '65,8')->unsigned(false)->setDefault(0);
            $table->addColumn('percentage', 'decimal', '65,8')->unsigned(false)->setDefault(0);

            $table->addPrimaryKey('id');
        };

        $tables['fs_thread_total_scoring_system'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int');
            $table->addColumn('threads_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);
            $table->addColumn('reply_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);
            $table->addColumn('worlds_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);
            $table->addColumn('reactions_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);
            $table->addColumn('solutions_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);
            $table->addColumn('total_score', 'decimal', '65,8')->unsigned(false)->setDefault(0);

            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
