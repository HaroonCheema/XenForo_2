<?php

namespace XenBulletins\VideoPages\Entity;

use XF\Mvc\Entity\Structure;
use XF\Mvc\Entity\Entity;

class Brand extends Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_videopages';
        $structure->shortName = 'XenBulletins\VideoPages:Brand';
        $structure->primaryKey = 'video_id ';
        $structure->columns = [
                'video_id ' => ['type' => self::UINT,'autoIncrement' => true],
                'video_link' => ['type' => self::STR, 'maxLength' => 255, 'required' => true],
                'video_feature' => ['type' => self::STR, 'maxLength' => 255, 'required' => true],
                'video_logo' => ['type' => self::STR, 'maxLength' => 255, 'required' => true],
                'video_intro' =>  ['type' => self::STR, 'maxLength' => 255, 'required' => true],
                'video_desc' =>  ['type' => self::STR, 'maxLength' => 255, 'required' => true],
                'video_sideimg' =>  ['type' => self::STR, 'maxLength' => 255, 'required' => true],
                'video_img' =>  ['type' => self::STR, 'maxLength' => 255, 'required' => true]
               
             ];

        return $structure;
    }

    public function getAbstractedCustomBrandImgPath($type) 
    {
        if($type == 'video_logo')
        {
           $fn = 'video_logo';
           
        }else if($type == 'video_sideimg')
        {
            $fn = 'video_sideimg';
            
        }else {
            $fn = 'video_img';
        }
        $VideoId = $this->video_id;
        return sprintf('data://brand_img/'.$fn.'/%d/%d.jpg', floor($VideoId / 1000), $VideoId);
    }
    

    public function getBrandImgUrl($canonical = true)
    {
        if($type == 'video_logo')
        {
            $fn = 'video_logo';
        }
        else if($type == 'video_sideimg')
        {
            $fn = 'video_sideimg';
        }
        else{
            $fn = 'video_img';
        }
        $VideoId = $this->video_id;
        $path = sprintf('brand_img/%d/%d.jpg', floor($VideoId / 1000), $VideoId);
        return \XF::app()->applyExternalDataUrl($path, $canonical);
    }
}