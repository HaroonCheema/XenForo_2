<?php

namespace Ialert\PayrexxGateway;

use XF\AddOn\AbstractSetup;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
    public function install(array $stepParams = [])
    {
        $this->query('INSERT INTO xf_payment_provider
				(provider_id, provider_class, addon_id)
			    VALUES
				(\'payrexx\', \'Ialert\\\PayrexxGateway\\\XF\\\Payment\\\Payrexx\', \'Ialert/PayrexxGateway\');');

        $this->schemaManager()->alterTable('xf_user_upgrade', function (Alter $alter) {
            $alter->addColumn('is_review_balance', 'tinyint', 3)->setDefault(0);
        });

        $this->schemaManager()->createTable('amp_reviews_balance_upgrade_log', function (Create $table) {
            $table->addColumn('id', 'int')->autoIncrement();
            $table->addColumn('user_id', 'int');
            $table->addColumn('date', 'date');
            $table->addColumn('gain', 'int')->unsigned(false);
        });
    }

    public function upgrade(array $stepParams = [])
    {
    }

    public function uninstall(array $stepParams = [])
    {
        $this->query('DELETE FROM xf_payment_provider WHERE provider_id=\'payrexx\'');
        $this->schemaManager()->dropTable('amp_reviews_balance_upgrade_log');

    }
}