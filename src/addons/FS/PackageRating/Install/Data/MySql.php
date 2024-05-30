<?php

namespace FS\PackageRating\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_user_upgrade_rating'] = function (Create $table) {
            $table->addColumn('rating_id', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int');
            $table->addColumn('rating', 'tinyint');
            $table->addColumn('rating_date', 'int');
            $table->addColumn('message', 'mediumtext');
            $table->addColumn('user_upgrade_id', 'int');
            $table->addPrimaryKey('rating_id');
        };

        return $tables;
    }
}
