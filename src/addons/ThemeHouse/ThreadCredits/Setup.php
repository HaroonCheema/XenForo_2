<?php

namespace ThemeHouse\ThreadCredits;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    public function installStep1()
    {
        $this->createTable('xf_thtc_credit_package', function (\XF\Db\Schema\Create $table) {
            $table->addColumn('credit_package_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 50);
            $table->addColumn('description', 'text');
            $table->addColumn('display_order', 'int')->setDefault(0);
            $table->addColumn('extra_group_ids', 'blob');
            $table->addColumn('credits', 'int')->setDefault(1);
            $table->addColumn('length_amount', 'int');
            $table->addColumn('length_unit', 'enum')->values(['day', 'month', 'year', '']);
            $table->addColumn('cost_amount', 'float');
            $table->addColumn('cost_currency', 'text');
            $table->addColumn('can_purchase', 'tinyint')->setDefault(1);
            $table->addColumn('payment_profile_ids', 'blob');
        });
    }

    public function installStep2()
    {
        $this->createTable('xf_thtc_user_credit_package', function (\XF\Db\Schema\Create $table) {
            $table->addColumn('user_credit_package_id', 'int')->autoIncrement();
            $table->addColumn('credit_package_id', 'int')->nullable();
            $table->addColumn('user_id', 'int');
            $table->addColumn('purchase_request_key', 'varchar', 32)->nullable();
            $table->addColumn('extra', 'blob');
            $table->addColumn('total_credits', 'int');
            $table->addColumn('used_credits', 'int')->setDefault(0);
            $table->addColumn('remaining_credits', 'int');
            $table->addColumn('purchased_at', 'int')->setDefault(0);
            $table->addColumn('expires_at', 'int')->setDefault(0);

            $table->addKey(['user_id', 'expires_at'], 'query_index');
        });
    }

    public function installStep3()
    {
        $this->schemaManager()->alterTable('xf_user', function (Alter $table) {
            $table->addColumn('thtc_credits_cache', 'int')->setDefault(0);
        });
    }

    public function installStep4()
    {
        $this->createTable('xf_thtc_thread_payment', function (\XF\Db\Schema\Create $table) {
            $table->addColumn('thread_payment_id', 'int')->autoIncrement();
            $table->addColumn('user_credit_package_id', 'int');
            $table->addColumn('thread_id', 'int');
            $table->addColumn('user_id', 'int');
            $table->addColumn('page', 'int')->setDefault(1);
            $table->addColumn('purchased_at', 'int')->setDefault(0);
        });
    }

    public function installStep5()
    {
        $this->db()->insert('xf_purchasable', [
            'purchasable_type_id' => 'thtc_credit_package',
            'purchasable_class' => 'ThemeHouse\ThreadCredits:CreditPackage',
            'addon_id' => 'ThemeHouse/ThreadCredits'
        ]);
    }

    public function upgrade1000012Step1()
    {
        $this->schemaManager()->alterTable('xf_thtc_user_credit_package', function (Alter $table) {
            $table->changeColumn('purchase_request_key')->nullable();
        });
    }

    public function upgrade1000396Step1()
    {
        $this->schemaManager()->alterTable('xf_thtc_user_credit_package', function (Alter $table) {
            $table->addKey(['user_id', 'expires_at'], 'query_index');
        });
    }

    public function uninstallStep1()
    {
        $this->schemaManager()->dropTable('xf_thtc_credit_package');
    }

    public function uninstallStep2()
    {
        $this->schemaManager()->dropTable('xf_thtc_user_credit_package');
    }

    public function uninstallStep3()
    {
        $this->schemaManager()->alterTable('xf_user', function (Alter $table) {
            $table->dropColumns(['thtc_credits_cache']);
        });
    }

    public function uninstallStep4()
    {
        $this->schemaManager()->dropTable('xf_thtc_thread_payment');
    }

    public function uninstallStep5()
    {
        $this->db()->delete('xf_purchasable', 'addon_id = ?', ['ThemeHouse/ThreadCredits']);
    }
}