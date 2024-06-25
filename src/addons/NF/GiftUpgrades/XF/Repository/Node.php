<?php

namespace NF\GiftUpgrades\XF\Repository;



/**
 * Extends \XF\Repository\Node
 */
class Node extends XFCP_Node
{
    protected $nodeListCachePermCombId = null;
    protected $nodeListCache = null;

    /**
     * @param \XF\Entity\Node|null $withinNode
     *
     * @return null|\XF\Mvc\Entity\AbstractCollection|\XF\Mvc\Entity\ArrayCollection
     */
    public function getNodeList(\XF\Entity\Node $withinNode = null)
    {
        $visitor = \XF::visitor();
        if ($withinNode === null)
        {
            $nodeListCachePermCombId = $visitor->permission_combination_id;
            if ($this->nodeListCache === null || $nodeListCachePermCombId !== $this->nodeListCachePermCombId)
            {
                $this->nodeListCachePermCombId = $nodeListCachePermCombId;
                $this->nodeListCache = parent::getNodeList($withinNode);
            }

            return $this->nodeListCache;
        }

        return parent::getNodeList($withinNode);
    }
}