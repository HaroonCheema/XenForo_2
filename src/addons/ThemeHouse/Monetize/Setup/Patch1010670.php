<?php

namespace ThemeHouse\Monetize\Setup;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
use XF\Db\SchemaManager;

/**
 * Trait Patch1010670
 * @package ThemeHouse\Monetize\Setup
 *
 * @method SchemaManager schemaManager
 */
trait Patch1010670
{
    /**
     *
     */
    public function upgrade1010670Step1()
    {
        $this->schemaManager()->alterTable('xf_th_monetize_sponsor', function (Alter $table) {
            $table->addColumn('featured', 'tinyint')->setDefault(0)->after('active');
        });
    }
}