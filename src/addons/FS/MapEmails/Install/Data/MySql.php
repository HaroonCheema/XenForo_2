<?php

namespace FS\MapEmails\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        // $tables['fs_username_map'] = function (Create $table) {
        //     /** @var Create|Alter $table */
        //     $table->addColumn('user_id', 'int')->setDefault(0);
        //     $table->addColumn('username_old', 'varchar', 50)->setDefault('');
        //     $table->addColumn('email_old', 'varchar', 120)->setDefault('');
        //     $table->addColumn('username_new', 'varchar', 300)->setDefault('');
        //     $table->addColumn('email_new', 'varchar', 350)->setDefault('');

        //     $table->addPrimaryKey('user_id');
        // };

        return $tables;
    }
}
