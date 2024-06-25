<?php

namespace NF\GiftUpgrades\Entity;

use NF\GiftUpgrades\Repository\GiftUpgrade as GiftUpgradeRepo;
use XF\Entity\User;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

/**
 * COLUMNS
 * @property int $gift_id
 * @property int $user_upgrade_record_id
 * @property string $content_type
 * @property int $content_id
 * @property int $gift_user_id
 * @property int $is_anonymous
 * @property int $gift_date
 * @property int $content_user_id
 * @property bool $gifted_for_free
 *
 * GETTERS
 * @property-read IGiftable|Entity|null $Content
 *
 * RELATIONS
 * @property-read ?User $User
 * @property-read ?User $ContentUser
 */
class GiftUpgrade extends Entity
{
	public function canView(&$error = null): bool
	{
		$handler = $this->getHandler();
		$content = $this->Content;

		if ($handler && $content)
		{
			return $handler->canViewContent($content, $error);
		}

		return false;
	}

	public function getHandler(): ?\NF\GiftUpgrades\Gift\AbstractHandler
	{
		return GiftUpgradeRepo::get()->getGiftHandler($this->content_type);
	}

	/**
	 * @return null|\XF\Mvc\Entity\ArrayCollection|Entity
	 * @throws \Exception
	 */
	public function getContent()
	{
		$handler = $this->getHandler();
		return $handler ? $handler->getContent($this->content_id) : null;
	}

	/**
	 * @param IGiftable|null $content
	 */
	public function setContent(?IGiftable $content): void
	{
		$this->_getterCache['Content'] = $content;
	}

	protected function rebuildGiftCount(): void
	{
		$content = $this->Content;
		if ($content)
		{
            GiftUpgradeRepo::get()->rebuildGiftCounts($content);
		}
	}

	protected function _postSave(): void
	{
		if ($this->isInsert())
		{
			$this->rebuildGiftCount();
			$this->logStatIfNeeded();
		}
	}

	protected function logStatIfNeeded(): void
	{
		$upgradeId = $this->getOption('log_stat_for_upgrade_id');
		if (!$upgradeId)
		{
			return;
		}

		$this->db()->insert('xf_nixfifty_gift_upgrade_statistics', [
			'gift_upgrade_id' => $upgradeId,
			'stat_date' => \XF::$time,
		]);
	}

	protected function _postDelete(): void
	{
		$this->rebuildGiftCount();
	}

	public static function getStructure(Structure $structure): Structure
	{
		$structure->table = 'xf_nf_gifted_content';
		$structure->shortName = 'NF\GiftUpgrades:GiftUpgrade';
		$structure->primaryKey = 'gift_id';
		$structure->columns = [
			'gift_id' => ['type' => self::UINT, 'autoIncrement' => true, 'nullable' => true],
			'user_upgrade_record_id' => ['type' => self::UINT, 'required' => true],
			'content_type' => ['type' => self::STR, 'maxLength' => 25, 'required' => true],
			'content_id' => ['type' => self::UINT, 'required' => true],
			'gift_user_id' => ['type' => self::UINT, 'required' => true],
			'is_anonymous' => ['type' => self::BOOL, 'default' => false],
			'gift_date' => ['type' => self::UINT, 'default' => \XF::$time],
			'content_user_id' => ['type' => self::UINT, 'required' => true],
			'gifted_for_free' => ['type' => static::BOOL, 'default' => false],
		];
		$structure->relations = [
			'User' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => [['user_id', '=', '$gift_user_id']],
				'primary' => true,
			],
			'ContentUser' => [
				'entity' => 'XF:User',
				'type' => self::TO_ONE,
				'conditions' => [['user_id', '=', '$content_user_id']],
				'primary' => true,
			],
		];
		$structure->getters['Content'] = true;
		$structure->options = [
			'log_stat_for_upgrade_id' => null,
		];

		return $structure;
	}
}