<?php

namespace ThemeHouse\Monetize\XF\Entity;

use ThemeHouse\Monetize\Entity\UpgradePageRelation;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;
use XF\Phrase;

/**
 * Class UserUpgrade
 * @package ThemeHouse\Monetize\XF\Entity
 *
 * @property integer $cost_amount
 * @property array $thmonetize_features
 * @property array $thmonetize_style_properties
 * @property bool $thmonetize_custom_amount
 * @property bool $thmonetize_custom_amount_
 * @property bool $thmonetize_allow_multiple
 * @property string $thmonetize_redirect_url
 *
 * @property mixed $thmonetize_cost_currency_symbol
 * @property mixed $thmonetize_cost_amount_formatted
 * @property Phrase $thmonetize_length_phrase_short
 * @property Phrase $thmonetize_length_phrase_long
 *
 * @property UpgradePageRelation[]|AbstractCollection ThMonetizeUpgradePageRelations
 */
class UserUpgrade extends XFCP_UserUpgrade
{
    public function getThMonetizeCustomAmount(): bool {
        if($this->thmonetize_custom_amount_) {
            $paymentProfileIds = $this->payment_profile_ids;
            $hasPaypalProfile = \XF::em()->getFinder('XF:PaymentProfile')
                ->where('payment_profile_id', '=', $paymentProfileIds)
                ->where('provider_id', '=', 'paypal')
                ->fetchOne();

            if($hasPaypalProfile) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['cost_amount']['min'] = 0;

        $structure->columns += [
            'thmonetize_features' => ['type' => self::JSON_ARRAY, 'default' => [], 'api' => true],
            'thmonetize_style_properties' => ['type' => self::JSON_ARRAY, 'default' => []],
            'thmonetize_custom_amount' => ['type' => self::BOOL, 'default' => false, 'api' => true],
            'thmonetize_allow_multiple' => ['type' => self::BOOL, 'default' => false, 'api' => true],
            'thmonetize_redirect_url' => ['type' => self::STR, 'nullable' => true],
            'user_criteria' => ['type' => self::JSON_ARRAY, 'default' => []],
        ];

        $structure->getters += [
            'thmonetize_custom_amount' => true,
            'thmonetize_cost_currency_symbol' => true,
            'thmonetize_cost_amount_formatted' => true,
            'thmonetize_length_phrase_short' => true,
            'thmonetize_length_phrase_long' => true
        ];

        $structure->relations += [
            'ThMonetizeUpgradePageRelations' => [
                'entity' => 'ThemeHouse\Monetize:UpgradePageRelation',
                'type' => self::TO_MANY,
                'conditions' => 'user_upgrade_id',
                'key' => 'upgrade_page_id',
                'order' => 'display_order',
            ]
        ];

        return $structure;
    }

    /**
     * @return string|Phrase
     */
    public function canPurchase()
    {
        if ($this->thmonetize_allow_multiple) {
            return $this->can_purchase;
        }

        return parent::canPurchase();
    }

    /**
     * @return string|Phrase
     */
    public function getCostPhrase()
    {
        if (!$this->recurring) {
            $this->app()->data('XF:Currency')->setThMonetizeFree(true);
        }

        $costPhrase = parent::getCostPhrase();

        if (!$this->recurring) {
            $this->app()->data('XF:Currency')->setThMonetizeFree(false);
        }

        return $costPhrase;
    }

    /**
     * @param bool $ignoreIfZero
     * @return string
     */
    public function getThMonetizeCostCurrencySymbol($ignoreIfZero = true)
    {
        if ($this->cost_amount == 0 && $ignoreIfZero) {
            return '';
        }
        return $this->app()->data('XF:Currency')->getCurrencySymbol($this->cost_currency);
    }

    /**
     * @return \XF\Phrase|string
     */
    public function getThMonetizeCostAmountFormatted()
    {
        $language = \XF::language();

        $data = $this->app()->data('XF:Currency')->getCurrencyData();

        if ($this->cost_amount == 0) {
            return \XF::phrase('thmonetize_free');
        }

        if (isset($data[$this->cost_currency])) {
            return $language->numberFormat($this->cost_amount, $data[$this->cost_currency]['precision']);
        } else {
            return $language->numberFormat($this->cost_amount, 2);
        }
    }

    /**
     * @return \XF\Phrase|string
     */
    public function getThMonetizeLengthPhraseShort()
    {
        if ($this->recurring && $this->length_amount === 1 && $this->length_unit) {
            return \XF::phrase('thmonetize_length_short_' . $this->length_unit);
        }
        return null;
    }

    /**
     * @param bool $skipShortPhrase
     * @return \XF\Phrase|string
     */
    public function getThMonetizeLengthPhraseLong($skipShortPhrase = true)
    {
        $phrase = '';
        if ($this->length_unit) {
            if ($this->length_amount > 1) {
                if ($this->recurring) {
                    $phrase = \XF::phrase("x_per_y_{$this->length_unit}s", [
                        'cost' => '',
                        'length' => $this->length_amount,
                    ]);
                } else {
                    $phrase = \XF::phrase("x_for_y_{$this->length_unit}s", [
                        'cost' => '',
                        'length' => $this->length_amount,
                    ]);
                }
            } else {
                if ($this->recurring) {
                    if (!$skipShortPhrase) {
                        $phrase = \XF::phrase("x_per_{$this->length_unit}", [
                            'cost' => '',
                        ]);
                    }
                } else {
                    $phrase = \XF::phrase("x_for_one_{$this->length_unit}", [
                        'cost' => '',
                    ]);
                }
            }
        } elseif ($this->cost_amount != 0) {
            $phrase = \XF::phrase("thmonetize_one_time_payment");
        }

        return $phrase;
    }

    /**
     * @param $paymentProfileId
     * @return mixed|string
     */
    public function getThMonetizeUpgradeCanonicalLink($paymentProfileId)
    {
        return \XF::app()->router('public')->buildLink('canonical:purchase/user_upgrade/', '', [
            'user_upgrade_id' => $this->user_upgrade_id,
            'payment_profile_id' => $paymentProfileId
        ]);
    }

    /**
     * @param array $relationMap
     */
    public function thMonetizeUpdateUpgradePageRelations(array $relationMap)
    {
        if (!$this->exists()) {
            throw new \LogicException("User upgrade must be saved first");
        }

        $userUpgradeId = $this->user_upgrade_id;
        $insert = [];
        foreach ($relationMap as $upgradePageId => $relation) {
            $insert[] = [
                'user_upgrade_id' => $userUpgradeId,
                'upgrade_page_id' => $upgradePageId,
                'display_order' => $relation['display_order'],
                'featured' => $relation['featured'],
            ];
        }

        $db = $this->db();
        $db->delete('xf_th_monetize_upgrade_page_relation', 'user_upgrade_id = ?', $userUpgradeId);
        if ($insert) {
            $db->insertBulk('xf_th_monetize_upgrade_page_relation', $insert);
        }

        unset($this->_relations['ThMonetizeUpgradePageRelations']);
    }

    /**
     *
     */
    protected function _preSave()
    {
        if ($this->isChanged([
                'cost_amount',
                'thmonetize_custom_amount'
            ]) && !$this->cost_amount && !$this->thmonetize_custom_amount) {
            /** @var \XF\Entity\PaymentProfile[] $profiles */
            $profiles = $this->_em->findByIds('XF:PaymentProfile', $this->payment_profile_ids);

            $invalidZeroCost = [];

            foreach ($profiles as $profile) {
                /** @var \ThemeHouse\Monetize\XF\Entity\PaymentProfile $profile */
                $supportsZeroCost = $profile->thMonetizeSupportsZeroCost();
                if (!$supportsZeroCost) {
                    $invalidZeroCost[] = $profile->Provider->getTitle();
                }
            }

            if ($invalidZeroCost) {
                $invalidZeroCost = implode(', ', array_unique($invalidZeroCost));
                $this->error(\XF::phrase('thmonetize_following_payment_providers_do_not_support_zero_cost_payments', [
                    'invalidZeroCost' => $invalidZeroCost,
                ]), 'cost_amount');
            }
        }

        parent::_preSave();
    }

    /**
     *
     * @throws \XF\PrintableException
     */
    protected function _postSave()
    {
        if ($this->isChanged('thmonetize_style_properties')) {
            /** @var \ThemeHouse\Monetize\XF\Repository\UserUpgrade $userUpgradeRepo */
            $userUpgradeRepo = $this->getUserUpgradeRepo();
            $userUpgradeRepo->generateCssForThMonetizeUserUpgrades();
        }

        parent::_postSave();
    }

    /**
     *
     */
    protected function _postDelete()
    {
        parent::_postDelete();

        $db = $this->db();
        $db->delete('xf_th_monetize_upgrade_page_relation', 'user_upgrade_id = ?', $this->user_upgrade_id);
    }
}
