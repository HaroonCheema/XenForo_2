<?php

namespace FS\YtVideoSlider\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_yt_video_slider'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('video_id', 'int')->autoIncrement();

            $table->addColumn('title', 'varchar', 255);
            $table->addColumn('type', 'tinyint')->setDefault(0);
            $table->addColumn('url', 'varchar', 255);
            $table->addColumn('thumbnail', 'varchar', 255);
            $table->addColumn('attachment_id', 'int')->setDefault(null);

            $table->addPrimaryKey('video_id');
        };

        return $tables;
    }
}
