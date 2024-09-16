<?php

namespace SV\MultiPrefix\XF\Finder;

use SV\MultiPrefix\Repository\IMultiPrefixFinder;
use SV\MultiPrefix\Repository\MultiPrefix;
use SV\StandardLib\Finder\SqlJoinTrait;
use XF\Entity\AbstractPrefix;

class Thread extends XFCP_Thread implements IMultiPrefixFinder
{
    use SqlJoinTrait;

    protected $extractedNodes = false;
    protected $nodeIds = [];

    public function extractCategoryIdsForMultiPrefix(): array
    {
        if ($this->extractedNodes)
        {
            return $this->nodeIds;
        }
        /** @var MultiPrefix $repo */
        $repo = \XF::repository('SV\MultiPrefix:MultiPrefix');
        $this->nodeIds = $repo->extractCategoryFromFinder($this);
        $this->extractedNodes = true;

        return $this->nodeIds;
    }

    public function getMultiPrefixLinkTableEntity(): string
    {
        return 'SV\MultiPrefix:ThreadPrefixLink';
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