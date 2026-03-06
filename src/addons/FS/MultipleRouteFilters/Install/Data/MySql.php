<?php

namespace FS\MultipleRouteFilters\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_multi_route_filter'] = function (Create $table) {
            $table->addColumn('route_filter_id', 'int')->autoIncrement();
            $table->addColumn('prefix', 'varchar', 25);
            $table->addColumn('find_route', 'varchar', 255);
            $table->addColumn('replace_route', 'varchar', 255);
            $table->addColumn('enabled', 'tinyint', 3)->setDefault(0);
            $table->addColumn('url_to_route_only', 'tinyint', 3)->setDefault(0);
            $table->addColumn('parent_route_filter_id', 'int')->setDefault(0);
            $table->addKey('prefix', 'route_type_prefix');
        };

        return $tables;
    }
}
