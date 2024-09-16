<?php
/** 
* @package [AddonsLab] Thread Filter
* @author AddonsLab
* @license https://addonslab.com/
* @link https://addonslab.com/
* @version 3.8.0
This software is furnished under a license and may be used and copied
only  in  accordance  with  the  terms  of such  license and with the
inclusion of the above copyright notice.  This software  or any other
copies thereof may not be provided or otherwise made available to any
other person.  No title to and  ownership of the  software is  hereby
transferred.                                                         
                                                                     
You may not reverse  engineer, decompile, defeat  license  encryption
mechanisms, or  disassemble this software product or software product
license.  AddonsLab may terminate this license if you don't comply with
any of these terms and conditions.  In such event,  licensee  agrees 
to return licensor  or destroy  all copies of software  upon termination 
of the license.
*/


namespace AL\ThreadFilter;

use AddonsLab\Core\Xf2\AbstractCoreSetup;
use AL\FilterFramework\FilterSetupInterface;
use AL\FilterFramework\FrameworkSetup;
use AL\ThreadFilter\Licensing\Engine\Xf2;
use XF\Db\Exception;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Column;
use XF\Entity\WidgetDefinition;

class Setup extends AbstractCoreSetup implements FilterSetupInterface
{
    use FrameworkSetup;

    public function install(array $stepParams = [])
    {
        parent::install($stepParams);
        $this->assertLicense(false);
    }

    public function upgrade(array $stepParams = [])
    {
        parent::upgrade($stepParams);
        $this->assertLicense(true);
    }

    protected function _installUpgradeCommon()
    {
        parent::_installUpgradeCommon();
        $this->assertFilterWidget();
    }

    public function upgrade1110072Step1()
    {
        $this->schemaManager()->alterTable('xf_forum', function (Alter $alter)
        {
            $alter->changeColumn('field_column_cache')->nullable()->setDefault(null);
        });
    }

    public function upgrade3070071Step1()
    {
        $this->_applyCustomFieldPermissions();
    }

    public function postInstall(array &$stateChanges)
    {
        parent::postInstall($stateChanges);

        $this->_applyCustomFieldPermissions();
    }

    protected function _applyCustomFieldPermissions()
    {
        // Delete the wrong permissions applied with the previous upgrade
        $this->db()->query("
            DELETE FROM xf_permission_entry
            WHERE permission_group_id=?
            AND permission_id=?
            AND permission_value=?
        ", ['forum', 'useCustomFieldFilter', 'allow']);

        // Apply correct permissions for guests and registered users only
        $this->db()->query("
            INSERT IGNORE INTO xf_permission_entry
				(user_group_id, user_id, permission_group_id, permission_id, permission_value, permission_value_int)
			VALUES
				(1, 0, 'forum', 'useCustomFieldFilter', 'allow', 0),
				(2, 0, 'forum', 'useCustomFieldFilter', 'allow', 0)
        ");

        $this->app->jobManager()->enqueueUnique(
            'permissionRebuild',
            'XF:PermissionRebuild',
            [],
            false
        );
    }

    public function uninstall(array $stepParams = [])
    {
        // $this->deleteTables($this->getCreateMapping());
        //$this->deleteColumns($this->_getThreadFilterAlterMapping([]));
         $this->deleteWidget('default_thread_filter_widget');
    }

    public function getCreateMapping()
    {
        return $this->_getCreateMapping();
    }

    public function assertFilterWidget()
    {
        $widget = \XF::finder('XF:Widget')->where('widget_key', 'default_thread_filter_widget')->fetchOne();
        if ($widget === null)
        {
            /** @var WidgetDefinition $widgetPosition */
            $widgetPosition = \XF::finder('XF:WidgetDefinition')
                ->where('addon_id', 'AL/ThreadFilter')
                ->where('definition_class', '\AL\ThreadFilter\Widget\ThreadFilter')
                ->fetchOne();

            if ($widgetPosition === null)
            {
                return;
            }

            $this->createWidget(
                'default_thread_filter_widget',
                $widgetPosition->definition_id,
                ['positions' => ['forum_view_sidebar' => 1]],
                'Thread Filter'
            );
        }
    }

    public function getAlterMapping()
    {
        $alter = $this->_getAlterMapping();

        $alter = $this->_getThreadFilterAlterMapping($alter);

        return $alter;
    }

    protected function _getThreadFilterAlterMapping(array $alter)
    {
        $alter['xf_node'][] = [
            'column' => 'filter_location',
            'install' => function (Column $column)
            {
                $column->type('enum')->values(['', 'popup', 'sidebar', 'above_thread_list'])->setDefault('');
            },
            'uninstall' => function ($columnName, Alter $table)
            {
                $table->dropColumns([$columnName]);
            }
        ];

        $alter['xf_node'][] = [
            'column' => 'effective_filter_location',
            'install' => function (Column $column)
            {
                $column->type('enum')->values(['', 'popup', 'sidebar', 'above_thread_list'])->setDefault('');
            },
            'uninstall' => function ($columnName, Alter $table)
            {
                $table->dropColumns([$columnName]);
            }
        ];

        $alter['xf_forum'][] = [
            'column' => 'field_column_cache',
            'install' => function (Column $column)
            {
                $column->type('mediumblob')->nullable(true)->setDefault(null);
            },
            'uninstall' => function ($columnName, Alter $table)
            {
                $table->dropColumns([$columnName]);
            }
        ];

        return $alter;
    }

    public function assertLicense($validateNow = true)
    {
        Xf2::installDrivers();

        if ($validateNow && \XF::finder('XF:AddOn')->whereId('AL/ThreadFilter')->fetchOne())
        {
            try
            {
                $licenseKey = App::getOptionProvider()->getOption('altf_license_key');
            } catch (\Exception $exception)
            {
                // the option does not exist yet
                return true;
            }

            try
            {
                $licenseValidationService = App::getLicenseValidationService('\AL\ThreadFilter\Licensing\Engine\Xf2');
                $licenseValidationService->licenseReValidation(
                    $licenseKey,
                    false
                );
            } catch (Exception $dbException)
            {
                // ignore DB exceptions, in case the table is missing etc.
            } catch (\Exception $ex)
            {
                throw new \RuntimeException($ex->getMessage(), true);
            }
        }

        return true;
    }
}
