<?php

namespace AVForums\TagEssentials\Repository;

use XF\Mvc\Entity\AbstractCollection;
use XF\Mvc\Entity\Repository;

/**
 * Class TagCategory
 *
 * @package AVForums\TagEssentials\Repository
 */
class TagCategory extends Repository
{
    /**
     * @return AbstractCollection
     */
    public function findTagCategoriesForList()
    {
        return $this->finder('AVForums\TagEssentials:TagCategory')->fetch();
    }

    /**
     * @return array|\XF\Mvc\Entity\ArrayCollection
     */
    public function getCategoryTitlePairs()
    {
        $tagCategories = $this->finder('AVForums\TagEssentials:TagCategory');

        return $tagCategories->fetch()->pluckNamed('title', 'category_id');
    }
}