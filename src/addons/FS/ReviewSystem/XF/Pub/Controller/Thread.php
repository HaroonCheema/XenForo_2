<?php

namespace FS\ReviewSystem\XF\Pub\Controller;

use XF\Mvc\ParameterBag;
use FS\ForumSuggestion\Helper;

class Thread extends XFCP_Thread
{
    
    public function actionIndex(ParameterBag $params)
    {
            $parent = parent::actionIndex($params);

            $visitor = \XF::visitor();
            $thread = $parent->getParam('thread');

            if($parent instanceof \XF\Mvc\Reply\View && $thread->is_review)
            {
                $post = $thread->FirstPost;


                $formatedReview = $this->formateReviewMessage($thread);

                $rosContent = $post->message;

                if(!$visitor->canViewRosContent())
                {
                    $rosContent = "[ROS]" . $post->message . "[/ROS]";  // wrape message with ROS BBCode
                }



                $post->message = $formatedReview . "[Br]1[/Br]". $rosContent;
            }

            return $parent;
    }
    
    
    
    
    protected function formateReviewMessage(\XF\Entity\Thread $thread) 
    {
        $reviewFieldNames = $this->getReviewFieldsName();
        
        $message = '';
        
        foreach ($reviewFieldNames as $reviewFieldName)
        {
            $fieldValue = $thread->$reviewFieldName;
            
            $value = $this->processFarmateReview($reviewFieldName, $fieldValue);
            
            $message .= "[B]" . \XF::phrase($reviewFieldName) . "[/B]: " . $value . "[Br]1[/Br]";
        }
        
        return $message;
    }
    
    
    protected function getReviewFieldsName()
    {
        return ['review_date','review_name',
                'review_contact_info','review_website_url','review_general_area',
                'review_activities','review_session_length','review_fee',
                'review_hair_length_and_color','review_age','review_smoking_status',
                'review_physical_description','review_recommendation'
                ];
    }
    
    
    protected function processFarmateReview($reviewFieldName, $fieldValue)
    {
            switch ($reviewFieldName)
            {   
                    case 'review_date':
                            $value = date('m/d/Y', $fieldValue);
                            break;
                    case 'review_website_url':
                            $value = $fieldValue?: \XF::phrase('none');
                            break;
                    case 'review_smoking_status':
                            $value = \XF::phrase( $fieldValue ?: 'i_could_not_tell');
                             break;
                    case 'review_recommendation':
                            $value = \XF::phrase( $fieldValue ? 'yes': 'no');
                            break;
                    default :
                            $value = $fieldValue ?: \XF::phrase('none');
            }
            
            return $value;
    }
    
}