<?php

namespace SV\MultiPrefix\Repository;

use SV\StandardLib\Finder\SqlJoinTrait;
use XF\Entity\AbstractPrefix as AbstractPrefixEntity;
use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;
use XF\Repository\AbstractPrefixMap;

class MultiPrefix extends Repository
{
    public function updateMultiplePrefixAssociations(AbstractPrefixMap $abstractPrefixMap, AbstractPrefixEntity $prefix, array $contentIds)
    {
        $emptyKey = \array_search(0, $contentIds);
        if ($emptyKey !== false)
        {
            unset($contentIds[$emptyKey]);
        }
        $contentIds = \array_unique($contentIds);

        $structureData = AbstractPrefixMapExtender::_getStructureData($abstractPrefixMap);

        $existingAssociations = AbstractPrefixMapExtender::_getAssociationsForPrefix($abstractPrefixMap, $prefix);
        if (!\count($existingAssociations) && !$contentIds)
        {
            return;
        }

        $db = $this->db();
        $db->beginTransaction();

        $db->delete($structureData['table'], 'prefix_id = ?', $prefix->prefix_id);

        $map = [];

        foreach ($contentIds as $id)
        {
            $map[] = [
                $structureData['key'] => $id,
                'prefix_id'           => $prefix->prefix_id
            ];
        }
        if ($map)
        {
            $db->insertBulk($structureData['table'], $map);
        }

        $rebuildIds = $contentIds;

        foreach ($existingAssociations as $association)
        {
            $rebuildIds[] = $association->getValue($structureData['key']);
        }

        $rebuildIds = \array_unique($rebuildIds);
        AbstractPrefixMapExtender::_rebuildContentAssociationCache($abstractPrefixMap, $rebuildIds);

        $db->commit();
    }

    public function removeMultiplePrefixAssociations(AbstractPrefixMap $abstractPrefixMap, AbstractPrefixEntity $prefix)
    {
        $structureData = AbstractPrefixMapExtender::_getStructureData($abstractPrefixMap);

        /** @noinspection SqlResolve */
        $rebuildIds = $this->db()->fetchAllColumn("
			SELECT $structureData[key]
			FROM $structureData[table]
			WHERE prefix_id = ?
		", $prefix->prefix_id);

        if (!$rebuildIds)
        {
            return;
        }

        $db = $this->db();
        $db->beginTransaction();

        $db->delete($structureData['table'], 'prefix_id = ?', $prefix->prefix_id);

        AbstractPrefixMapExtender::_rebuildContentAssociationCache($abstractPrefixMap, $rebuildIds);

        $db->commit();
    }

    public function updateContentAssociationsForMultiplePrefixes(AbstractPrefixMap $abstractPrefixMap, $contentId, array $prefixIds)
    {
        $structureData = AbstractPrefixMapExtender::_getStructureData($abstractPrefixMap);

        $db = $this->db();
        $db->beginTransaction();

        $db->delete($structureData['table'], $structureData['key'] . ' = ?', $contentId);

        $map = [];

        foreach ($prefixIds as $prefixId)
        {
            $map[] = [
                $structureData['key'] => $contentId,
                'prefix_id'           => $prefixId
            ];
        }

        if ($map)
        {
            $db->insertBulk($structureData['table'], $map);
        }

        AbstractPrefixMapExtender::_rebuildContentAssociationCache($abstractPrefixMap, $contentId);

        $db->commit();
    }

    public function rebuildContentAssociationCacheForMultiplePrefixes(AbstractPrefixMap $abstractPrefixMap, $contentIds)
    {
        if (!\is_array($contentIds))
        {
            $contentIds = [$contentIds];
        }
        if (!$contentIds)
        {
            return;
        }

        $structureData = AbstractPrefixMapExtender::_getStructureData($abstractPrefixMap);

        $newCache = [];

        $prefixAssociations = $this->finder($structureData['mapEntity'])
                                   ->with('Prefix')
                                   ->where($structureData['key'], $contentIds)
                                   ->order('Prefix.materialized_order');
        foreach ($prefixAssociations->fetch() as $prefixMap)
        {
            $key = $prefixMap->get($structureData['key']);
            $newCache[$key][$prefixMap->prefix_id] = $prefixMap->prefix_id;
        }

        foreach ($contentIds as $contentId)
        {
            if (!isset($newCache[$contentId]))
            {
                $newCache[$contentId] = [];
            }
        }

        AbstractPrefixMapExtender::_updateAssociationCache($abstractPrefixMap, $newCache);
    }

    protected function assertValidMultiPrefixFinder(IMultiPrefixFinder $finder): array
    {
        if (!($finder instanceof Finder))
        {
            throw new \LogicException('IMultiPrefixFinder must be a finder');
        }
        /** @var Finder|IMultiPrefixFinder|SqlJoinTrait $finder */
        $primaryKey = $finder->getStructure()->primaryKey;
        if (!\is_string($primaryKey))
        {
            throw new \LogicException('MultiPrefix only supports single-key primary id entities');
        }

        $shortName = $finder->getMultiPrefixLinkTableEntity();
        $linkTable = $this->em->getEntityStructure($shortName)->table;

        $className = $this->em->getEntityClassName($shortName);
        if (!\is_callable([$className, 'getCategoryColumn']))
        {
            throw new \LogicException("MultiPrefix requires {$shortName} entity to have a 'public static function getCategoryColumn(): string' function");
        }
        $categoryColumn = $className::getCategoryColumn();

        // todo extract $categoryColumn somehow

        return [$finder, $primaryKey, $categoryColumn, $linkTable];
    }

    /**
     * @param IMultiPrefixFinder $finder
     * @return int[]
     * @noinspection RegExpUnnecessaryNonCapturingGroup
     * @noinspection RegExpRedundantEscape
     */
    public function extractCategoryFromFinder(IMultiPrefixFinder $finder): array
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        list ($finder, $primaryKey, $categoryColumn, $linkTable) = $this->assertValidMultiPrefixFinder($finder);
        /**
         * @var IMultiPrefixFinder|SqlJoinTrait|Finder $finder
         * @var string                                 $primaryKey
         * @var string                                 $categoryColumn
         * @var string                                 $linkTable
         */

        $nodeIdCol = $finder->columnSqlName($categoryColumn);
        $regex = "#" . \preg_quote($nodeIdCol, '#') . "\s+(?:(?:\= (\d+))|(?:in \(([^\)]+)\)))#i";
        $nodeIds = [];
        foreach ($finder->getConditions() as $condition)
        {
            if (\preg_match_all($regex, $condition, $matches))
            {
                if (isset($matches[1]))
                {
                    foreach ($matches[1] as $node)
                    {
                        $node = \intval($node);
                        if ($node)
                        {
                            $nodeIds[] = $node;
                        }
                    }
                }
                if (isset($matches[2]))
                {
                    foreach ($matches[2] as $nodeList)
                    {
                        $nodeList = \explode(',', $nodeList);
                        foreach ($nodeList as $node)
                        {
                            $node = \intval($node);
                            if ($node)
                            {
                                $nodeIds[] = $node;
                            }
                        }
                    }
                }
                break;
            }
        }

        return \array_filter(\array_unique($nodeIds, \SORT_NUMERIC));
    }

    /**
     * @param IMultiPrefixFinder             $finder
     * @param int|int[]|AbstractPrefixEntity $prefixIds
     * @param bool|null                      $andWhere
     */
    public function finderHasPrefixes(IMultiPrefixFinder $finder, $prefixIds, bool $andWhere = null)
    {
        list ($finder, $primaryKey, $categoryColumn, $linkTable) = $this->assertValidMultiPrefixFinder($finder);
        /**
         * @var IMultiPrefixFinder|SqlJoinTrait|Finder $finder
         * @var string                                 $primaryKey
         * @var string                                 $categoryColumn
         * @var string                                 $linkTable
         */

        if ($andWhere === null)
        {
            $options = \XF::options();
            $andWhere = !isset($options->svMultiPrefixMultipleFilter) || $options->svMultiPrefixMultipleFilter === 'and';
        }

        if ($prefixIds instanceof AbstractPrefixEntity)
        {
            $prefixIds = [$prefixIds->prefix_id];
        }

        if (!\is_array($prefixIds))
        {
            $prefixIds = [$prefixIds];
        }

        $db = $this->db();

        $none = false;
        $any = false;
        $prefixes = [];
        foreach ($prefixIds as $prefixId)
        {
            $prefixId = \intval($prefixId);
            if ($prefixId === 0)
            {
                $none = true;
                continue;
            }
            else if ($prefixId === -1)
            {
                $any = true;
                continue;
            }
            $prefixes[$prefixId] = true;
        }
        if ($none && $any)
        {
            if ($andWhere)
            {
                $finder->whereImpossible();
            }

            return;
        }
        // MySQL subquery performance is remarkably bad, so use a join...
        /*
        if ($prefixes)
        {
            $joinSQL = '';
            $whereSQL = '';
            if ($nodeIds)
            {
                $table = $finder->getStructure()->table;
                $joinSQL = "join {$table} on ({$table}.{$primaryKey} = link.{$primaryKey})";
                $whereSQL = "AND ({$table}.{$categoryColumn} in (" . $finder->quote($nodeIds) . '))';
            }
            $prefixes = \array_keys($prefixes);
            $count = $andWhere ? \count($prefixes) : 1;
            $itemIdCol = $finder->columnSqlName($primaryKey);
            $sql = "\n ({$itemIdCol} in (
                    select link.{$primaryKey}
                    from {$linkTable} link
                    {$joinSQL}
                    where link.prefix_id in (" . $db->quote($prefixes) . ") {$whereSQL}
                    group by link.{$primaryKey}
                    having count(*) >= {$count}
                )) ";
        }
        if ($none)
        {
            $prefixCol = $finder->columnSqlName('prefix_id');
            $sql = "({$prefixCol} = '0' ". ($sql ? ' OR '. $sql : '')  .")";

        }
        return $finder->where($finder->expression($sql));
        */

        $alias = '';
        if ($prefixes)
        {
            $joinSQL = '';
            $whereSQL = '';
            $nodeIds = $finder->extractCategoryIdsForMultiPrefix();
            if ($nodeIds)
            {
                $table = $finder->getStructure()->table;
                $joinSQL = "join {$table} on ({$table}.{$primaryKey} = link.{$primaryKey})";
                $whereSQL = "AND ({$table}.{$categoryColumn} in (" . $finder->quote($nodeIds) . '))';
            }

            $prefixes = \array_keys($prefixes);
            $count = $andWhere ? \count($prefixes) : 1;
            $alias = 'prefixLink_' . $finder->incrementAliasForMultiPrefixLink();

            $finder->sqlJoin("(
                    select link.{$primaryKey}
                    from {$linkTable} link
                    {$joinSQL}
                    where link.prefix_id in (" . $db->quote($prefixes) . ") {$whereSQL}
                    group by link.{$primaryKey}
                    having count(*) >= {$count}
                )", $alias, [$primaryKey], !$any, true);

            $finder->sqlJoinConditions($alias, [$primaryKey]);
        }
        if ($none)
        {
            if ($andWhere && $alias)
            {
                $finder->whereImpossible();

                return;
            }
            $prefixCol = $finder->columnSqlName('prefix_id');
            $sql = "({$prefixCol} = '0' " . ($alias ? " OR `$alias`.`$primaryKey` is not null" : '') . ")";
            $finder->where($finder->expression($sql));
        }
        else if ($any)
        {
            $prefixCol = $finder->columnSqlName('prefix_id');
            $sql = "({$prefixCol} <> '0' " . ($alias ? " OR `$alias`.`$primaryKey` is not null" : '') . ")";
            $finder->where($finder->expression($sql));
        }
    }

    /**
     * @param IMultiPrefixFinder             $finder
     * @param int|int[]|AbstractPrefixEntity $prefixIds
     */
    public function notHasPrefixes(IMultiPrefixFinder $finder, $prefixIds)
    {
        list ($finder, $primaryKey, $categoryColumn, $linkTable) = $this->assertValidMultiPrefixFinder($finder);
        /**
         * @var IMultiPrefixFinder|SqlJoinTrait|Finder $finder
         * @var string                                 $primaryKey
         * @var string                                 $categoryColumn
         * @var string                                 $linkTable
         */

        if ($prefixIds instanceof AbstractPrefixEntity)
        {
            $prefixIds = [$prefixIds->prefix_id];
        }

        if (!\is_array($prefixIds))
        {
            $prefixIds = [$prefixIds];
        }

        $db = $this->db();

        $none = false;
        $prefixes = [];
        foreach ($prefixIds as $prefixId)
        {
            $prefixId = \intval($prefixId);
            if ($prefixId === -1)
            {
                $none = true;
                continue;
            }
            $prefixes[$prefixId] = true;
        }
        $alias = '';
        if ($prefixes)
        {
            $joinSQL = '';
            $whereSQL = '';
            $nodeIds = $finder->extractCategoryIdsForMultiPrefix();
            if ($nodeIds)
            {
                $table = $finder->getStructure()->table;
                $joinSQL = "join {$table} on ({$table}.{$primaryKey} = link.{$primaryKey})";
                $whereSQL = "AND ({$table}.{$categoryColumn} in (" . $finder->quote($nodeIds) . '))';
            }

            $prefixes = \array_keys($prefixes);
            $alias = 'prefixLink_' . $finder->incrementAliasForMultiPrefixLink();

            $finder->sqlJoin("(
                    select link.{$primaryKey}
                    from {$linkTable} link
                    {$joinSQL}
                    where link.prefix_id in (" . $db->quote($prefixes) . ") {$whereSQL}
                    group by link.{$primaryKey}
                    having count(*) >= 1
                )", $alias, [$primaryKey], false, true);

            $finder->sqlJoinConditions($alias, [$primaryKey]);
        }
        $finder->where($alias . '.' . $primaryKey, '=', null);

        if ($none)
        {
            $finder->where('prefix_id', '<>', '0');
        }
    }
}