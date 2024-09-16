<?php

namespace SV\MultiPrefix\XF\Entity;

use SV\MultiPrefix\Behavior\MultiPrefixable;
use SV\MultiPrefix\ILinkablePrefix;
use XF\Mvc\Entity\Structure;

/**
 * @property int[] sv_prefix_ids
 * @property \SV\MultiPrefix\Entity\ThreadPrefixLink PrefixesLink
 */
class Thread extends XFCP_Thread implements ILinkablePrefix
{
    public function isPrefixEditable()
    {
        $prefixes = $this->sv_prefix_ids;
        $forum = $this->Forum;
        if (!$prefixes || !$forum)
        {
            return true;
        }

        foreach ($prefixes as $prefixId)
        {
            if (!$forum->isPrefixValid($prefixId) || $forum->isPrefixUsable($prefixId))
            {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getSvPrefixIds()
    {
        return MultiPrefixable::getSvPrefixIds($this);
    }

    public function getSvPrefixFilterLink(int $prefixId, string $linkType = ''): string
    {
        $forum = $this->Forum;
        return $forum ? \XF::app()->router()->buildLink($linkType . 'forums', $forum, ['prefix_id' => $prefixId]) : '';
    }

    public function rebuildCounters()
    {
        /** @var MultiPrefixable $behaviour */
        $behaviour = $this->getBehavior('SV\MultiPrefix:MultiPrefixable');
        if ($behaviour)
        {
            $db = $this->db();

            $db->beginTransaction();
            $behaviour->rebuildPrefixLinks();
            $db->commit();
        }

        parent::rebuildCounters();
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->relations['PrefixesLink'] = [
            'entity'        => 'SV\MultiPrefix:ThreadPrefixLink',
            'type'          => self::TO_MANY,
            'conditions'    => 'thread_id',
            'key'           => 'prefix_id',
            'cascadeDelete' => true
        ];

        $structure->behaviors['SV\MultiPrefix:MultiPrefixable'] = [
            'containerIdField'  => 'node_id',
            'containerRelation' => 'Forum',
            'containerPhrase'   => 'forum',
            'linkTable'         => 'xf_sv_thread_prefix_link',
        ];
        MultiPrefixable::addMultiPrefixFields($structure);

        return $structure;
    }
}
