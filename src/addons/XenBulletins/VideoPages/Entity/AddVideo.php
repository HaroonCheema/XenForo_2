<?php

namespace XenBulletins\VideoPages\Entity;
use XF\Mvc\Entity\Structure;
use XF\Mvc\Entity\Entity;
//Entity 
class AddVideo extends Entity{
    public static function getStructure(Structure $structure){
        $structure->table = 'xf_videopages';
        $structure->shortName = 'XenBulletins\VideoPages:AddVideo';
        $structure->primaryKey = 'video_id';
        $structure->columns = [
            'video_id'      => ['type' => self::UINT, 'autoIncrement'=>true],
            'video_link'    => ['type' => self::STR, 'maxlenght' => 255, 'required' => true],
            'video_feature' => ['type' => self::STR, 'maxlength' => 255, 'required' => true],
            'thumbnail' => ['type' => self::STR, 'maxlength' => 255,'default'=>''],
            'video_logo'    => ['type' => self::STR, 'default' => ''],
            'video_intro'   => ['type' => self::STR, 'maxlength' => 255, 'required' => true],
            'video_desc'    => ['type' => self::STR, 'maxlength' => 255, 'required' => true],
            'video_sideimg' => ['type' => self::STR, 'default' => ''],
            'video_img'     => ['type' => self::STR, 'default' => ''],
            'intro_ph_id'=>['type'=>self::UINT,'default'=>0],
            'desc_ph_id'=>['type'=> self::UINT,'default'=>0],
            'feature_embed' => ['type'=>self::STR ]
            
        ];
        return $structure;
    }
    
    
     public function getAbstractedCustomBrandImgPath($upload,$type) 
    {
               if($type == 'video_logo'){
            $fn = 'video_logo';
        }
        else if($type == 'video_sideimg'){
            $fn = 'video_sideimg';
        }
        else{
            $fn = 'video_img';
        }
         
        $VideoId = $this->video_id;
        return sprintf('data://brand_img/'.$fn.'/%d/%d.jpg', floor($VideoId / 1000), $VideoId);
    }

    public function getDepositImgUrl($canonical = true,$type)
    {
       
        if($type == 'video_logo'){
            $fn = 'video_logo';
        }
        else if($type == 'video_sideimg'){
            $fn = 'video_sideimg';
        }
        else{
            $fn = 'video_img';
        }
        $VideoId = $this->video_id;
        $path = sprintf('brand_img/'.$fn.'/%d/%d.jpg', floor($VideoId / 1000), $VideoId);
        return \XF::app()->applyExternalDataUrl($path, $canonical);
    }
}


