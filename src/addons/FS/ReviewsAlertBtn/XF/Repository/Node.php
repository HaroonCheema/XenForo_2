<?php

namespace FS\ReviewsAlertBtn\XF\Repository;


class Node extends XFCP_Node
{
    public function getReviewsAlertNodeList(\XF\Entity\Node $withinNode = null, $typeForums)
    {
        if ($withinNode && !$withinNode->hasChildren()) {
            return $this->em->getEmptyCollection();
        }

        $nodes = $this->findNodesForListReviewsAlert($withinNode, $typeForums)->fetch();
        $this->loadNodeTypeDataForNodes($nodes);

        return $this->filterViewable($nodes);
    }

    public function findNodesForListReviewsAlert(\XF\Entity\Node $withinNode = null, $typeForums)
    {
        $nodeIds = $this->finder('XF:Node');

        $nodeIds->where('title', 'LIKE', $nodeIds->escapeLike($typeForums, '%?%'));

        $allNodeIds = $nodeIds->pluckfrom('node_id')->fetch()->toArray();
        $parentNodeIds = $nodeIds->pluckfrom('parent_node_id')->fetch()->toArray();

        $parentParentNodeId = $this->finder('XF:Node')->where('node_id', $parentNodeIds);

        $parentParentNodeIds = $parentParentNodeId->pluckfrom('parent_node_id')->fetch()->toArray();

        $conditions = [
            ['node_id', $allNodeIds],
            ['node_id', $parentNodeIds],
            ['node_id', $parentParentNodeIds],
        ];

        /** @var \XF\Finder\Node $finder */
        $finder = $this->finder('XF:Node');

        $finder->whereOr($conditions);

        if ($withinNode) {
            $finder->descendantOf($withinNode);
        }
        $finder->listable()
            ->setDefaultOrder('lft');

        return $finder;
    }
}
