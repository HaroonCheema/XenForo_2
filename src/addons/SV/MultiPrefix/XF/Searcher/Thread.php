<?php
/**
 * @noinspection PhpMissingReturnTypeInspection
 */

namespace SV\MultiPrefix\XF\Searcher;

use XF\Mvc\Entity\Finder;

class Thread extends XFCP_Thread
{
    protected function applySpecialCriteriaValue(Finder $finder, $key, $value, $column, $format, $relation)
    {
        if ($key === 'prefix_id')
        {
            /** @var \SV\MultiPrefix\XF\Finder\Thread $finder */
            $finder->hasPrefixes($value);

            return true;
        }

        return parent::applySpecialCriteriaValue($finder, $key, $value, $column, $format, $relation);
    }

    public function getFormDefaults()
    {
        $defaults = parent::getFormDefaults();

        $defaults['prefix_id'] = [];
        $defaults['add_prefixes'] = [];
        $defaults['remove_prefixes'] = [];

        return $defaults;
    }
}