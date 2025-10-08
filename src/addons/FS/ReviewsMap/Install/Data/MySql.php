<?php

namespace FS\ReviewsMap\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_reviewmap'] = function (Create $table) {
            $table->addColumn('reviewmap_id', 'int');
            $table->addColumn('is_active', 'tinyint', 3);
            $table->addColumn('file_count', 'smallint', 5);
            $table->addColumn('entry_count', 'int')->setDefault(0);
            $table->addColumn('is_compressed', 'tinyint', 3);
            $table->addColumn('complete_date', 'int')->nullable();
            $table->addPrimaryKey('reviewmap_id');
            $table->addKey('is_active');
        };

        return $tables;
    }
}
