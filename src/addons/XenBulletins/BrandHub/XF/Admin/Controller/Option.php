<?php

namespace XenBulletins\BrandHub\XF\Admin\Controller;

class Option extends XFCP_Option 
{
    
        public function actionUpdate()
        {
            
            $this->assertPostOnly();

            $input = $this->filter([
                    'options_listed' => 'array-str',
                    'options' => 'array'
            ]);
            
            
            
         

            $options = $input['options'];
            

            if(array_key_exists('bh_main_route_id', $options))
            {
                
//                $res = \xf::db()->query("select route_id, route_prefix from xf_route where addon_id = 'XenBulletins/BrandHub' and route_type = 'public'")->fetchAll();
//                
//                echo '<pre>',
//                var_dump($res);exit;
                
                $optionMainRoute = $options["bh_main_route"];
                $mainRouteId = $options["bh_main_route_id"];
                
                
                if(!empty($optionMainRoute) && !empty($mainRouteId))
                {
                    
                    $mainRoute = $this->em()->findOne('XF:Route', ['route_id' => $mainRouteId, 'addon_id' => 'XenBulletins/BrandHub', 'route_type' => 'public']);

                    if(!$mainRoute)
                    {
                        throw $this->exception($this->error(\XF::phrase('bh_route_not_found_by_this_route_id')));
                    }

                    
                    if($mainRoute->route_prefix != $optionMainRoute)
                    {
                        $route = $this->em()->findOne('XF:Route', ['route_prefix' => $optionMainRoute,'route_type' => 'public']);
                        if($route)
                        {
                            throw $this->exception($this->error(\XF::phrase('bh_route_already_exist_please_enter_different_route')));
                        }
                        
                        $oldRoutePrefix = $mainRoute->route_prefix;

                        $mainRoute->route_prefix = $optionMainRoute;
                        $mainRoute->save();
                        
                        \xf::db()->query("UPDATE xf_route SET route_prefix = '$optionMainRoute' where route_prefix = '$oldRoutePrefix' and sub_name = 'item' and route_type = 'public'");
                      
                    }
                }
                else
                {
                    throw $this->exception($this->error(\XF::phrase('bh_main_route_options_can_not_be_empty')));
                }
            }

            return parent::actionUpdate();

        }
    
}