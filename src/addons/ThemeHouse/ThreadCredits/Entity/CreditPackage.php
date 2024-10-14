<?php

namespace ThemeHouse\ThreadCredits\Entity;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * @property int $credit_package_id
 * @property string $title
 * @property string $description
 * @property int $display_order
 * @property array $extra_group_ids
 * @property int $length_amount
 * @property string $length_unit
 * @property float $cost_amount
 * @property string $cost_currency
 * @property bool $can_purchase
 * @property array $payment_profile_ids
 * @property int $credits
 */
class CreditPackage extends Entity
{
    public function canPurchase()
    {
        $visitor = \XF::visitor();
        return ($this->can_purchase && !isset($this->Active[$visitor->user_id]));
    }

    /**
     * @return \XF\Phrase|string
     */
    public function getCostPhrase()
    {
        return $this->getCreditPackageRepository()->getCostPhraseForCreditPackage($this);
    }

    public function getCostPhraseForPurchaseRequest(\XF\Entity\PurchaseRequest $purchaseRequest)
    {
        return $this->getCreditPackageRepository()->getCostPhraseForCreditPackage(
            $this, $purchaseRequest->cost_amount, $purchaseRequest->cost_currency
        );
    }

    /**
     * @return string
     */
    public function getPurchasableTypeId()
    {
        return 'thtc_credit_package';
    }

    protected function getCreditPackageRepository(): \ThemeHouse\ThreadCredits\Repository\CreditPackage
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->repository('ThemeHouse\ThreadCredits:CreditPackage');
    }

    /**
     * @return \XF\Service\User\UserGroupChange
     */
    protected function getUserGroupChangeService()
    {
        return $this->app()->service('XF:User\UserGroupChange');
    }

    protected function _preSave()
    {
        if (!$this->length_amount || !$this->length_unit)
        {
            $this->length_amount = 0;
            $this->length_unit = '';
        }
    }

    protected function _postDelete()
    {
        $this->getUserGroupChangeService()->removeUserGroupChangeLogByKey("thtcCreditPackage-$this->credit_package_id");
    }

    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_thtc_credit_package';
        $structure->contentType = 'thtc_credit_package';
        $structure->primaryKey = 'credit_package_id';
        $structure->shortName = 'ThemeHouse\ThreadCredits:CreditPackage';

        $structure->columns = [
            'credit_package_id' => ['type' => self::UINT, 'autoIncrement' => true],

            'title' => [
                'type' => self::STR,
                'maxLength' => 50,
                'required' => 'please_enter_valid_title'
            ],
            'description' => ['type' => self::STR, 'default' => ''],
            'display_order' => ['type' => self::UINT, 'default' => 0],
            'credits' => ['type' => self::UINT, 'default' => 1],

            'extra_group_ids' => [
                'type' => self::LIST_COMMA,
                'default' => [],
                'list' => ['type' => 'posint', 'unique' => true, 'sort' => SORT_NUMERIC]
            ],
            'length_amount' => ['type' => self::UINT, 'max' => 255, 'required' => true],
            'length_unit' => [
                'type' => self::STR,
                'default' => '',
                'allowedValues' => ['day', 'month', 'year', '']
            ],

            'cost_amount' => ['type' => self::FLOAT, 'required' => true, 'min' => 0.01],
            'cost_currency' => ['type' => self::STR, 'required' => true],
            'can_purchase' => ['type' => self::BOOL, 'default' => true],
            'payment_profile_ids' => [
                'type' => self::LIST_COMMA,
                'required' => 'please_select_at_least_one_payment_profile',
                'list' => ['type' => 'posint', 'unique' => true, 'sort' => SORT_NUMERIC]
            ]
        ];

        $structure->getters = [
            'cost_phrase' => true,
            'cost_phrase_for_purchase_request' => true,
            'purchasable_type_id' => true
        ];

        return $structure;
    }
}