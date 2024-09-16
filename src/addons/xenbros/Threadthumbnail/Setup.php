<?php

namespace xenbros\Threadthumbnail;

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
       $this->schemaManager()->alterTable('xf_node', function (\XF\Db\Schema\Alter $table)
        {
            $table->addColumn('node_thread_thumbnail_height', 'varchar', 250)->nullable()->after('effective_navigation_id');
            $table->addColumn('node_thread_thumbnail_width', 'varchar', 250)->nullable()->after('effective_navigation_id');
            $table->addColumn('node_default_thread_thumbnail_image', 'varchar', 250)->nullable()->after('effective_navigation_id');
            $table->addColumn('node_custom_image_feild', 'varchar', 250)->nullable()->after('effective_navigation_id');
            $table->addColumn('node_attachment_thumb', 'enum', 50)->values(['full','small'])->setDefault('full')->after('effective_navigation_id');
        });
    }

    public function upgrade2301Step1()
    {
       $this->schemaManager()->alterTable('xf_node', function (\XF\Db\Schema\Alter $table)
        {
            $table->dropColumns(['node_thread_thumbnail_height', 'node_thread_thumbnail_width', 'node_default_thread_thumbnail_image','node_attachment_thumb']);
        });
    }

    public function upgrade2301Step2()
    {
        $this->schemaManager()->alterTable('xf_node', function (\XF\Db\Schema\Alter $table)
        {
            $table->addColumn('node_thread_thumbnail_height', 'varchar', 250)->nullable()->after('effective_navigation_id');
            $table->addColumn('node_thread_thumbnail_width', 'varchar', 250)->nullable()->after('effective_navigation_id');
            $table->addColumn('node_default_thread_thumbnail_image', 'varchar', 250)->nullable()->after('effective_navigation_id');
            $table->addColumn('node_attachment_thumb', 'enum', 50)->values(['full','small'])->setDefault('full')->after('effective_navigation_id');
        });
    }

    public function upgrade2303Step1()
    {
        $this->schemaManager()->alterTable('xf_node', function (\XF\Db\Schema\Alter $table)
        {
            $table->addColumn('node_custom_image_feild', 'varchar', 250)->nullable()->after('effective_navigation_id');
        });
    }

	public function uninstallStep1()
	{
		$this->schemaManager()->alterTable('xf_node', function (\XF\Db\Schema\Alter $table)
        {
            $table->dropColumns(['node_thread_thumbnail_height', 'node_thread_thumbnail_width', 'node_default_thread_thumbnail_image','node_attachment_thumb','node_custom_image_feild']);
        });
	}
}


