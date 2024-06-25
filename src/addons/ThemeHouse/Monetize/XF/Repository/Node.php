<?php

namespace ThemeHouse\Monetize\XF\Repository;

/**
 * Class Node
 * @package ThemeHouse\Monetize\XF\Repository
 */
class Node extends XFCP_Node
{
    /**
     * @param \XF\Entity\Node|null $withinNode
     * @return \XF\Finder\Node
     */
    public function findNodesForList(\XF\Entity\Node $withinNode = null)
    {
        $finder = parent::findNodesForList($withinNode);
        $finder->with('Sponsor');
        return $finder;
    }
}
