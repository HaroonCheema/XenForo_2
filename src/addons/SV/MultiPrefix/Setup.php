<?php /** @noinspection RedundantSuppression */

namespace SV\MultiPrefix;

use SV\StandardLib\InstallerHelper;
use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
    use InstallerHelper {
        checkRequirements as protected checkRequirementsTrait;
    }
    use StepRunnerInstallTrait;
    use StepRunnerUpgradeTrait;
    use StepRunnerUninstallTrait;

    public function installStep1()
    {
        $this->applySchema();
    }

    public function installStep2()
    {
        $this->migrateCategoryPrefixConfiguration();
    }

    public function installStep3()
    {
        $this->seedPrefixLinkTables();
    }

    public function applySchema()
    {
        $sm = $this->schemaManager();

        foreach ($this->getTables() as $tableName => $callback)
        {
            $sm->createTable($tableName, $callback);
            $sm->alterTable($tableName, $callback);
        }

        foreach ($this->getAlterTables() as $tableName => $callback)
        {
            if ($sm->tableExists($tableName))
            {
                $sm->alterTable($tableName, $callback);
            }
        }
    }

    public function migrateCategoryPrefixConfiguration()
    {
        $db = $this->db();
        $db->beginTransaction();
        /** @noinspection SqlResolve */
        $db->query("
                UPDATE xf_forum
                SET sv_min_prefixes = require_prefix, require_prefix = 1
                WHERE require_prefix > 0 and sv_min_prefixes  = 0
            ");

        $db->query("
                UPDATE xf_thread
                SET sv_prefix_ids = prefix_id
                WHERE (sv_prefix_ids = '' OR sv_prefix_ids IS NULL) AND prefix_id <> 0 
            ");
        $db->commit();

        if ($this->resourceManagerInstalled())
        {
            $db->beginTransaction();
            /** @noinspection SqlResolve */
            $db->query("
                UPDATE xf_rm_category
                SET sv_min_prefixes = require_prefix, require_prefix = 1
                WHERE require_prefix > 0 and sv_min_prefixes  = 0
            ");

            /** @noinspection SqlResolve */
            $db->query("
                    UPDATE xf_rm_resource
                    SET sv_prefix_ids = prefix_id
                    WHERE (sv_prefix_ids = '' OR sv_prefix_ids is null) AND prefix_id <> 0 
                ");
            $db->commit();
        }

        if ($this->dbtechEcommerceInstalled())
        {
            $db->beginTransaction();
            /** @noinspection SqlResolve */
            $db->query("
                UPDATE xf_dbtech_ecommerce_category
                SET sv_min_prefixes = require_prefix, require_prefix = 1
                WHERE require_prefix > 0 and sv_min_prefixes  = 0
            ");

            /** @noinspection SqlResolve */
            $db->query("
                    UPDATE xf_dbtech_ecommerce_product
                    SET sv_prefix_ids = prefix_id
                    WHERE (sv_prefix_ids = '' OR sv_prefix_ids is null) AND prefix_id <> 0
                ");
            $db->commit();
        }

        if ($this->dbtechShopInstalled())
        {
            $db->beginTransaction();
            /** @noinspection SqlResolve */
            $db->query("
                UPDATE xf_dbtech_shop_category
                SET sv_min_prefixes = require_prefix, require_prefix = 1
                WHERE require_prefix > 0 and sv_min_prefixes  = 0
            ");

            /** @noinspection SqlResolve */
            $db->query("
                    UPDATE xf_dbtech_shop_item
                    SET sv_prefix_ids = prefix_id
                    WHERE (sv_prefix_ids = '' OR sv_prefix_ids is null) AND prefix_id <> 0
                ");
            $db->commit();
        }

        if ($this->xcProjectManagerInstalled())
        {
            $db->beginTransaction();
            /** @noinspection SqlResolve */
            $db->query("
                UPDATE xf_xcpm_category
                SET sv_min_prefixes = require_project_prefix, require_project_prefix = 1
                WHERE require_project_prefix > 0 and sv_min_prefixes  = 0
            ");

            /** @noinspection SqlResolve */
            $db->query("
                    UPDATE xf_xcpm_project
                    SET sv_prefix_ids = prefix_id
                    WHERE (sv_prefix_ids = '' OR sv_prefix_ids is null) AND prefix_id <> 0
                ");
            $db->commit();
        }
    }

    public function seedPrefixLinkTables()
    {
        $this->seedThreads();
        $this->seedResourceManager();
        $this->seedDbTechEcommerce();
        $this->seedDbTechShop();
        $this->seedXcProjectManager();
    }

    public function seedThreads(bool $force = false)
    {
        $db = $this->db();
        /** @noinspection SqlResolve */
        if (!$force && $db->fetchOne('SELECT prefix_id FROM xf_sv_thread_prefix_link LIMIT 1'))
        {
            // upgrade & exists, bail
            return;
        }

        $db->beginTransaction();
        $db->delete('xf_sv_thread_prefix_link', 'prefix_id  = ?', 0);

        $db->query("
                UPDATE xf_thread
                SET  sv_prefix_ids = NULL
                WHERE prefix_id = 0
            ");

        $db->query("
                INSERT IGNORE INTO xf_sv_thread_prefix_link (prefix_id, thread_id)
                SELECT prefix_id, thread_id
                FROM xf_thread
                WHERE prefix_id <> 0
            ");
        $db->commit();
    }

    public function seedResourceManager(bool $force = false)
    {
        if ($this->resourceManagerInstalled())
        {
            $db = $this->db();

            /** @noinspection SqlResolve */
            if (!$force && $db->fetchOne('SELECT prefix_id FROM xf_sv_resource_prefix_link LIMIT 1'))
            {
                // upgrade & exists, bail
                return;
            }

            $db->beginTransaction();
            $db->delete('xf_sv_resource_prefix_link', 'prefix_id  = ?', 0);

            /** @noinspection SqlResolve */
            $db->query("
                    UPDATE xf_rm_resource
                    SET  sv_prefix_ids = NULL
                    WHERE prefix_id = 0
                ");
            /** @noinspection SqlResolve */
            $db->query("
                    INSERT IGNORE INTO xf_sv_resource_prefix_link (prefix_id, resource_id)
                    SELECT prefix_id, resource_id
                    FROM xf_rm_resource
                    WHERE prefix_id <> 0
                ");
            $db->commit();
        }
    }

    public function seedDbTechEcommerce(bool $force = false)
    {
        if ($this->dbtechEcommerceInstalled())
        {
            $db = $this->db();

            /** @noinspection SqlResolve */
            if (!$force && $db->fetchOne('select prefix_id from xf_sv_dbtech_ecommerce_product_prefix_link limit 1'))
            {
                // upgrade & exists, bail
                return;
            }

            $db->beginTransaction();
            $db->delete('xf_sv_dbtech_ecommerce_product_prefix_link', 'prefix_id  = ?', 0);

            /** @noinspection SqlResolve */
            $db->query("
                    UPDATE xf_dbtech_ecommerce_product
                    SET  sv_prefix_ids = null
                    WHERE prefix_id = 0
                ");
            /** @noinspection SqlResolve */
            $db->query("
                    INSERT IGNORE INTO xf_sv_dbtech_ecommerce_product_prefix_link (prefix_id, product_id)
                    SELECT prefix_id, product_id
                    FROM xf_dbtech_ecommerce_product
                    WHERE prefix_id <> 0
                ");
            $db->commit();
        }
    }

    public function seedDbTechShop(bool $force = false)
    {
        if ($this->dbtechShopInstalled())
        {
            $db = $this->db();

            /** @noinspection SqlResolve */
            if (!$force && $db->fetchOne('SELECT prefix_id FROM xf_sv_dbtech_shop_item_prefix_link LIMIT 1'))
            {
                // upgrade & exists, bail
                return;
            }

            $db->beginTransaction();
            $db->delete('xf_sv_dbtech_shop_item_prefix_link', 'prefix_id  = ?', 0);

            /** @noinspection SqlResolve */
            $db->query("
                    UPDATE xf_dbtech_shop_item
                    SET  sv_prefix_ids = NULL
                    WHERE prefix_id = 0
                ");
            /** @noinspection SqlResolve */
            $db->query("
                    INSERT IGNORE INTO xf_sv_dbtech_shop_item_prefix_link (prefix_id, item_id)
                    SELECT prefix_id, item_id
                    FROM xf_dbtech_shop_item
                    WHERE prefix_id <> 0
                ");
            $db->commit();
        }
    }

    public function seedXcProjectManager(bool $force = false)
    {
        if ($this->xcProjectManagerInstalled())
        {
            $db = $this->db();

            /** @noinspection SqlResolve */
            if (!$force && $db->fetchOne('select prefix_id from xf_sv_xc_project_manager_project_prefix_link limit 1'))
            {
                // upgrade & exists, bail
                return;
            }

            $db->beginTransaction();
            $db->delete('xf_sv_xc_project_manager_project_prefix_link', 'prefix_id  = ?', 0);

            /** @noinspection SqlResolve */
            $db->query("
                    UPDATE xf_xcpm_project
                    SET  sv_prefix_ids = null
                    WHERE prefix_id = 0
                ");
            /** @noinspection SqlResolve */
            $db->query("
                    INSERT IGNORE INTO xf_sv_xc_project_manager_project_prefix_link (prefix_id, project_id)
                    SELECT prefix_id, project_id
                    FROM xf_xcpm_project
                    WHERE prefix_id <> 0
                ");
            $db->commit();
        } 
    }

    public function upgrade1070000Step1()
    {
        $sm = $this->schemaManager();

        if ($sm->tableExists('xf_thread_prefix_link'))
        {
            $sm->renameTable('xf_thread_prefix_link', 'xf_sv_thread_prefix_link');
        }

        if ($this->resourceManagerInstalled() && $sm->tableExists('xf_resource_prefix_link'))
        {
            $sm->renameTable('xf_resource_prefix_link', 'xf_sv_resource_prefix_link');
        }

        if ($sm->columnExists('xf_forum', 'xm_max_prefixes'))
        {
            $sm->alterTable('xf_forum', function (Alter $table) {
                $table->renameColumn('xm_max_prefixes', 'sv_max_prefixes')->setDefault(0);
            });
        }

        if ($sm->columnExists('xf_thread', 'xm_prefixes'))
        {
            $sm->alterTable('xf_thread', function (Alter $table) {
                $table->renameColumn('xm_prefixes', 'sv_prefix_ids')
                      ->length(null)
                      ->type('mediumblob')
                      ->nullable()
                      ->setDefault(null);
            });
        }
        else if (!$sm->columnExists('xf_thread', 'sv_prefix_ids'))
        {
            $sm->alterTable('xf_thread', function (Alter $table) {
                $table->addColumn('sv_prefix_ids', 'mediumblob')
                      ->nullable()
                      ->setDefault(null);
            });
            $this->db()->query("
                UPDATE xf_thread
                SET sv_prefix_ids = prefix_id
                WHERE sv_prefix_ids IS NULL
            ");
        }

        if ($this->resourceManagerInstalled())
        {
            if ($sm->columnExists('xf_rm_category', 'xm_max_prefixes'))
            {
                $sm->alterTable('xf_rm_category', function (Alter $table) {
                    $table->renameColumn('xm_max_prefixes', 'sv_max_prefixes')->setDefault(0);
                });
            }

            if ($sm->columnExists('xf_rm_resource', 'xm_prefixes'))
            {
                $sm->alterTable('xf_rm_resource', function (Alter $table) {
                    $table->renameColumn('xm_prefixes', 'sv_prefix_ids')
                          ->length(null)
                          ->type('mediumblob')
                          ->nullable()
                          ->setDefault(null);
                });
            }
            else if (!$sm->columnExists('xf_rm_resource', 'sv_prefix_ids'))
            {
                $sm->alterTable('xf_rm_resource', function (Alter $table) {
                    $table->addColumn('sv_prefix_ids', 'mediumblob')
                          ->nullable()
                          ->setDefault(null);
                });
                $this->db()->query("
                    update xf_rm_resource
                    set sv_prefix_ids = prefix_id
                    WHERE sv_prefix_ids is null
                ");
            }
        }
    }

    public function upgrade1070000Step2()
    {
        $this->db()->query("
                UPDATE xf_thread
                SET sv_prefix_ids = prefix_id,
                    prefix_id = IF(LEFT(prefix_id,LOCATE(',',prefix_id) - 1) != '', LEFT(prefix_id,LOCATE(',',prefix_id) - 1), prefix_id)
                WHERE prefix_id LIKE '%,%'
            ");
    }

    public function upgrade1070000Step3()
    {
        $this->db()->query("
                UPDATE xf_thread
                SET prefix_id = 0, sv_prefix_ids = null
                WHERE sv_prefix_ids = '0' OR sv_prefix_ids = '' OR sv_prefix_ids is null
            ");
    }

    public function upgrade1070000Step4()
    {
        $this->applySchema();

        $threads = $this->db()->fetchAll("
                SELECT thread_id, sv_prefix_ids
                FROM xf_thread
                WHERE sv_prefix_ids <> '0' and sv_prefix_ids is not null
            ");

        foreach ($threads as $thread)
        {
            $id = $thread['thread_id'];
            $prefixes = \explode(',', $thread['sv_prefix_ids']);
            $args = [];
            $sqlBits = [];
            foreach ($prefixes as $prefixId)
            {
                $prefixId = \intval($prefixId);
                if (empty($prefixId))
                {
                    continue;
                }
                $sqlBits[] = '(?,?)';
                $args[] = $prefixId;
                $args[] = $id;
            }
            if ($args)
            {
                $sql = join(',', $sqlBits);
                $this->query('
                        INSERT IGNORE INTO xf_sv_thread_prefix_link (prefix_id, thread_id) 
                        VALUES ' . $sql . '
                    ', $args);
            }
        }

        $this->schemaManager()->alterTable('xf_thread', function (Alter $table)
        {
            $table->changeColumn('prefix_id', 'int')->unsigned()->nullable(false)->setDefault(0);
        });
    }

    public function upgrade1070000Step5()
    {
        if ($this->resourceManagerInstalled())
        {
            /** @noinspection SqlResolve */
            $this->db()->query("
                    UPDATE xf_rm_resource
                    SET sv_prefix_ids = prefix_id,
                        prefix_id = IF(LEFT(prefix_id,LOCATE(',',prefix_id) - 1) != '', LEFT(prefix_id,LOCATE(',',prefix_id) - 1), prefix_id)
                    where prefix_id like '%,%'
                ");
        }
    }

    public function upgrade1070000Step6()
    {
        if ($this->resourceManagerInstalled())
        {
            /** @noinspection SqlResolve */
            $this->db()->query("
                    UPDATE xf_rm_resource
                    SET prefix_id = 0, sv_prefix_ids = null
                    WHERE sv_prefix_ids = '0' OR sv_prefix_ids = '' OR sv_prefix_ids is null
                ");
        }
    }

    public function upgrade1070000Step7()
    {
        if ($this->resourceManagerInstalled())
        {
            /** @noinspection SqlResolve */
            $resources = $this->db()->fetchAll("
                    SELECT resource_id, sv_prefix_ids
                    FROM xf_rm_resource
                    WHERE sv_prefix_ids <> '0'
                ");

            foreach ($resources as $resource)
            {
                $id = $resource['resource_id'];
                $prefixes = \explode(',', $resource['sv_prefix_ids']);
                $args = [];
                $sqlBits = [];
                foreach ($prefixes as $prefixId)
                {
                    $prefixId = \intval($prefixId);
                    if (empty($prefixId))
                    {
                        continue;
                    }
                    $sqlBits[] = '(?,?)';
                    $args[] = $prefixId;
                    $args[] = $id;
                }
                if ($args)
                {
                    $sql = join(',', $sqlBits);
                    $this->db()->query('
                            INSERT IGNORE INTO xf_sv_resource_prefix_link (prefix_id, resource_id)
                            VALUES ' . $sql . '
                        ', $args);
                }
            }

            $this->schemaManager()->alterTable('xf_rm_resource', function (Alter $table)
            {
                $table->changeColumn('prefix_id', 'int')->unsigned()->nullable(false)->setDefault(0);
            });
        }
    }

    public function upgrade2000000Step1()
    {
        $this->upgrade1070000Step1();
    }

    public function upgrade2000000Step2()
    {
        $this->applySchema();
    }

    public function upgrade2000000Step3()
    {
        $this->migrateCategoryPrefixConfiguration();
    }

    public function upgrade2000000Step4()
    {
        $this->seedPrefixLinkTables();
    }

    public function upgrade2020100Step1()
    {
        $this->applySchema();
    }

    public function upgrade2010000Step2()
    {
        $this->db()->query("
            update xf_forum
            set sv_default_prefix_ids = default_prefix_id
            where sv_default_prefix_ids is null
        ");
    }

    public function upgrade2020000Step1()
    {
        $this->applySchema();
    }

    public function upgrade2020000Step2()
    {
        $this->db()->query("
            UPDATE xf_thread
            SET sv_prefix_ids = prefix_id
            WHERE (sv_prefix_ids = '' OR sv_prefix_ids IS NULL) AND prefix_id <> 0 
        ");
    }

    public function upgrade2090400Step1()
    {
        $this->applySchema();
    }

    public function upgrade2090400Step2()
    {
        $this->migrateCategoryPrefixConfiguration();
    }

    public function upgrade2090400Step3()
    {
        $this->seedPrefixLinkTables();
    }

    public function uninstallStep1()
    {
        $sm = $this->schemaManager();

        foreach ($this->getTables() as $tableName => $callback)
        {
            $sm->dropTable($tableName);
        }
    }

    public function uninstallStep2()
    {
        $sm = $this->schemaManager();

        foreach ($this->getRemoveAlterTables() as $tableName => $callback)
        {
            if ($sm->tableExists($tableName))
            {
                $sm->alterTable($tableName, $callback);
            }
        }
    }

    /**
     * @return array
     */
    protected function getTables()
    {
        $tables = [];


        $tables['xf_sv_thread_prefix_link'] = function ($table)
        {
            /** @var Create|Alter $table */
            $this->addOrChangeColumn($table,'thread_id', 'int');
            $this->addOrChangeColumn($table,'prefix_id', 'int');

            $table->addPrimaryKey(['thread_id', 'prefix_id']);
        };

        if ($this->resourceManagerInstalled())
        {
            $tables['xf_sv_resource_prefix_link'] = function ($table)
            {
                /** @var Create|Alter $table */
                $this->addOrChangeColumn($table,'resource_id', 'int');
                $this->addOrChangeColumn($table,'prefix_id', 'int');

                $table->addPrimaryKey(['resource_id', 'prefix_id']);
            };
        }

        if ($this->dbtechEcommerceInstalled())
        {
            $tables['xf_sv_dbtech_ecommerce_product_prefix_link'] = function ($table)
            {
                /** @var Create|Alter $table */
                $this->addOrChangeColumn($table,'product_id', 'int');
                $this->addOrChangeColumn($table,'prefix_id', 'int');

                $table->addPrimaryKey(['product_id', 'prefix_id']);
            };
        }

        if ($this->dbtechShopInstalled())
        {
            $tables['xf_sv_dbtech_shop_item_prefix_link'] = function ($table)
            {
                /** @var Create|Alter $table */
                $this->addOrChangeColumn($table,'item_id', 'int');
                $this->addOrChangeColumn($table,'prefix_id', 'int');

                $table->addPrimaryKey(['item_id', 'prefix_id']);
            };
        }

        if ($this->xcProjectManagerInstalled())
        {
            $tables['xf_sv_xc_project_manager_project_prefix_link'] = function ($table)
            {
                /** @var Create|Alter $table */
                $this->addOrChangeColumn($table,'project_id', 'int');
                $this->addOrChangeColumn($table,'prefix_id', 'int');

                $table->addPrimaryKey(['project_id', 'prefix_id']);
            };
            $tables['xf_sv_xc_project_manager_project_task_prefix_link'] = function ($table)
            {
                /** @var Create|Alter $table */
                $this->addOrChangeColumn($table,'project_task_id', 'int');
                $this->addOrChangeColumn($table,'prefix_id', 'int');

                $table->addPrimaryKey(['project_task_id', 'prefix_id']);
            };
        }

        return $tables;
    }

    public static $supportedAddOns = [
        'XFRM' => true,
        'DBTech/eCommerce' => true,
        'DBTech/Shop' => true,
        'XenConcept/ProjectManager' => true,
    ];

    /**
     * @return array
     */
    protected function getAlterTables()
    {
        $tables = [];

        $tables['xf_forum'] = function (Alter $table) {
            $this->addOrChangeColumn($table, 'sv_min_prefixes', 'int')->setDefault(0);
            $this->addOrChangeColumn($table, 'sv_max_prefixes', 'int')->setDefault(0);
            $this->addOrChangeColumn($table, 'sv_default_prefix_ids', 'mediumblob')->nullable()->setDefault(null);
        };

        $tables['xf_thread'] = function (Alter $table) {
            // force an error to occur if an old version of multiprefix was installed and not cleanly uninstalled
            $table->changeColumn('prefix_id', 'int')->unsigned()->nullable(false)->setDefault(0);

            $this->addOrChangeColumn($table, 'sv_prefix_ids', 'mediumblob')->nullable()->setDefault(null);
        };

        $tables['xf_feed'] = function (Alter $table) {
            $this->addOrChangeColumn($table, 'sv_prefix_ids', 'mediumblob')->nullable()->setDefault(null);
        };

        if ($this->resourceManagerInstalled())
        {
            $tables['xf_rm_category'] = function (Alter $table) {
                $this->addOrChangeColumn($table, 'sv_min_prefixes', 'int')->setDefault(0);
                $this->addOrChangeColumn($table, 'sv_max_prefixes', 'int')->setDefault(0);
                $this->addOrChangeColumn($table, 'sv_thread_prefix_ids', 'mediumblob')->nullable()->setDefault(null);
            };

            $tables['xf_rm_resource'] = function (Alter $table) {
                $this->addOrChangeColumn($table, 'sv_prefix_ids', 'mediumblob')->after('prefix_id')->nullable()->setDefault(null);
            };
        }

        if ($this->dbtechEcommerceInstalled())
        {
            $tables['xf_dbtech_ecommerce_category'] = function (Alter $table) {
                $this->addOrChangeColumn($table, 'sv_min_prefixes', 'int')->setDefault(0);
                $this->addOrChangeColumn($table, 'sv_max_prefixes', 'int')->setDefault(0);
            };

            $tables['xf_dbtech_ecommerce_product'] = function (Alter $table) {
                $this->addOrChangeColumn($table, 'sv_prefix_ids', 'mediumblob')->nullable()->setDefault(null);
            };
        }

        if ($this->dbtechShopInstalled())
        {
            $tables['xf_dbtech_shop_category'] = function (Alter $table) {
                $this->addOrChangeColumn($table, 'sv_min_prefixes', 'int')->setDefault(0);
                $this->addOrChangeColumn($table, 'sv_max_prefixes', 'int')->setDefault(0);
            };

            $tables['xf_dbtech_shop_item'] = function (Alter $table) {
                $this->addOrChangeColumn($table, 'sv_prefix_ids', 'mediumblob')->nullable()->setDefault(null);
            };
        }

        if ($this->xcProjectManagerInstalled())
        {
            if ($this->columnExists('xf_xcpm_category', 'sv_min_prefixes'))
            {
                $this->schemaManager()->alterTable('xf_xcpm_category', function(Alter $table) {
                    $table->renameColumn('sv_min_prefixes', 'sv_min_project_prefixes');
                });
            }
            if ($this->columnExists('xf_xcpm_category', 'sv_max_prefixes'))
            {
                $this->schemaManager()->alterTable('xf_xcpm_category', function(Alter $table) {
                    $table->renameColumn('sv_max_prefixes', 'sv_max_project_prefixes');
                });
            }

            $tables['xf_xcpm_category'] = function (Alter $table) {
                $this->addOrChangeColumn($table, 'sv_min_project_prefixes', 'int')->setDefault(0);
                $this->addOrChangeColumn($table, 'sv_max_project_prefixes', 'int')->setDefault(0);
                $this->addOrChangeColumn($table, 'sv_min_task_prefixes', 'int')->setDefault(0);
                $this->addOrChangeColumn($table, 'sv_max_task_prefixes', 'int')->setDefault(0);
                $this->addOrChangeColumn($table, 'sv_thread_prefix_ids', 'mediumblob')->nullable()->setDefault(null);
            };
            $tables['xf_xcpm_project'] = function (Alter $table) {
                $this->addOrChangeColumn($table, 'sv_prefix_ids', 'mediumblob')->nullable()->setDefault(null);
            };
            $tables['xf_xcpm_project_task'] = function (Alter $table) {
                $this->addOrChangeColumn($table, 'sv_prefix_ids', 'mediumblob')->nullable()->setDefault(null);
            };
        }

        return $tables;
    }

    protected function getRemoveAlterTables()
    {
        $tables = [];

        $tables['xf_forum'] = function (Alter $table) {
            $table->dropColumns(['sv_min_prefixes', 'sv_max_prefixes', 'sv_default_prefix_ids']);
        };

        $tables['xf_thread'] = function (Alter $table) {
            $table->dropColumns(['sv_prefix_ids']);
        };

        if ($this->resourceManagerInstalled())
        {
            $tables['xf_rm_category'] = function (Alter $table) {
                $table->dropColumns(['sv_min_prefixes', 'sv_max_prefixes', 'sv_thread_prefix_ids']);
            };
            $tables['xf_rm_resource'] = function (Alter $table) {
                $table->dropColumns(['sv_prefix_ids']);
            };
        }

        if ($this->dbtechEcommerceInstalled())
        {
            $tables['xf_dbtech_ecommerce_category'] = function (Alter $table) {
                $table->dropColumns(['sv_min_prefixes', 'sv_max_prefixes']);
            };
            $tables['xf_dbtech_ecommerce_product'] = function (Alter $table) {
                $table->dropColumns(['sv_prefix_ids']);
            };
        }

        if ($this->dbtechShopInstalled())
        {
            $tables['xf_dbtech_shop_category'] = function (Alter $table) {
                $table->dropColumns(['sv_min_prefixes', 'sv_max_prefixes']);
            };
            $tables['xf_dbtech_shop_item'] = function (Alter $table) {
                $table->dropColumns(['sv_prefix_ids']);
            };
        }

        if ($this->xcProjectManagerInstalled())
        {
            $tables['xf_xcpm_category'] = function (Alter $table) {
                $table->dropColumns(['sv_min_project_prefixes','sv_max_project_prefixes','sv_min_task_prefixes','sv_max_task_prefixes']);
                $table->dropColumns(['sv_min_prefixes', 'sv_max_prefixes']);
            };
            $tables['xf_xcpm_project'] = function (Alter $table) {
                $table->dropColumns(['sv_prefix_ids']);
            };
            $tables['xf_xcpm_project_task'] = function (Alter $table) {
                $table->dropColumns(['sv_prefix_ids']);
            };
        }

        return $tables;
    }

    /**
     * @return bool
     */
    protected function resourceManagerInstalled()
    {
        return $this->addonExists('XFRM');
    }

    /**
     * @return bool
     */
    protected function dbtechEcommerceInstalled()
    {
        return $this->addonExists('DBTech/eCommerce');
    }

    /**
     * @return bool
     */
    protected function dbtechShopInstalled()
    {
        return $this->addonExists('DBTech/Shop');
    }

    /**
     * @return bool
     */
    protected function xcProjectManagerInstalled()
    {
        return $this->addonExists('XenConcept/ProjectManager');
    }

    /**
     * @param array $errors
     * @param array $warnings
     */
    public function checkRequirements(&$errors = [], &$warnings = [])
    {
        $this->checkRequirementsTrait($errors, $warnings);

        if ($this->tableExists('xf_resource_category') && !$this->tableExists('xf_rm_category'))
        {
            $addOns = \XF::app()->container('addon.cache');
            if (isset($addOns['XFRM']))
            {
                // wtf
                $errors[] = "Multi Prefix requires XenForo Resource Manager v2.0.0+";
            }
            else
            {
                $errors[] = "After upgrading XenForo Resource Manager to v2.0.0+, rebuild the XFRM add-on to enable MultiPrefix support";
            }
        }
    }
}