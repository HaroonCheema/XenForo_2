<?php

namespace FS\ShowIconInNav\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_nav_icon'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('fs_icon_url', 'text');
            $table->addColumn('enabled', 'tinyint')->setDefault(0);
            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
