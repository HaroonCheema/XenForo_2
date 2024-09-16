<?php

namespace SV\MultiPrefix\Repository;

use XF\Repository\AbstractPrefixMap;

trait MultiPrefixRepoTrait
{
    public function updatePrefixAssociations(\XF\Entity\AbstractPrefix $prefix, array $contentIds)
    {
        /** @var AbstractPrefixMap $this */
        /** @var MultiPrefix $repo */
        $repo = \XF::repository('SV\MultiPrefix:MultiPrefix');
        $repo->updateMultiplePrefixAssociations($this, $prefix, $contentIds);
    }

    public function removePrefixAssociations(\XF\Entity\AbstractPrefix $prefix)
    {
        /** @var AbstractPrefixMap $this */
        /** @var MultiPrefix $repo */
        $repo = \XF::repository('SV\MultiPrefix:MultiPrefix');
        $repo->removeMultiplePrefixAssociations($this, $prefix);
    }

    public function updateContentAssociations($contentId, array $prefixIds)
    {
        /** @var AbstractPrefixMap $this */
        /** @var MultiPrefix $repo */
        $repo = \XF::repository('SV\MultiPrefix:MultiPrefix');
        $repo->updateContentAssociationsForMultiplePrefixes($this, $contentId, $prefixIds);
    }

    public function rebuildContentAssociationCache($contentIds)
    {
        /** @var AbstractPrefixMap $this */
        /** @var MultiPrefix $repo */
        $repo = \XF::repository('SV\MultiPrefix:MultiPrefix');
        $repo->rebuildContentAssociationCacheForMultiplePrefixes($this, $contentIds);
    }
}