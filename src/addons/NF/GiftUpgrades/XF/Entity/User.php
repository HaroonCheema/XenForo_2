<?php

namespace NF\GiftUpgrades\XF\Entity;

use XF\Phrase;
use XF\Mvc\Entity\Structure;
use NF\GiftUpgrades\Entity\GiftTrait;
use NF\GiftUpgrades\Entity\IGiftable;
use NF\GiftUpgrades\Repository\GiftUpgrade as GiftUpgradeRepo;

/**
 * Class User
 *
 * @package NF\GiftUpgrades\XF\Entity
 * GETTERS
 * @property-read int $gift_received_count
 * @property-read int $gift_given_count
 */
class User extends XFCP_User implements IGiftable
{
	use GiftTrait;

	/**
     * @param string|Phrase|null $error
	 * @return bool
	 */
	public function canGiftTo(&$error = null): bool
    {
		if ($this->user_state !== 'valid' || !$this->user_id)
		{
			return false;
		}

		$visitor = \XF::visitor();

		if ($this->user_id === $visitor->user_id)
		{
			$error = \XF::phrase('nf_giftupgrades_you_cannot_gift_yourself');

			return false;
		}

		if ($visitor->user_state !== 'valid')
		{
			$error = \XF::phrase('account_upgrades_cannot_be_purchased_account_unconfirmed');

			return false;
		}

		if ($this->is_banned)
		{
			$error = \XF::phrase('nf_giftupgrades_you_cannot_gift_banned_users');

			return false;
		}

		return $visitor->hasPermission('general', 'nf_gift');
	}

	/**
     * @param string|Phrase|null $error
	 * @return bool
	 * @noinspection PhpUnusedParameterInspection
     */
    public function canGift(&$error = null): bool
    {
		if ($this->user_state !== 'valid' || !$this->user_id)
		{
			return false;
		}

		return $this->hasPermission('general', 'nf_gift');
	}

	/**
	 * @param Phrase|null $error
	 * @return bool
	 */
	public function canGiftForFree(?Phrase &$error = null): bool
	{
		if (!$this->canGift($error))
		{
			return false;
		}

		return $this->hasPermission('general', 'giftUpgradesForFree');
	}

	public function canViewGiftsList(&$error = null): bool
    {
		// todo: moderator access
		return $this->user_id === \XF::visitor()->user_id;
	}

	public function getGiftCount(): int
    {
		return $this->gift_received_count;
	}

	public function getGiftReceivedCount(): int
    {
		if (!$this->user_id)
		{
			return 0;
		}

		return GiftUpgradeRepo::get()->countGiftsReceivedByUser($this);
	}

	public function getGiftGivenCount(): int
    {
		if (!$this->user_id)
		{
			return 0;
		}

		return GiftUpgradeRepo::get()->countGiftsGivenByUser($this);
	}

	/**
	 * @param Structure $structure
	 *
	 * @return Structure
	 */
	public static function getStructure(Structure $structure)
	{
		$structure = parent::getStructure($structure);

		$structure->getters['gift_received_count'] = true;
		$structure->getters['gift_given_count'] = true;

		return $structure;
	}
}