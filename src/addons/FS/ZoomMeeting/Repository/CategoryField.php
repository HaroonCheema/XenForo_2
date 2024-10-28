<?php

namespace FS\ZoomMeeting\Repository;

use function array_keys;
use XF\Repository\AbstractFieldMap;

class CategoryField extends AbstractFieldMap
{
    /**
     * @return string
     */
    protected function getMapEntityIdentifier()
    {
        return 'FS\ZoomMeeting:CategoryField';
    }

    /**
     * @param \XF\Entity\AbstractField $field
     * @return mixed
     */
    protected function getAssociationsForField(\XF\Entity\AbstractField $field)
    {
        
        return $field->getRelation('CategoryFields');
    }
    
    

    /**
     * @param array $cache
     * @return void
     */
    protected function updateAssociationCache(array $cache)
    {
        $categoryIds = array_keys($cache);
        $categories = $this->em->findByIds('FS\ZoomMeeting:Category', $categoryIds);


        foreach ($categories as $category) {
            /** @var \Truonglv\Groups\Entity\Category $category */
            $category->field_cache = $cache[$category->category_id];
            $category->saveIfChanged();
        }
    }
}
