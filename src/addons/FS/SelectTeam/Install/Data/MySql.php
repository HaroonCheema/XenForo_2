<?php

namespace FS\SelectTeam\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_teams'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 100);
            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
