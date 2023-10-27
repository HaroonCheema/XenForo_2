<?php

namespace FS\BunnyIntegration\Install\Data;

use XF\Db\Schema\Create;
use XF\Db\Schema\Alter;

class MySql
{
    public function getTables()
    {
        $tables = [];

        $tables['fs_bunny_thread_videos'] = function (Create $table) {
            /** @var Create|Alter $table */
            $table->addColumn('req_id', 'int')->autoIncrement();
            $table->addColumn('thread_id', 'int')->setDefault(0);
            $table->addColumn('bunny_library_id', 'int')->setDefault(0);
            $table->addColumn('bunny_video_id', 'mediumtext')->nullable()->setDefault(null);
            $table->addPrimaryKey('req_id');
        };

        return $tables;
    }

    // protected function _postDelete()
    // {

    //     $app = \xf::app();

    //     $visitor = \XF::visitor();
    //     $app = \XF::app();

    //     $jopParams = [
    //         'threadId' => $this->thread_id,
    //     ];

    //     $jobID = $visitor->user_id . '_deleteBunnyVideo_' . time();

    //     $app->jobManager()->enqueueUnique($jobID, 'FS\BunnyIntegration:DeleteVideo', $jopParams, false);
    //     // $app->jobManager()->runUnique($jobID, 120);

    //     return parent::_postDelete();
    // }
}
