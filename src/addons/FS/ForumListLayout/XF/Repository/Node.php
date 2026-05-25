<?php

namespace FS\ForumListLayout\XF\Repository;

class Node extends XFCP_Node
{   
        public function findNodesForList(\XF\Entity\Node $withinNode = null)
	{                             
            $finder = Parent::findNodesForList($withinNode);   

           //  Display Categories based on user's sorted-list (category node list) order (on forum list page)
            $this->orderByUserSortedCategories($finder);

            return $finder;
	}
        
        
        public function getCategoryNodeList(\XF\Entity\Node $withinNode = null, $with = null)
	{
            /** @var \XF\Finder\Node $finder */
            $finder = $this->finder('XF:Node');


            if ($withinNode)
            {
                    $finder->descendantOf($withinNode);
            }
            if ($with)
            {
                    $finder->with($with);
            }

            $finder->where('node_type_id','LIKE', 'Category')->where('parent_node_id', 0);

            $finder->listable()
                    ->setDefaultOrder('lft');

           // order by based on user's sorted-list (category node list)
           $this->orderByUserSortedCategories($finder);
           
           $nodes = $finder->fetch();
           
           return $this->filterViewable($nodes);
	}
        
        
        protected function orderByUserSortedCategories($finder)
        {
            $visitor = \XF::visitor();
            

            if($visitor->node_ids)
            {
                $nodeIds = $this->db()->quote($visitor->node_ids);

                $finder->order($finder->expression('FIELD(node_id,'.$nodeIds.')'));
            }

            return $finder;
        }
}