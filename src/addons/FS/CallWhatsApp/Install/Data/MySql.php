<?php

namespace FS\CallWhatsApp\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        // Log table
        $tables['xf_callwhatsapp_log'] = function (Create $table) {
            $table->addColumn('log_id', 'int')->autoIncrement();
            $table->addColumn('thread_id', 'int')->setDefault(0);
            $table->addColumn('post_id', 'int')->setDefault(0);
            $table->addColumn('phone_number', 'varchar', 255)->nullable(true);
            $table->addColumn('gender', 'enum')->values(['ES', 'TX'])->setDefault('ES');
            $table->addColumn('city', 'varchar', 255)->nullable(true);
            $table->addColumn('action_type', 'enum')->values(['call', 'whatsapp'])->setDefault('whatsapp');
            $table->addColumn('user_id', 'int')->setDefault(0);
            $table->addColumn('username', 'varchar', 100)->nullable(true);
            $table->addColumn('ip_address', 'varchar', 255)->nullable(true);
            $table->addColumn('timestamp', 'int')->setDefault(0);

            $table->addPrimaryKey('log_id');
           
        };

        // Counter per thread
        $tables['xf_callwhatsapp_counter'] = function (Create $table) {
            $table->addColumn('thread_id', 'int');
            $table->addColumn('call_count', 'int')->setDefault(0);
            $table->addColumn('whatsapp_count', 'int')->setDefault(0);

            $table->addPrimaryKey('thread_id');
        };

        return $tables;
    }
}
