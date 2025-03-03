<?php

namespace AddonFlare\PaidRegistrations;

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

    // install
    public function installStep1()
    {
        $this->schemaManager()->createTable('xf_af_paidregistrations_accounttype', function(Create $table)
        {
            $table->addColumn('account_type_id', 'int')->autoIncrement();
            $table->addColumn('row', 'int');
            $table->addColumn('display_order', 'int');
            $table->addColumn('user_upgrade_id', 'int')->unsigned(false);

            $table->addColumn('color', 'varchar', 50)->setDefault('');
            $table->addColumn('color_dark', 'varchar', 50)->setDefault('');

            $table->addColumn('features', 'mediumtext')->nullable();

            $table->addColumn('active', 'tinyint', 3)->setDefault(1);
        });
    }

    public function installStep2()
    {
        $this->schemaManager()->alterTable('xf_af_paidregistrations_accounttype', function(Alter $alter)
        {
            $alter->addColumn('is_featured', 'tinyint', 3)->setDefault(0);
        });
    }

    public function installStep3()
    {
        $this->schemaManager()->alterTable('xf_af_paidregistrations_accounttype', function(Alter $alter)
        {
            $alter->addColumn('alias_user_upgrades', 'mediumtext');
            $alter->addColumn('allow_custom_amount', 'tinyint', 3)->setDefault(0);
        });
    }

    public function installStep4()
    {
        $this->schemaManager()->alterTable('xf_af_paidregistrations_accounttype', function(Alter $alter)
        {
            $alter->addColumn('custom_amount_min')->type('decimal', '10,2');
            $alter->addColumn('disable_custom_amount_guest', 'tinyint', 3)->setDefault(0);
        });
    }

    public function installStep5()
    {
        $this->schemaManager()->alterTable('xf_af_paidregistrations_accounttype', function(Alter $alter)
        {
            $alter->addColumn('custom_title', 'varchar', 50)->setDefault('')->after('account_type_id');
        });
    }

    public function installStep6()
    {
        $this->schemaManager()->alterTable('xf_af_paidregistrations_accounttype', function(Alter $alter)
        {
            $alter->addColumn('is_giftable', 'tinyint', 3)->setDefault(1);
            $alter->addColumn('purchase_user_group_ids', 'blob');
        });

        // set default to all
        $this->query('
            UPDATE xf_af_paidregistrations_accounttype
            SET
                purchase_user_group_ids = ?', '[-1]');
    }

    public function installStep7()
    {
        $sm = $this->schemaManager();

        $sm->createTable('xf_af_paidregistrations_coupon', function(Create $table)
        {
            $table->addColumn('coupon_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 255)->setDefault('');
            $table->addColumn('coupon_code', 'varbinary', 100)->setDefault('');
            $table->addColumn('start_date', 'int');
            $table->addColumn('end_date', 'int');
            $table->addColumn('discount_type', 'enum')->values(['percent','flat']);
            $table->addColumn('discount_value', 'decimal', '10,2');
            $table->addColumn('uses_remaining', 'int');
            $table->addColumn('unlimited_uses', 'tinyint', 3)->setDefault(1);
            $table->addColumn('user_group_ids', 'varbinary', 255)->setDefault('');
            $table->addColumn('account_type_ids', 'varbinary', 255)->setDefault('');
            $table->addColumn('active', 'tinyint', 3)->setDefault(1);

            $table->addKey('coupon_code');
            $table->addKey('start_date');
            $table->addKey('end_date');
        });

        $sm->createTable('xf_af_paidregistrations_coupon_use', function(Create $table)
        {
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('coupon_id', 'int');
            $table->addColumn('user_id', 'int');
            $table->addColumn('use_date', 'int');
            $table->addColumn('purchase_request_key', 'varbinary', 32)->nullable();

            $table->addKey('coupon_id');
            $table->addKey('user_id');
            $table->addKey('use_date');
        });
    }

    public function installStep8()
    {
        $this->schemaManager()->alterTable('xf_purchase_request', function(Alter $alter)
        {
            $alter->addColumn('af_pr_guest_pending', 'tinyint', 3)->nullable()->setDefault(null);
            $alter->addKey('af_pr_guest_pending');
        });
    }

    // upgrade
    public function upgrade1020070Step1()
    {
        $this->installStep2();
    }

    public function upgrade1030070Step1()
    {
        $this->installStep3();
    }

    public function upgrade1040070Step1()
    {
        $this->installStep4();
    }

    public function upgrade1060070Step1()
    {
        $this->installStep5();
    }

    public function upgrade1060370Step1()
    {
        $this->installStep6();
    }

    public function upgrade1060471Step1()
    {
        $this->installStep7();
    }

    public function upgrade1070070Step1()
    {
        $this->installStep8();
    }

    public function upgrade1070170Step1(array $stepParams)
    {
        $position = empty($stepParams[0]) ? 0 : $stepParams[0];

        $this->entityColumnsToJson('AddonFlare\PaidRegistrations:AccountType', ['alias_user_upgrades'], $position, $stepParams);
    }

    // uninstall
    public function uninstallStep1()
    {
        $sm = $this->schemaManager();

        $sm->dropTable('xf_af_paidregistrations_accounttype');
        $sm->dropTable('xf_af_paidregistrations_coupon');
        $sm->dropTable('xf_af_paidregistrations_coupon_use');

        $sm->alterTable('xf_purchase_request', function(Alter $alter)
        {
            $alter->dropColumns(['af_pr_guest_pending']);
        });
    }
}