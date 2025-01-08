<?php

namespace FS\UserCarDetails\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{

    public function getTables()
    {
        $tables = [];

        $tables['fs_car_models_list'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('model_id', 'int')->autoIncrement();
            $table->addColumn('model', 'mediumtext')->nullable();
            
            $table->addPrimaryKey('model_id');
        };

        return $tables;
    }
}
