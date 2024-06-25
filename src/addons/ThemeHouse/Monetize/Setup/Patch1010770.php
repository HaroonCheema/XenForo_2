<?php

namespace ThemeHouse\Monetize\Setup;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
use XF\Db\SchemaManager;

/**
 * Trait Patch1010770
 * @package ThemeHouse\Monetize\Setup
 *
 * @method SchemaManager schemaManager
 */
trait Patch1010770
{
    /**
     *
     */
    public function upgrade1010770Step1()
    {
        $this->schemaManager()->createTable('xf_th_monetize_coupon', function (Create $table) {
            $table->addColumn('coupon_id', 'int')->autoIncrement();
            $table->addColumn('title', 'varchar', 150);
            $table->addColumn('code', 'varchar', 150);
            $table->addColumn('type', 'enum')->values(['amount', 'percent']);
            $table->addColumn('value', 'int');
            $table->addColumn('active', 'tinyint')->setDefault(1);
            $table->addColumn('user_criteria', 'mediumblob')->nullable();
        });
    }
}