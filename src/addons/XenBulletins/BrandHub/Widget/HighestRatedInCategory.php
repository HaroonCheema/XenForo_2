<?php

namespace XenBulletins\BrandHub\Widget;

class HighestRatedInCategory extends \XF\Widget\AbstractWidget {

    public function render() {


//        $explodeUrl = explode("/", $_SERVER['REQUEST_URI']);
         
//        $itemId = substr($explodeUrl, -1);
        
        
        
        $routePath = \XF::app()->request()->getRoutePath();
        
        $itemId = substr($routePath, -1);
        
                


        $item = $this->finder('XenBulletins\BrandHub:Item')->with('Category')->where('item_id', $itemId)->fetchOne();
        
        $highestRatedItems = [];
        
        if ($item) {

            $numberOfItems = \XF::options()->bh_highest_rated_items;
            $highestRatedItems = $this->Finder('XenBulletins\BrandHub:Item')->where('category_id', $item->Category->category_id)->where('rating_avg', '!=', 0)->order('rating_avg', 'DESC')->fetch($numberOfItems);
        }
        
        $viewParams = [
            'highestRatedItems' => $highestRatedItems,
        ];
        return $this->renderer('bh_highestRatedItems', $viewParams);
    }

}