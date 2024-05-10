<?php

namespace XenBulletins\BrandHub\XF\Repository;

class Node extends XFCP_Node
{    
    // get BrandHub Items node list
    public function getItemsNodeList(\XF\Entity\Node $withinNode = null, $nodeIds)
    {
        if ($withinNode && !$withinNode->hasChildren()) 
        {
            return \XF::em()->getEmptyCollection();
        }

        $nodes = $this->findNodesForList($withinNode, $nodeIds)->whereIds($nodeIds)->fetch();
        $this->loadNodeTypeDataForNodes($nodes);
        
        return $this->filterViewable($nodes);
    }
}