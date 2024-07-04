<?php

namespace FS\ReviewSystem;

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
        
        
        public function installstep1()
	{

		$this->alterTable('xf_thread', function (Alter $table) 
                {
                        $table->addColumn('is_review', 'tinyint', 3)->setDefault(0);
                        $table->addColumn('review_date', 'int')->setDefault(0);
                        $table->addColumn('review_name', 'varchar', 50);
                        $table->addColumn('review_contact_info', 'mediumtext');
                        $table->addColumn('review_website_url', 'varchar', 150);
                        $table->addColumn('review_general_area', 'mediumtext');
                        $table->addColumn('review_activities', 'mediumtext');
                        $table->addColumn('review_session_length', 'varchar', 255)->setDefault('');
                        $table->addColumn('review_fee', 'varchar', 150)->setDefault('');
                        $table->addColumn('review_hair_length_and_color', 'mediumtext');
                        $table->addColumn('review_age', 'tinyint', 3)->setDefault(0);
                        $table->addColumn('review_smoking_status', 'enum')->values(['','yes','no'])->setDefault('');
                        $table->addColumn('review_physical_description', 'mediumtext');
                        $table->addColumn('review_recommendation', 'tinyint', 3)->setDefault(0);
                        $table->addKey('review_date');
                        
		});

	}

	public function uninstallStep1()
	{	
            
		$this->alterTable('xf_thread', function (Alter $table) 
                {
			$table->dropColumns(['is_review','review_date','review_name',
                                            'review_contact_info','review_website_url','review_general_area',
                                            'review_activities','review_session_length','review_fee',
                                            'review_hair_length_and_color','review_age','review_smoking_status',
                                            'review_physical_description','review_recommendation'

                                            ]);
		});
	}
}