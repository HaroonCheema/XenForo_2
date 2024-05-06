<?php

namespace FS\DisableBbCodes\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_built_in_bb_codes'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('bb_code_id', 'varchar', 100);
            $table->addColumn('usergroup_ids', 'varbinary', 255)->setDefault('');

            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
