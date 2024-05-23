<?php

namespace XC\MarketPlace\Repository;

use function array_keys;
use XF\Repository\AbstractFieldMap;

class CategoryField extends AbstractFieldMap
{
    /**
     * @return string
     */
    protected function getMapEntityIdentifier()
    {
        return 'FS\QuizSystem:CategoryField';
    }

  
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
        $categories = $this->em->findByIds('FS\QuizSystem:Category', $categoryIds);


        foreach ($categories as $category) {

            $category->field_cache = $cache[$category->category_id];
            $category->saveIfChanged();
        }
    }
}
