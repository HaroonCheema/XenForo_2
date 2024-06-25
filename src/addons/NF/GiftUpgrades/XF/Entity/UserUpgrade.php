<?php

namespace NF\GiftUpgrades\XF\Entity;

use NF\GiftUpgrades\Globals;
use XF\Mvc\Entity\Structure;

/**
 * Extends \XF\Entity\UserUpgrade
 *
 * @property int $can_gift
 *
 * @property-read ?User $User
 */
class UserUpgrade extends XFCP_UserUpgrade
{
    public function canGift(): bool
    {
        if (!$this->can_gift)
        {
            return false;
        }

        /** @var User $visitor */
        $visitor = \XF::visitor();

        return $visitor->canGift();
    }

    /**
     * @return bool
     */
    public function canPurchase()
    {
        if (Globals::$isGift)
        {
            return $this->canGift();
        }

        return parent::canPurchase();
    }

	public function getCostPhrase()
	{
		if (Globals::$isGift)
		{
			return $this->getGiftCostPhrase();
		}

		return parent::getCostPhrase();
	}

    /**
     * @return \XF\Phrase|string
     */
	public function getGiftCostPhrase()
	{
		$cost = $this->app()->data('XF:Currency')->languageFormat($this->cost_amount, $this->cost_currency);
		$phrase = $cost;

		if ($this->length_unit)
		{
			if ($this->length_amount > 1)
			{
				$phrase = \XF::phrase("x_for_y_{$this->length_unit}s", [
					'cost' => $cost,
					'length' => $this->length_amount
				]);
			}
			else
			{
				$phrase = \XF::phrase("x_for_one_{$this->length_unit}", [
					'cost' => $cost
				]);
			}
		}

		return $phrase;
	}

	/**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['can_gift'] = ['type' => self::BOOL, 'default' => true];

        return $structure;
    }
}