<?php

namespace FS\ExcludeReactionScore\XF\Reaction;

use XF\Mvc\Entity\Entity;

class Post extends XFCP_Post
{
	public function reactionsCounted(Entity $entity)
	{
            $parent = parent::reactionsCounted($entity);
            
            if($parent && !$entity->Thread->Forum->count_reactions)   // if not count_reactions
            {
                return false;
            }
            
            return $parent;
	}
}