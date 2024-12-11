<?php

/*
 * Updated on 19.10.2020
 * HomePage: https://xentr.net
 * Copyright (c) 2020 XENTR | XenForo Add-ons - Styles -  All Rights Reserved
 */

namespace XDinc\FTSlider;

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
     * -----------------------------------
     *   Install FTSlider XF-2.2+
     * -----------------------------------
     */

	public function installStep1()
	{
		$this->schemaManager()->createTable(
        'xd_ftslider_features', function(Create $table)
		
		{
			$table->checkExists(true);
			$table->addColumn('thread_id', 'int', 10);
			$table->addColumn('ftslider_date', 'int', 10);
			$table->addColumn('ftslider_time', 'int', 10);
			$table->addColumn('ftslider_title', 'varchar', 255);
			$table->addColumn('ftslider_excerpt', 'text');
			$table->addColumn('ftslider_imgurl', 'varchar', 255);
			$table->addColumn('ftslider_icon', 'blob');
			$table->addPrimaryKey('thread_id');
		});
	}
	
	public function installStep2()
	{
		$target = \XF::getRootDirectory().'/data/FTSlider';
		if (!is_dir($target)) { mkdir($target, 0777); }
	}
	
    public function installStep3()
    {
        $this->createWidget(
              'XD_FTSlider_widget', 
              'FTSlider_widget', [
                  	'positions' => []
        ]);
    }

    /**
     * -----------------------------------
     *     Uninstall FTSlider XF-2.2+
     * -----------------------------------
     */

	public function uninstallStep1()
	{
		$this->schemaManager()->dropTable(
                   'xd_ftslider_features'
        );
	}
	
	public function uninstallStep2()
	{
	
		$target = glob(\XF::getRootDirectory().'/data/FTSlider/*.jpg');
		foreach ($target AS $file) { unlink($file); }

		$target = \XF::getRootDirectory().'/data/FTSlider';
		if (is_dir($target)) { rmdir($target); }

	}


}