<?php

namespace SV\MultiPrefix\DBTech\eCommerce\Finder;

use SV\MultiPrefix\Repository\IMultiPrefixFinder;
use SV\MultiPrefix\Repository\MultiPrefix;
use SV\StandardLib\Finder\SqlJoinTrait;
use XF\Entity\AbstractPrefix;

class Product extends XFCP_Product implements IMultiPrefixFinder
{
    use SqlJoinTrait;

    protected $extractedCategories = false;
    protected $categoryIds = [];

    public function extractCategoryIdsForMultiPrefix(): array
    {
        if ($this->extractedCategories)
        {
            return $this->categoryIds;
        }
        /** @var MultiPrefix $repo */
        $repo = \XF::repository('SV\MultiPrefix:MultiPrefix');
        $this->categoryIds = $repo->extractCategoryFromFinder($this);
        $this->extractedCategories = true;

        return $this->categoryIds;
    }

    public function getMultiPrefixLinkTableEntity(): string
    {
        return 'SV\MultiPrefix:DBTecheCommerceProductPrefixLink';
    }

    public function incrementAliasForMultiPrefixLink(): int
    {
        return $this->aliasCounter++;
    }

    /**
     * @param int|int[]|AbstractPrefix $prefixIds
     * @param bool|null $andWhere
     * @return $this
     */
    public function hasPrefixes($prefixIds, bool $andWhere = null): self
    {
        /** @var MultiPrefix $repo */
        $repo = \XF::repository('SV\MultiPrefix:MultiPrefix');
        $repo->finderHasPrefixes($this, $prefixIds, $andWhere);

        return $this;
    }

    /**
     * @param int|int[]|AbstractPrefix $prefixIds
     * @return $this
     */
    public function notHasPrefixes($prefixIds): self
    {
        /** @var MultiPrefix $repo */
        $repo = \XF::repository('SV\MultiPrefix:MultiPrefix');
        $repo->notHasPrefixes($this, $prefixIds);

        return $this;
    }
}