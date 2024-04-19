<?php

namespace FS\InfoText\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_info_text'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('word', 'varchar', 50);
            $table->addColumn('link', 'text');
            $table->addColumn('agency', 'text');

            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
