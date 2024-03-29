<?php

namespace XenBulletins\BrandHub;

use XF\Util\Arr;
use XenBulletins\BrandHub\Helper;

class Listener {


    public static function appSetup(\XF\App $app) {
        $container = $app->container();

        $container['customFields.bhItemfield'] = $app->fromRegistry('bhItemfield', function(\XF\Container $c) {
            return $c['em']->getRepository('XenBulletins\BrandHub:ItemField')->rebuildFieldCache();
        }, function(array $mediaFieldsInfo) {
            $definitionSet = new \XF\CustomField\DefinitionSet($mediaFieldsInfo);

            return $definitionSet;
        }
        );
    }
    
    public static function addonPostInstall(\XF\AddOn\AddOn $addOn, \XF\Entity\AddOn $installedAddOn, array $json, array &$stateChanges) 
    {
        if($installedAddOn->addon_id == "XenBulletins/BrandHub")
        {
            Helper::updateAddonOptions();
        }
    }
    
    public static function addonPostUpgrade(\XF\AddOn\AddOn $addOn, \XF\Entity\AddOn $installedAddOn, array $json, array &$stateChanges) 
    {
        if($installedAddOn->addon_id == "XenBulletins/BrandHub")
        {
            Helper::updateAddonOptions();
            Self::updateOwnerPageCount();
        }
    }
    
    
    public static function updateOwnerPageCount()
    {
        $items = \XF::finder('XenBulletins\BrandHub:Item')->with('Brand')->fetch();
       
        $db = \XF::db();
        
        foreach($items as $item)
        {
            $brand = $item->Brand;
//            
//            $db->query('select count(*) as ownerCount from bh_owner_page where item_id = ?', $item->item_id);
//            
            $ownerPages = \XF::finder('XenBulletins\BrandHub:OwnerPage')->where('item_id', $item->item_id);
            $ownerPageCount = $ownerPages->total();
                        
            $item->fastUpdate('owner_count', $ownerPageCount);
            $brand->fastUpdate('owner_count', $brand->owner_count + $ownerPageCount);
        }
    }
    
}
