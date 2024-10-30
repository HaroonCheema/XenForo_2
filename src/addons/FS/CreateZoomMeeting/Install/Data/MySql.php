<?php

namespace FS\CreateZoomMeeting\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{

    public function getTables()
    {

        $tables = [];

        $tables['fs_zoom_meeting'] = function (Create $table) {

            $table->addColumn('meetingId', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int');
            $table->addColumn('topic', 'varchar', 250)->setDefault('');
            $table->addColumn('description', 'mediumtext')->setDefault(null)->comment('Supports BB code');
            $table->addColumn('start_time', 'int');
            $table->addColumn('duration', 'int');
            $table->addColumn('end_time', 'int');
            $table->addColumn('timezone', 'varchar', 250)->setDefault('');
            $table->addColumn('z_meeting_id', 'mediumtext')->setDefault(null);
            $table->addColumn('z_start_time', 'mediumtext')->setDefault(null);
            $table->addColumn('z_start_url', 'mediumtext')->setDefault(null);
            $table->addColumn('z_join_url', 'mediumtext')->setDefault(null);
            $table->addColumn('forum_id', 'int')->setDefault(0);
            $table->addColumn('thread_id', 'int')->setDefault(0);
            $table->addColumn('join_usergroup_ids', 'varbinary', 255)->setDefault(null);
            $table->addColumn('alert_duration', 'int')->setDefault(0);
            $table->addColumn('is_alerted', 'int')->setDefault(0);
            $table->addColumn('created_date', 'int');
        };

        $tables['fs_zoom_meeting_register'] = function (Create $table) {

            $table->addColumn('log_id', 'int')->autoIncrement();
            $table->addColumn('username', 'mediumtext')->setDefault(null);
            $table->addColumn('email', 'mediumtext')->setDefault(null);
            $table->addColumn('participant_uuid', 'mediumtext')->setDefault(null);
            $table->addColumn('meetingId', 'mediumtext')->setDefault(null);
            $table->addColumn('is_host', 'int')->setDefault(0);
            $table->addColumn('join_date', 'int')->setDefault(0);
            $table->addColumn('left_date', 'int')->setDefault(0);
            $table->addPrimaryKey('log_id');
        };

        return $tables;
    }
}
