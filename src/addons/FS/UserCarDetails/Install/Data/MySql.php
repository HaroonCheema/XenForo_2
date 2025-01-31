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

        $tables['fs_car_locations_list'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('location_id', 'int')->autoIncrement();
            $table->addColumn('location', 'mediumtext')->nullable();

            $table->addPrimaryKey('location_id');
        };

        $tables['fs_user_car_details'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('car_id', 'int')->autoIncrement();

            $table->addColumn('username', 'mediumtext')->nullable()->setDefault(null);

            $table->addColumn('model_id', 'int')->setDefault(0);
            $table->addColumn('car_colour', 'mediumtext')->nullable()->setDefault(null);
            $table->addColumn('car_trim', 'mediumtext')->nullable()->setDefault(null);
            $table->addColumn('location_id', 'int')->setDefault(0);
            $table->addColumn('car_plaque_number', 'mediumtext')->nullable()->setDefault(null);
            $table->addColumn('car_reg_number', 'mediumtext')->nullable()->setDefault(null);
            $table->addColumn('car_reg_date', 'int')->setDefault(0);
            $table->addColumn('car_forum_name', 'mediumtext')->nullable()->setDefault(null);
            $table->addColumn('car_unique_information', 'mediumtext')->nullable()->setDefault(null);
            $table->addColumn('updated_at', 'int')->setDefault(0);

            $table->addPrimaryKey('car_id');
        };

        return $tables;
    }
}
