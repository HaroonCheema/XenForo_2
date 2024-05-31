<?php

namespace FS\GameReviews\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_game'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('game_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 100);
            $table->addColumn('description', 'text');
            $table->addPrimaryKey('game_id');
        };

        $tables['fs_game_reviews'] = function (Create $table) {
            $table->addColumn('review_id', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int');
            $table->addColumn('rating', 'tinyint');
            $table->addColumn('rating_date', 'int');
            $table->addColumn('message', 'mediumtext');
            $table->addColumn('game_id', 'int');
            $table->addPrimaryKey('review_id');
        };

        return $tables;
    }
}
