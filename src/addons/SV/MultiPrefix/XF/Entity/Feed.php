<?php

namespace SV\MultiPrefix\XF\Entity;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use XF\Mvc\Entity\Structure;

/**
 * Extends \XF\Entity\Feed
 *
 * @property int[] sv_prefix_ids
 */
class Feed extends XFCP_Feed
{
    /**
     * @return array
     */
    public function getSvPrefixIds()
    {
        return MultiPrefixable::getSvPrefixIds($this, 'sv_prefix_ids_', false, 'thread');
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        MultiPrefixable::addMultiPrefixFields($structure);

        return $structure;
    }
}