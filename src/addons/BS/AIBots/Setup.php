<?php

namespace BS\AIBots;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

    public function installStep1()
    {
        $sm = $this->schemaManager();
        foreach ($this->getTables() as $tableName => $closure) {
            $sm->createTable($tableName, $closure);
        }
    }

    public function installStep2()
    {
        $sm = $this->schemaManager();
        foreach ($this->getAlterTables() as $tableName => $closure) {
            $sm->alterTable($tableName, $closure[0]);
        }
    }

    public function checkRequirements(&$errors = [], &$warnings = [])
    {
        /** @var \BS\AIBots\Service\LicenseChecker $checker */
        $checker = \XF::service('BS\AIBots:LicenseChecker');
        if (! $checker->isAllowedAction('install')) {
            $errors[] = 'Please purchase a license for this add-on before installing it.';
        }
    }

    public function postUpgrade($previousVersion, array &$stateChanges)
    {
        $actionData = [
            'previous_version' => $previousVersion,
            'current_version' => $this->addOn->getJsonVersion()
        ];
        $this->assertLicenceAllowed('upgrade', $actionData);
    }

    public function postRebuild()
    {
        $this->assertLicenceAllowed('rebuild');

        // clear gpt-3.5 OS requirements cache
        \XF::registry()->offsetUnset('bsAibGptRequirementsFn');
    }

    protected function assertLicenceAllowed(string $action, array $actionData = []): void
    {
        /** @var \BS\AIBots\Service\LicenseChecker $checker */
        $checker = \XF::service('BS\AIBots:LicenseChecker');
        if (! $checker->isAllowedAction($action, $actionData)) {
            \XF::registry()->set('bsAIBotsLicense', false);
        } else {
            \XF::registry()->offsetUnset('bsAIBotsLicense');
        }
    }

    public function uninstallStep1()
    {
        $sm = $this->schemaManager();
        foreach (array_keys($this->getTables()) as $tableName) {
            $sm->dropTable($tableName);
        }
    }

    public function uninstallStep2()
    {
        $sm = $this->schemaManager();
        foreach ($this->getAlterTables() AS $tableName => $closure) {
            $sm->alterTable($tableName, $closure[1]);
        }
    }

    public function uninstallStep3()
    {
        \XF::registry()->offsetUnset('bsAIBotsLicense');
    }

    /*
     * Tables definition
     */
    protected function getTables()
    {
        $tables = [];

        $tables['xf_bs_ai_bot'] = static function (Create $table) {
            $table->addColumn('bot_id', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int');
            $table->addColumn('username', 'varchar', 50);
            $table->addColumn('is_active', 'tinyint', 1)->setDefault(1);
            $table->addColumn('extra_user_group_ids', 'varbinary', 255)
                ->nullable()
                ->setDefault(null);
            $table->addColumn('general', 'json')->nullable()->setDefault(null);
            $table->addColumn('triggers', 'json')->nullable()->setDefault(null);
            $table->addColumn('restrictions', 'json')->nullable()->setDefault(null);
            $table->addColumn('bot_class', 'text');
            $table->addKey('user_id');
        };

        $tables['xf_bs_ai_bot_reply_log'] = static function (Create $table) {
            $table->addColumn('log_id', 'int')->autoIncrement();
            $table->addColumn('to_user_id', 'int');
            $table->addColumn('reply_date', 'int');
            $table->addColumn('content_type', 'varbinary', 25);
            $table->addColumn('content_id', 'int');
            $table->addColumn('bot_id', 'int');
            $table->addKey('bot_id');
            $table->addKey('to_user_id');
            $table->addKey('content_type');
            $table->addKey('content_id');
        };

        $tables['xf_bs_ai_bot_chat_gpt_node_prompt'] = static function (Create $table) {
            $table->addColumn('prompt_id', 'int')->autoIncrement();
            $table->addColumn('node_id', 'int');
            $table->addColumn('bot_id', 'int');
            $table->addColumn('prompt', 'text');
            $table->addKey('node_id');
            $table->addKey('bot_id');
            $table->addUniqueKey(['node_id', 'bot_id']);
        };

        return $tables;
    }

    protected function getAlterTables(): array
    {
        $tables = [];

        // insert columns to xf_thread table
        $tables['xf_thread'][] = static function (Alter $table) {
            $table->addColumn('bs_aib_enable_bots', 'tinyint', 3)
                ->setDefault(1);
        };
        // drop columns from xf_thread table
        $tables['xf_thread'][] = static function (Alter $table) {
            $table->dropColumns(['bs_aib_enable_bots']);
        };

        return $tables;
    }
}