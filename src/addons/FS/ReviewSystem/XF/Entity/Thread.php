<?php

namespace FS\ReviewSystem\XF\Entity;

use XF\Mvc\Entity\Structure;
use FS\ReviewSystem\Helper;

class Thread extends XFCP_Thread
{   
    
    protected function _preSave()
    {
        parent::_preSave();
        
        $request = $this->app()->request();
        
        $isReview = $request->filter('is_review', 'uint');
        $nodeId = $this->node_id;
        
        if($isReview && Helper::canPostReview($nodeId))
        {
            $inputFields = $this->getReviewInputFields();

            $requiredFields = ['review_name', 'review_date', 'review_session_length', 'review_fee', 'review_age' ];

            foreach($inputFields as $key => $value)
            {
                if (in_array($key, $requiredFields) && !$value)   // if any required field of review thread is empty then error
                {
//                                    $key = substr($key, 7);
                    $this->error(\XF::phrase('please_enter_value_for_required_field_x', ['field' => $key]), $key, false);
                }
            }

            $this->bulkSet($inputFields);
        }
    }
    
    
    
    
    
    
    
    
//    protected function _postSave()
//    {
//        if($this->is_review && $this->isInsert())
//        {
//            $post = $this->FirstPost;
//            
//            $ros = "[ROS]". $post->message ."[/ROS]";
//
//            $post->fastUpdate('message', $ros);
//        }
//    }
                
    
    
    
    
    protected function getReviewInputFields()
    {
                
         $inputFields =   $this->app()->request()->filter([
                            'is_review'        => 'uint',
                            'review_date'       => 'datetime',
                            'review_name'       => 'str',
                            'review_contact_info'     => 'str',
                            'review_website_url'      => 'str',
                            'review_general_area'     => 'str',
                            'review_activities'       => 'str',
                            'review_session_length'   => 'str',
                            'review_fee'              => 'str',
                            'review_hair_length_and_color'       => 'str',
                            'review_age'                     => 'uint',
                            'review_smoking_status'          => 'str',
                            'review_physical_description'   => 'str',
                            'review_recommendation'         => 'bool'
                        ]);
         
         return $inputFields;
    }
    
    
    

    // public static function getStructure(Structure $structure)
    // {
    //     $structure = parent::getStructure($structure);
                
    //     $structure->columns['is_review'] = ['type' => self::UINT, 'default' => 0];
    //     $structure->columns['review_date'] = ['type' => self::UINT, 'required' => true, 'default' => \XF::$time];
    //     $structure->columns['review_name'] = ['type' => self::STR, 'maxLength' => 50, 'default' => ''];
    //     $structure->columns['review_contact_info'] = ['type' => self::STR, 'default' => ''];
    //     $structure->columns['review_website_url'] = ['type' => self::STR, 'maxLength' => 150, 'default' => ''];
    //     $structure->columns['review_general_area'] = ['type' => self::STR, 'default' => ''];
    //     $structure->columns['review_activities'] = ['type' => self::STR, 'default' => ''];
    //     $structure->columns['review_session_length'] = ['type' => self::STR, 'maxLength' => 255, 'default' => ''];
    //     $structure->columns['review_fee'] = ['type' => self::STR, 'maxLength' => 150, 'default' => ''];
    //     $structure->columns['review_hair_length_and_color'] = ['type' => self::STR, 'default' => ''];
    //     $structure->columns['review_age'] = ['type' => self::UINT, 'default' => 0];
    //     $structure->columns['review_smoking_status'] = ['type' => self::STR, 'default' => '', 'allowedValues' => ['','yes','no'] ];
    //     $structure->columns['review_physical_description'] = ['type' => self::STR, 'default' => ''];
    //     $structure->columns['review_recommendation'] = ['type' => self::BOOL, 'default' => false];

    //     return $structure;
    // }

}
