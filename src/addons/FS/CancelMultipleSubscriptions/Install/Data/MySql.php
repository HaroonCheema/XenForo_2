<?php

namespace FS\CancelMultipleSubscriptions\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_cancel_subscription_user_groups'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int')->setDefault(0);
            $table->addColumn('user_group_id', 'int')->setDefault(0);
            $table->addColumn('end_at', 'int')->setDefault(0);
            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
