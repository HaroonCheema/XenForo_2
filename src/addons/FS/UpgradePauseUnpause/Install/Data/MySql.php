<?php

namespace FS\UpgradePauseUnpause\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_user_upgrade_pause_unpause'] = function (Create $table) {
            $table->addColumn('user_upgrade_record_id', 'int');
            $table->addColumn('user_id', 'int');
            $table->addColumn('created_at', 'int')->setDefault(0);

            $table->addPrimaryKey('user_upgrade_record_id');
            $table->addKey('created_at');
        };

        $tables['fs_alert_pause_unpause'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int');

            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
