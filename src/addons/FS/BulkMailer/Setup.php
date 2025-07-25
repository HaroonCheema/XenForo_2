<?php

namespace FS\BulkMailer;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup {

    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    public function installstep1() {

        $this->schemaManager()->createTable('xf_fs_mailing_list', function (Create $table) {
            
            $table->addColumn('mailing_list_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 50)->setDefault('');
            $table->addColumn('subject', 'mediumtext')->nullable(true);
            $table->addColumn('description', 'mediumtext')->nullable(true);
            $table->addColumn('active', 'tinyint', 1)->setDefault(1);
            $table->addColumn('display_order', 'int')->setDefault(10);
            $table->addColumn('owner_id', 'int')->setDefault(0);
            $table->addColumn('from_email', 'varchar', 120)->setDefault('');
            $table->addColumn('from_name', 'varchar', 255)->setDefault('');
            $table->addColumn('type', 'tinyint', 1)->setDefault(0); // 0: file, 1: usergroup
            $table->addColumn('usergroup_ids', 'blob')->nullable();
            $table->addColumn('file_path', 'varchar', 255)->setDefault('');
            $table->addColumn('emails_per_hour', 'int')->setDefault(100);
            $table->addColumn('total_emails', 'int')->setDefault(0);
            $table->addColumn('sent_emails', 'int')->setDefault(0);
            $table->addColumn('failed_emails', 'int')->setDefault(0);
            $table->addColumn('process_status', 'tinyint', 1)->setDefault(0);
            $table->addColumn('next_run', 'int')->setDefault(0);

            $table->addPrimaryKey('mailing_list_id');
        });

        $this->schemaManager()->createTable('xf_fs_mail_queue', function (Create $table) {
            $table->addColumn('queue_id', 'int')->autoIncrement();
            $table->addColumn('mailing_list_id', 'int');
            $table->addColumn('user_id', 'int')->setDefault(0);
            $table->addColumn('email', 'varchar', 120);
            $table->addColumn('status', 'varchar', 20)->setDefault('pending');
            $table->addColumn('send_date', 'int')->nullable();
            $table->addColumn('error_message', 'text')->nullable();
            $table->addColumn('attempts', 'int')->setDefault(0);
            $table->addPrimaryKey('queue_id');
            $table->addKey(['mailing_list_id', 'status']);
        });
    }

    public function uninstallStep1() {
        $sm = $this->schemaManager();

        $sm->dropTable('xf_fs_mailing_list');
        $sm->dropTable('xf_fs_mail_queue');
    }
}
