<?php

namespace SV\MultiPrefix\Behavior;

use XF\Mvc\Entity\Behavior;
use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Structure;

class MultiPrefixable extends Behavior
{
    /**
     * @return array
     */
    protected function getDefaultConfig()
    {
        return [
            'prefixIdField'      => 'prefix_id',
            'containerIdField'   => null, // node_id
            'containerRelation'  => null,
            'containerPhrase'    => null,
            'isPrefixUsableFunc' => 'isPrefixUsable',
            'isPrefixValidFunc'  => 'isPrefixValid',
            'extraChangeFields'  => [],
            'linkTable'          => null,
            'prefixContentType'  => $this->entity->getEntityContentType(),

            'phrases' => [
                'prefix_cannot_be_used_selected'              => 'sv_multiprefix_selected_prefix_cannot_be_used_selected_{container}',
                'prefixes_cannot_be_used_selected'            => 'sv_multiprefix_selected_prefixes_cannot_be_used_selected_{container}',
                'no_have_permission_for_prefix'               => 'sv_multiprefix_you_do_not_have_permission_to_use_x_prefix_in_selected_{container}',
                'no_have_permission_for_prefixes'             => 'sv_multiprefix_you_do_not_have_permission_to_use_x_prefixes_in_selected_{container}',
                'min_prefixes_not_met'                        => 'sv_multiprefix_minimum_prefixes_requirement_for_this_{container}_x_has_not_been_met',
                'max_prefixes_exceed'                         => 'sv_multiprefix_maximum_prefixes_for_this_{container}_x_has_been_exceeded',
                'no_have_permission_to_remove_prefix'         => 'sv_multiprefix_prefix_added_by_moderator_cannot_be_removed',
                'no_have_permission_to_remove_prefixes'       => 'sv_multiprefix_prefixes_added_by_moderator_cannot_be_removed'
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getDefaultOptions()
    {
        return [
            'silentIgnoreMinPrefixLimit' => true,
            'silentApplyMaxPrefixLimit'  => true,
        ];
    }

    /**
     * @return void
     *
     * @throws \LogicException
     */
    protected function verifyConfig()
    {
        if (!$this->contentType())
        {
            throw new \LogicException("Structure must provide a contentType value");
        }

        if ($this->config['containerRelation'] === null)
        {
            throw new \LogicException("containerRelation config must be overridden");
        }
        if ($this->config['containerIdField'] === null)
        {
            throw new \LogicException("containerIdField config must be overridden");
        }
        if ($this->config['linkTable'] === null)
        {
            throw new \LogicException("linkTable config must be overridden");
        }
        if ($this->config['containerPhrase'] === null)
        {
            throw new \LogicException("containerPhrase config must be overridden");
        }
    }


    /**
     * @param       $error
     * @param array $params
     * @param null  $key
     */
    protected function entityError($error, array $params = [], $key = null)
    {
        if (empty($this->config['phrases'][$error]))
        {
            throw new \LogicException('Unkownn phrase for MultiPrefix Behavior:' . $error);
        }

        $containerName = $this->getConfig('containerPhrase');
        $template = $this->config['phrases'][$error];
        $template = \str_replace('{container}', $containerName, $template);

        $this->entity->error(\XF::phrase($template, $params), $key);
    }

    /** @var Entity|null */
    protected $container = null;
    /** @var callable */
    protected $isPrefixUsableFunc = null;
    /** @var callable */
    protected $isPrefixValidFunc = null;

    /**
     * @return Entity|null
     */
    protected function container()
    {
        if (!$this->container)
        {
            $this->container = $this->entity->getRelation($this->getConfig('containerRelation'));
        }

        return $this->container;
    }

    /**
     * @param int $prefixId
     * @return bool
     */
    protected function isPrefixUsable($prefixId)
    {
        if ($this->isPrefixUsableFunc === null)
        {
            $container = $this->container();
            $this->isPrefixUsableFunc = [$container, $this->getConfig('isPrefixUsableFunc')];
            if (\is_callable('Closure::fromCallable'))
            {
                /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
                $this->isPrefixUsableFunc = \Closure::fromCallable($this->isPrefixUsableFunc);
            }
        }
        $callable = $this->isPrefixUsableFunc;

        return $callable($prefixId);
    }

    /**
     * @param int $prefixId
     * @return bool
     */
    protected function isPrefixValid($prefixId)
    {
        if ($this->isPrefixValidFunc === null)
        {
            $container = $this->container();
            $this->isPrefixValidFunc = [$container, $this->getConfig('isPrefixValidFunc')];
            if (\is_callable('Closure::fromCallable'))
            {
                /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
                $this->isPrefixValidFunc = \Closure::fromCallable($this->isPrefixValidFunc);
            }
        }
        $callable = $this->isPrefixValidFunc;

        return $callable($prefixId);
    }

    /**
     * @param array $existingPrefixes
     * @param array $svPrefixIds
     * @return array
     */
    protected function getPossibleModAppliedPrefixes(array $existingPrefixes, array $svPrefixIds)
    {
        if (!\XF::options()->svBlockRemovePrefixWithNoPerm || !$existingPrefixes)
        {
            return [];
        }
        $possibleModAppliedPrefixes = [];

        $removedPrefixes = \array_diff($existingPrefixes, $svPrefixIds);

        foreach ($removedPrefixes as $removedPrefix)
        {
            if ($removedPrefix &&
                $this->isPrefixValid($removedPrefix) &&
                !$this->isPrefixUsable($removedPrefix))
            {
                $possibleModAppliedPrefixes[] = $removedPrefix;
            }
        }

        return $possibleModAppliedPrefixes;
    }

    public static function sortPrefixes(array &$prefixes, string $contentType)
    {
        if (\count($prefixes) === 0)
        {
            return;
        }

        $prefixCache = \XF::app()->container('prefixes.' . $contentType);
        $prefixOrderMap = [];
        $i = 0;
        foreach ($prefixCache as $prefixId => $label)
        {
            $prefixOrderMap[$prefixId] = $i;
            $i++;
        }

        if ($i === 0)
        {
            return;
        }

        \usort($prefixes, function ($a, $b) use ($prefixOrderMap) {
            $aIndex = $prefixOrderMap[$a] ?? 0;
            $bIndex = $prefixOrderMap[$b] ?? 0;
            if ($aIndex === $bIndex)
            {
                return 0;
            }

            return ($aIndex < $bIndex) ? -1 : 1;
        });
    }

    /**
     * @param Entity      $entity
     * @param string      $key
     * @param bool        $forceSort
     * @param string|null $contentType
     * @return array
     */
    public static function getSvPrefixIds(Entity $entity, $key = 'sv_prefix_ids_', $forceSort = false, $contentType = null)
    {
        $prefixes = $entity->get($key);
        if (!$prefixes)
        {
            return [];
        }

        $prefixes = \array_map('\intval', $prefixes);

        if ($prefixes && ($forceSort || \XF::options()->svMultiprefixSortDisplay))
        {
            if (!$contentType)
            {
                $contentType = $entity->getEntityContentType();
            }
            static::sortPrefixes($prefixes, $contentType);
        }

        return $prefixes;
    }

    /**
     * @return array
     */
    protected function getExistingSvPrefixIds(): array
    {
        $prefixes = $this->entity->getExistingValue('sv_prefix_ids') ?? [];
        if (\count($prefixes) !== 0)
        {
            $prefixes = \array_map('\intval', $prefixes);
        }

        return $prefixes;
    }

    public static function getPreviousPrefixIds(Entity $entity): array
    {
        $prefixes = $entity->getPreviousValue('sv_prefix_ids') ?? [];
        if (\count($prefixes) !== 0)
        {
            $prefixes = \array_map('\intval', $prefixes);
        }

        return $prefixes;
    }

    /**
     * @param $contentType
     * @param $prefixId
     *
     * @return \XF\Phrase
     */
    protected function fnPrefixTitle($contentType, $prefixId)
    {
        return \XF::phrase($contentType . '_prefix.' . $prefixId, [], false);
    }

    /**
     * @param int[] $prefixIds
     * @return string
     */
    protected function renderPrefixList(array $prefixIds)
    {
        $list = [];
        $contentType = $this->contentType();
        foreach ($prefixIds as $prefixId)
        {
            $list[] = $this->fnPrefixTitle($contentType, $prefixId);
        }

        return \implode(', ', $list);
    }

    /**
     * Rebuilds prefixes following various validation rules;
     * - if a user has not changed prefixes, or changed the node/user, do not apply max/min rules which might change since the prefixes where created
     * - if the XF stock prefix_id is changed, but not sv_prefix_ids, then it is used as a source instead
     * - a user can add a prefix without removing prefixes they can not use
     * - a user can add a prefix, unless the container maximum is not met
     * - a user can only add usable prefixes, prefixId 0 is never usable but means all prefixes are removed
     * - a user can remove any prefix, unless the container minimum is not met
     * - on moving to a new container, prefixes which are not valid for the destination are stripped
     * - on moving to a new container, the new container maximum is silently applied
     *
     * @param array $svPrefixIds
     * @param bool  $xfPrefixChanged
     * @param bool  $prefixesChanged
     * @param bool  $containerChanged
     * @param bool  $ownerChanged
     * @param bool  $changeFields
     * @return bool
     */
    protected function rebuildSvPrefixIds(array &$svPrefixIds, $xfPrefixChanged, $prefixesChanged, $containerChanged, $ownerChanged, $changeFields)
    {
        $entityPrefixId = $this->entity->get($this->getConfig('prefixIdField'));
        $existingPrefixes = $this->getExistingSvPrefixIds();
        if ($containerChanged && $entityPrefixId === 0)
        {
            $prefixesChanged = true;
        }

        // todo - fixup this logic
        if ($xfPrefixChanged || $prefixesChanged || $containerChanged || $ownerChanged || $changeFields)
        {
            if ($prefixesChanged)
            {
                $newPrefixIds = [];
                $invalidPrefixIds = [];
                $notUsableIds = [];
                $possibleModAppliedPrefixes = $this->getPossibleModAppliedPrefixes($existingPrefixes, $svPrefixIds);

                foreach ($svPrefixIds AS $prefixId)
                {
                    $addPrefix = true;
                    $validatorMethod = 'isPrefixValid';
                    $prefixId = \intval($prefixId);
                    if (!$prefixId)
                    {
                        continue;
                    }

                    if ($prefixId !== $entityPrefixId)
                    {
                        if (!\in_array($prefixId, $existingPrefixes) || $containerChanged || $ownerChanged)
                        {
                            $validatorMethod = 'isPrefixUsable';
                        }

                        $addPrefix = $this->$validatorMethod($prefixId);
                    }

                    if ($addPrefix)
                    {
                        // array_unique does not preserve ordering
                        if (empty($newPrefixIds[$prefixId]))
                        {
                            $newPrefixIds[$prefixId] = true;
                        }
                    }
                    else if ($validatorMethod === 'isPrefixValid')
                    {
                        if (empty($invalidPrefixIds[$prefixId]))
                        {
                            $invalidPrefixIds[$prefixId] = true;
                        }
                    }
                    else if ($validatorMethod === 'isPrefixUsable')
                    {
                        if (empty($notUsableIds[$prefixId]))
                        {
                            $notUsableIds[$prefixId] = true;
                        }
                    }
                }

                if ($this->getOption('silentApplyMaxPrefixLimit') === false)
                {
                    if (!empty($possibleModAppliedPrefixes))
                    {
                        $es = '';

                        if (\count($possibleModAppliedPrefixes) > 1)
                        {
                            $es .= 'es';
                        }

                        $this->entityError("no_have_permission_to_remove_prefix{$es}", [
                            'prefixes' => $this->renderPrefixList($possibleModAppliedPrefixes)
                        ]);

                        return false;
                    }
                    else if (!empty($invalidPrefixIds))
                    {
                        $es = \count($invalidPrefixIds) > 1 ? 'es' : '';

                        $this->entityError("prefix{$es}_cannot_be_used_selected", [
                            'prefixes' => $this->renderPrefixList(\array_keys($invalidPrefixIds))
                        ]);

                        return false;
                    }
                    else if (!empty($notUsableIds))
                    {
                        $es = \count($notUsableIds) > 1 ? 'es' : '';

                        $this->entityError("no_have_permission_for_prefix{$es}", [
                            'prefixes' => $this->renderPrefixList(\array_keys($notUsableIds))
                        ]);

                        return false;
                    }
                }

                // Ensure sorting by prefix display ordering
                $svPrefixIds = [];
                $prefixCache = \XF::app()->container('prefixes.' . $this->getConfig('prefixContentType'));
                foreach($prefixCache as $prefixId => $class)
                {
                    if (isset($newPrefixIds[$prefixId]))
                    {
                        $svPrefixIds[] = $prefixId;
                    }
                }
            }
        }
        else
        {
            $possibleModAppliedPrefixes = $this->getPossibleModAppliedPrefixes($existingPrefixes, $svPrefixIds);
        }

        // this is required because of services which call setPrefix before
        // also no need to worry about isPrefixUsable/isPrefixValid because those are already called in _preSave
        if ($xfPrefixChanged && !$prefixesChanged)
        {
            $svPrefixIds = [$entityPrefixId];
        }

        if ($xfPrefixChanged || $prefixesChanged || $containerChanged)
        {
            $container = $this->container();
            $minPrefixes = $container->get('sv_min_prefixes');
            $maxPrefixes = $container->get('sv_max_prefixes');

            if ($this->getOption('silentIgnoreMinPrefixLimit') === false && $minPrefixes && \count($svPrefixIds) < $minPrefixes)
            {
                $this->entityError("min_prefixes_not_met", [
                    'max' => \XF::language()->numberFormat($minPrefixes)
                ]);

                return false;
            }

            if ($maxPrefixes && \count($svPrefixIds) > $maxPrefixes)
            {
                if ($this->getOption('silentApplyMaxPrefixLimit') === true)
                {
                    $prefixesToSlice = $svPrefixIds;

                    // we want to make sure possible mod applied prefixes stay as much as possible
                    if (!empty($possibleModAppliedPrefixes) && \count($possibleModAppliedPrefixes) >= $maxPrefixes)
                    {
                        $prefixesToSlice = $possibleModAppliedPrefixes;
                    }

                    $svPrefixIds = \array_slice($prefixesToSlice, 0, $maxPrefixes);
                }
                else
                {
                    $phraseName = 'max_prefixes_exceed';
                    $phraseData = [
                        'max' => \XF::language()->numberFormat($maxPrefixes)
                    ];

                    if (!empty($possibleModAppliedPrefixes))
                    {
                        $es = '';
                        if (\count($possibleModAppliedPrefixes) > 1)
                        {
                            $es .= 'es';
                        }
                        $phraseName = "no_have_permission_to_remove_prefix{$es}";
                        $phraseData = [
                            'max' => \XF::language()->numberFormat($maxPrefixes)
                        ];
                    }

                    $this->entityError($phraseName, $phraseData);

                    return false;
                }
            }
        }

        return true;
    }

    public function preSave()
    {
        $prefixIdField = $this->getConfig('prefixIdField');
        $containerChanged = $this->entity->isChanged($this->getConfig('containerIdField'));
        $xfPrefixChanged = $this->entity->isChanged($prefixIdField);
        $prefixesChanged = $this->entity->isChanged('sv_prefix_ids');
        $ownerChanged = $this->entity->isChanged('user_id');
        $changeFields = !empty($this->getConfig('extraChangeFields')) && $this->entity->isChanged($this->getConfig('extraChangeFields'));

        // work-around for prefix_id column being left as string-like
        // deliberately use non-strict equality check
        if ($xfPrefixChanged && !$prefixesChanged &&
            $this->entity->getExistingValue($prefixIdField) == $this->entity->get($prefixIdField))
        {
            $this->entity->setTrusted($prefixIdField, \intval($this->entity->get($prefixIdField)));
            $xfPrefixChanged = $this->entity->isChanged($prefixIdField);
        }

        if ($xfPrefixChanged || $prefixesChanged || $containerChanged || $ownerChanged || $changeFields)
        {
            $prefixIds = $this->entity->get('sv_prefix_ids') ?? [];
            $this->rebuildSvPrefixIds($prefixIds, $xfPrefixChanged, $prefixesChanged, $containerChanged, $ownerChanged, $changeFields);
            $this->entity->set('sv_prefix_ids', $prefixIds);
        }

        $prefixIds = $this->entity->get('sv_prefix_ids') ?? [];
        // recheck if sv_prefix_ids has changed
        if ($this->entity->isChanged('sv_prefix_ids'))
        {
            $this->entity->set($prefixIdField, \count($prefixIds) !== 0 ? \reset($prefixIds) : 0);
        }
        if (\count($prefixIds) === 0)
        {
            $this->entity->set('sv_prefix_ids', null);
        }
    }

    public function postSave()
    {
        if ($this->entity->isChanged(['sv_prefix_ids', $this->getConfig('containerIdField')]))
        {
            $this->rebuildPrefixLinks();
        }
    }

    public function rebuildPrefixLinks()
    {
        $prefixIds = $this->entity->get('sv_prefix_ids') ?? [];
        $prefixIdField = $this->getConfig('prefixIdField');
        $prefixId = (int)$this->entity->get($prefixIdField);
        if (\count($prefixIds) === 0 && $prefixId)
        {
            $prefixIds = [$prefixId];
            $this->entity->fastUpdate('sv_prefix_ids', $prefixIds);
        }
        $id = $this->id();
        $primaryKey = $this->entity->structure()->primaryKey;
        $linkTable = $this->getConfig('linkTable');

        $db = $this->entity->db();
        $db->delete($linkTable, $primaryKey . ' = ?', $id);

        foreach ($prefixIds AS $prefixId)
        {
            $db->insert($linkTable, [
                $primaryKey => $id,
                'prefix_id' => $prefixId
            ]);
        }
    }

    /**
     * @param Structure $structure
     */
    public static function addMultiPrefixFields(Structure $structure)
    {
        $structure->columns['sv_prefix_ids'] = [
            'type'     => Entity::LIST_COMMA,
            'default'  => [],
            'nullable' => true,
            'list' => ['type' => 'posint', 'unique' => true], // note; do not use sorting!
            'api' => true,
        ];
        $structure->getters['sv_prefix_ids'] = ['getter' => 'getSvPrefixIds', 'cache' => true];
    }
}
