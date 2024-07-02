<?php

namespace BS\XFMessenger;

use BS\XFMessenger\Job\Conversation\RebuildUnread;
use BS\XFMessenger\Setup\Upgrade1000270;
use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{
    private const V_DELETE_UNREAD_FIX = 10001070; // 1.0.10

	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

    use Upgrade1000270;

    public function installStep1()
    {
        $sm = $this->schemaManager();
        foreach ($this->getAlterTables() as $tableName => $closures) {
            $sm->alterTable($tableName, $closures['up']);
        }
    }

    public function installStep2()
    {
        $this->updateXfmMessageDateInMessages();

        $this->updateXfmLastMessageDateInConvUsers();

        $this->updateXfmLastReadDateInConvRecipients();
    }

    public function postUpgrade($previousVersion, array &$stateChanges)
    {
        if ($previousVersion < self::V_DELETE_UNREAD_FIX) {
            RebuildUnread::enqueue();
        }
    }

    public function uninstallStep1()
    {
        $sm = $this->schemaManager();
        foreach ($this->getAlterTables() as $tableName => $closures) {
            $sm->alterTable($tableName, $closures['down']);
        }
    }

    protected function getAlterTables()
    {
        $tables = [];

        $tables['xf_conversation_master'] = [
            'up' => static function (Alter $table) {
                $table->addColumn('wallpaper_date', 'int')
                    ->unsigned()
                    ->setDefault(0);
                $table->addColumn('wallpaper_options', 'json')->nullable();
            },
            'down' => static function (Alter $table) {
                $table->dropColumns(['wallpaper_date', 'wallpaper_options']);
            }
        ];

        $tables['xf_conversation_user'] = [
            'up' => static function (Alter $table) {
                $table->addColumn('xfm_last_message_date', 'bigint', 20)
                    ->nullable(false)
                    ->setDefault(0);

                $table->addColumn('unread_count', 'int')->setDefault(0);

                $table->addColumn('room_wallpaper_date', 'int')
                    ->unsigned()
                    ->setDefault(0);
                $table->addColumn('room_wallpaper_options', 'json')->nullable();
            },
            'down' => static function (Alter $table) {
                $table->dropColumns(['unread_count', 'room_wallpaper_date', 'room_wallpaper_options']);
            }
        ];

        $tables['xf_conversation_recipient'] = [
            'up' => static function (Alter $table) {
                $table->addColumn('xfm_last_read_date', 'bigint', 20)
                    ->nullable(false)
                    ->setDefault(0);
            },
            'down' => static function (Alter $table) {
                $table->dropColumns(['xfm_last_read_date']);
            }
        ];

        $tables['xf_conversation_message'] = [
            'up' => static function (Alter $table) {
                $table->addColumn('xfm_message_date', 'bigint', 20)
                    ->nullable(true)
                    ->setDefault(null);
                $table->addColumn('xfm_extra_data', 'json')->nullable();
                $table->addColumn('xfm_has_been_read', 'tinyint', 3)
                    ->unsigned()
                    ->setDefault(0);
                $table->addColumn('xfm_last_edit_date', 'int')
                    ->unsigned()
                    ->setDefault(0);
            },
            'down' => static function (Alter $table) {
                $table->dropColumns(['xfm_message_date', 'xfm_extra_data', 'xfm_has_been_read', 'xfm_last_edit_date']);
            }
        ];

        return $tables;
    }

    public function checkRequirements(&$errors = [], &$warnings = [])
    {
        /** @var \BS\XFMessenger\Service\LicenseChecker $checker */
        $checker = \XF::service('BS\XFMessenger:LicenseChecker');
        if (! $checker->isAllowedAction('install')) {
            $errors[] = 'Please purchase a license for this add-on before installing it.';
        }
    }
}
