<?php

namespace FS\CallWhatsApp;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use FS\CallWhatsApp\Install\Data\MySql;

class Setup extends AbstractSetup {

    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    // ################################ INSTALLATION ######################

    public function installstep1() {
        $sm = $this->schemaManager();

        foreach ($this->getTables() as $tableName => $callback) {
            $sm->createTable($tableName, $callback);
        }
    }

    // ############################### UNINSTALL ###########################

    public function uninstallStep1() {
        $sm = $this->schemaManager();

        foreach (array_keys($this->getTables()) as $tableName) {
            $sm->dropTable($tableName);
        }
    }

    protected function getTables() {
        $data = new MySql();
        return $data->getTables();
    }
}
