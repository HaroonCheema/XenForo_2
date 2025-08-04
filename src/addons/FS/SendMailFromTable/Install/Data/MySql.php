<?php

namespace FS\SendMailFromTable\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_mid_night_emails'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();

            $table->addColumn('email', 'varchar', 120);
            $table->addColumn('phone_no', 'varchar', 20)->setDefault('');
            $table->addColumn('date', 'int')->setDefault(0);
            $table->addColumn('is_pending', 'tinyint', 3)->setDefault(1);

            $table->addPrimaryKey('id');
        };

        $tables['fs_cron_emails_log'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();

            $table->addColumn('to', 'int')->setDefault(0);
            $table->addColumn('email_ids', 'mediumblob');

            $table->addPrimaryKey('id');
        };

        $tables['fs_email_templates'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();

            $table->addColumn('title', 'varchar', 100);
            $table->addColumn('email_body', 'text');

            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
