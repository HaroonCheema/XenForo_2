<?php

namespace ThemeHouse\Monetize\Setup;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
use XF\Db\SchemaManager;

/**
 * Trait Patch1010370
 * @package ThemeHouse\Monetize\Setup
 *
 * @method SchemaManager schemaManager
 */
trait Patch1010370
{
    /**
     *
     */
    public function upgrade1010370Step1()
    {
        $this->schemaManager()->alterTable('xf_user_upgrade', function (Alter $table) {
            $table->addColumn('user_criteria', 'mediumblob')->nullable();
        });
    }

    public function upgrade1010370Step2()
    {
        $upgrades = \XF::db()->fetchAll('select * from xf_user_upgrade');

        foreach ($upgrades as $upgrade) {
            $this->db()->update('xf_user_upgrade', [
                'user_criteria' => json_encode([]),
            ], 'user_upgrade_id = ?', [$upgrade['user_upgrade_id']]);
        }
    }
}