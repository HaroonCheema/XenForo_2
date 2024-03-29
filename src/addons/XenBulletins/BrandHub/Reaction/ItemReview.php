<?php

namespace XenBulletins\BrandHub\Reaction;

use XF\Mvc\Entity\Entity;
use XF\Reaction\AbstractHandler;

class ItemReview extends AbstractHandler 
{
    public function reactionsCounted(Entity $entity) 
    {
        return $entity->rating_state == 'visible';
    }
}