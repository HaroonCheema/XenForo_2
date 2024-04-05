<?php

namespace FS\GuestReceiveEmail\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{

    public function getTables()
    {
        $tables = [];

        $tables['fs_guest_email_details'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('guest_id', 'varchar', 120);
            $table->addColumn('thread_id', 'int');
            $table->addColumn('email', 'varchar', 120);
            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
