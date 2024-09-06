<?php

namespace FS\SwbFemaleVerify\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_swb_female_verify'] = function (Create $table) {
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int');

            $table->addColumn('female_state', 'enum')->values(['pending', 'rejected', 'sent'])->setDefault('pending');
            $table->addColumn('reject_reason', 'varchar', 255)->setDefault('');
            $table->addColumn('create_date', 'int')->setDefault(0);

            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
