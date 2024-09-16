<?php

namespace SV\MultiPrefix\Repository;


use XF\Repository\AbstractPrefixMap;

abstract class AbstractPrefixMapExtender extends AbstractPrefixMap
{
    public static function _getStructureData(AbstractPrefixMap $abstractPrefixMap): array
    {
        return $abstractPrefixMap->getStructureData();
    }

    public static function _getAssociationsForPrefix(AbstractPrefixMap $abstractPrefixMap, \XF\Entity\AbstractPrefix $prefix)
    {
        return $abstractPrefixMap->getAssociationsForPrefix($prefix);
    }

    public static function _rebuildContentAssociationCache(AbstractPrefixMap $abstractPrefixMap, $contentIds)
    {
        $abstractPrefixMap->rebuildContentAssociationCache($contentIds);
    }

    public static function _updateAssociationCache(AbstractPrefixMap $abstractPrefixMap, $contentIds)
    {
        $abstractPrefixMap->updateAssociationCache($contentIds);
    }
}