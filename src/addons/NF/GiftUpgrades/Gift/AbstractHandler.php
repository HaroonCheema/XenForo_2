<?php

namespace NF\GiftUpgrades\Gift;

use NF\GiftUpgrades\Entity\IGiftable;
use XF\Mvc\Entity\Entity;

/**
 * Class AbstractHandler
 *
 * @package NF\GiftUpgrades\Gift
 */
abstract class AbstractHandler
{
    /** @var string */
	protected $contentType;

    /**
     * AbstractHandler constructor.
     *
     * @param string $contentType
     */
	public function __construct(string $contentType)
	{
		$this->contentType = $contentType;
	}

	public function isSupported(): bool
    {
        $entityName = \XF::app()->getContentTypeEntity($this->contentType);
        if (!$entityName)
        {
            return false;
        }

        $structure = \XF::em()->getEntityStructure($entityName);
        return !empty($structure->columns['embed_metadata']);
    }

    /**
     * @param IGiftable|Entity $entity
     * @param null   $error
     * @return bool
     */
	public function canViewContent(Entity $entity, &$error = null): bool
	{
		if (method_exists($entity, 'canView'))
		{
			return $entity->canView($error);
		}

		throw new \LogicException('Could not determine content viewability; please override');
	}

	public function getEntityWith(): array
    {
		return [];
	}

    /**
     * @param Entity $entity
     * @return \NF\GiftUpgrades\XF\Entity\User|\XF\Entity\User
     */
    abstract public function getContentUser(Entity $entity): \XF\Entity\User;

    /**
     * @param IGiftable|Entity $entity
     * @return string
     */
    abstract public function getContentUrl(Entity $entity): string;

    abstract public function getGiftRoute(): string;
    abstract public function getGiftsRoute(): string;

    public function canViewGiftsList(): bool
    {
        return true;
    }

    abstract public function getBreadCrumbs(Entity $entity): array;

    /**
     * @param array|int $id
     *
     * @return null|\XF\Mvc\Entity\ArrayCollection|Entity
     */
	public function getContent($id)
	{
        return \XF::app()->findByContentType($this->contentType, $id, $this->getEntityWith());
	}

	public function getContentType(): string
	{
		return $this->contentType;
	}
}