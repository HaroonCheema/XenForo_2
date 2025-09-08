<?php

namespace XenGenTr\XGTCoreLibrary;

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

    /**
     * ----------------
     *     Kuruluma basla
     * ----------------
     */
    public function installStep1()
    { 
		$this->schemaManager()->alterTable('xf_node', function(Alter $table)
        {
            $table->addColumn('xgt_style_fa_ikon', 'mediumblob')->nullable();
        });
 	}

    /**
     * ----------------
     *     Kurulum guncellemeleri
     * ----------------
     */

    public function upgrade1000300Step1()
    {
        $this->installStep1();
    }
        
    /**
     * ----------------
     *     Temizlige basla :)
     * ----------------
     */

	public function uninstallStep1()
	{
        $this->schemaManager()->alterTable('xf_node', function(Alter $table)
        {
			$table->dropColumns('xgt_style_fa_ikon');
        });		
	}

}