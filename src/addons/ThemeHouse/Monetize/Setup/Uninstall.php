<?php

namespace ThemeHouse\Monetize\Setup;

use XF\Db\Mysqli\Adapter;
use XF\Db\Schema\Alter;
use XF\Db\SchemaManager;
use XF\Entity\Phrase;

/**
 * Trait Uninstall
 * @package ThemeHouse\Monetize\Setup
 * @package ThemeHouse\Monetize\Setup
 *
 * @property \XF\App app
 *
 * @method SchemaManager schemaManager
 * @method Adapter db
 */
trait Uninstall
{
    /**
     *
     */
    public function uninstallStep1()
    {
        $this->schemaManager()->dropTable('xf_th_monetize_affiliate_link');
    }

    /**
     *
     */
    public function uninstallStep2()
    {
        $this->schemaManager()->dropTable('xf_th_monetize_communication');
    }

    /**
     *
     */
    public function uninstallStep3()
    {
        $this->schemaManager()->dropTable('xf_th_monetize_communication_log');
    }

    /**
     *
     */
    public function uninstallStep4()
    {
        $this->schemaManager()->dropTable('xf_th_monetize_keyword');
    }

    /**
     *
     */
    public function uninstallStep5()
    {
        $this->schemaManager()->dropTable('xf_th_monetize_sponsor');
    }

    /**
     *
     */
    public function uninstallStep6()
    {
        $this->schemaManager()->dropTable('xf_th_monetize_upgrade_page');
    }

    /**
     *
     */
    public function uninstallStep7()
    {
        $this->schemaManager()->dropTable('xf_th_monetize_upgrade_page_relation');
    }

    /**
     *
     */
    public function uninstallStep8()
    {
        $this->schemaManager()->alterTable('xf_node', function (Alter $table) {
            $table->dropColumns(['th_sponsor_id']);
        });
    }

    /**
     *
     */
    public function uninstallStep9()
    {
        $this->db()->update('xf_user', ['user_state' => 'disabled'], 'user_state = ?', 'thmonetize_upgrade');
        $this->schemaManager()->alterTable('xf_user', function (Alter $table) {
            $table->changeColumn('user_state')->removeValues(['thmonetize_upgrade']);
        });
    }

    /**
     *
     */
    public function uninstallStep10()
    {
        $this->schemaManager()->alterTable('xf_user_upgrade', function (Alter $table) {
            $table->dropColumns([
                'thmonetize_features',
                'thmonetize_style_properties',
                'thmonetize_custom_amount',
                'thmonetize_allow_multiple',
                'thmonetize_redirect_url',
                'user_criteria',
            ]);
        });
    }

    /**
     *
     */
    public function uninstallStep11()
    {
        $this->schemaManager()->alterTable('xf_user_profile', function (Alter $table) {
            $table->dropColumns(['thmonetize_active_upgrades', 'thmonetize_expired_upgrades']);
        });
    }

    /**
     *
     */
    public function uninstallStep12()
    {
        $this->schemaManager()->alterTable('xf_user_upgrade_active', function (Alter $table) {
            $table->dropColumns(['thmonetize_updated']);
        });
    }

    /**
     *
     */
    public function uninstallStep13()
    {
        $this->schemaManager()->alterTable('xf_user_upgrade_expired', function (Alter $table) {
            $table->dropColumns(['thmonetize_updated']);
        });
    }

    public function uninstallStep14()
    {
        $this->db()->delete('xf_payment_provider', 'provider_id = ?', 'thmonetize_free');
        $this->db()->delete('xf_payment_profile', 'provider_id = ?', 'thmonetize_free');
    }

    /**
     *
     * @throws \XF\PrintableException
     */
    public function uninstallStep15()
    {
        $phrases = $this->app->finder('XF:Phrase')->whereOr([
            ['title', 'LIKE', 'upgrade_page.%'],
        ])->fetch();

        foreach ($phrases as $phrase) {
            /** @var Phrase $phrase */
            $phrase->delete();
        }
    }

    public function uninstallStep16()
    {
        $this->schemaManager()->dropTable('xf_th_monetize_coupon');
    }
}