<?php

namespace FS\LogoSlider\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_logo_slider'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('logo_url', 'text');
            $table->addPrimaryKey('id');
        };

        return $tables;
    }
}
