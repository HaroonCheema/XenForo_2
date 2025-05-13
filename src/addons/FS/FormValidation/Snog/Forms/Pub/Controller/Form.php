<?php

namespace FS\FormValidation\Snog\Forms\Pub\Controller;
use XF\Mvc\ParameterBag;
use XF\Util\Arr;
use Snog\Forms\Entity\Form as FormEntity;
use Snog\Forms\Entity\Question;

class Form extends XFCP_Form
{

    public function actionSubmit(ParameterBag $params)
    {
            $answers = $this->filter(['question' => 'array']);
            
        //------ phone number validation ---------------
            
            $phNoFieldIds = $this->options()->fs_phoneNumberFieldId;
            $phNoFieldIds = explode(',', $phNoFieldIds);    
            
            foreach($phNoFieldIds as $phNoFieldId)
            {
                if(isset($answers['question'][$phNoFieldId]))
                {
                    $phoneNumber = $answers['question'][$phNoFieldId];

                    if(preg_match("/[a-z]/i", $phoneNumber))
                    {
                        throw $this->exception($this->error(\XF::phrase('fs_please_enter_a_valid_phone_number')));
                    }
                }
            }
            
            
            
    //----------------assert url in banned list (url validation)----------------
            
            
            $urlFieldIds = $this->options()->fs_urlFieldId;
            $urlFieldIds = explode(',', $urlFieldIds); 
            
            foreach ($urlFieldIds as $urlFieldId)
            {
                if(isset($answers['question'][$urlFieldId]))
                {
                    $url = $answers['question'][$urlFieldId];

                    $bannedList = $this->options()->fs_bannedList;
                    $bannedListUrls = Arr::stringToArray($bannedList, '/\r?\n/');

                    if(in_array($url, $bannedListUrls))
                    {
                        throw $this->exception($this->error(\XF::phrase('fs_banned_url')));
                    }
                }
            }
            
 
               
                
            return parent::actionSubmit($params);  
    }
    
    
    protected function processAnswer(
		$reportMessages,
		FormEntity $form,
		Question $question,
		$answer,
		$isFirstQuestion,
		&$unansweredCount,
		&$titleAnswers,
		&$storeAnswers
	)
    {
        
        $phNoFieldIds = $this->options()->fs_phoneNumberFieldId;
        $phNoFieldIds = explode(',', $phNoFieldIds);
       
        if(in_array($question->questionid, $phNoFieldIds))   //check if the question is phoneNumber (phone number field)
        {
                if(isset($answer))
                {
                    $phoneNumber = $answer;

                    if(strpos($phoneNumber, '+') === 0)
                    {   
                        $countryCode = '+39';
                        $phoneNumber = str_replace($countryCode, '',$phoneNumber);  // Removes only +39 country code.
                    }

                    $answer = preg_replace('/[^0-9+]/', '', $phoneNumber); // Removes all non-numeric characters.
                    
                }
        }
        
        return parent::processAnswer($reportMessages, $form, $question, $answer, $isFirstQuestion, $unansweredCount, $titleAnswers, $storeAnswers);
        
    }
        
}
