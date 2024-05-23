<?php

namespace FS\QuizSystem\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;

class Question extends AbstractController
{
    public function actionIndex()
    {
        $repo = $this->getQuestionRepo();
        $question = $repo->displayQuestions()->fetch();
        $viewParams = [
            'question' => $question,
        ];
        return $this->view('FS\QuizSystem:Question', 'fs_questions_list', $viewParams);
    }

    public function actionAddEdit(ParameterBag $params)
    {   
        if ($params->question_id) {
            $questionRepo = $this->getQuestionRepo();
            $question = $questionRepo->displaySingleQuestion($params->question_id);
            $viewParams = [
                'question' => $question
            ];
        }
        else{
            $viewParams = [
                'question' => null,
            ];
        }
        return $this->view('FS\QuizSystem:Question', 'fs_quiz_edit_questions', $viewParams);
    }


    public function actionSave(ParameterBag $params)
    {   
        if ($params->question_id != null) {
            $id = $params->question_id;
            if (!$this->assertQuestionExists($id)) {
                $this->message(\XF::phrase('error_message'));
            }
        }
        else
        {
            $id = null;
        }
        
        $title =  $this->filter('question_title', 'str');
        $type =  $this->filter('question_type', 'str');

        $service = $this->getService($id); 
        if ($type == 'textbox') 
        {
            $answer =  $this->filter('question_correct_answer', 'str');
            $service->addTextQuestion($title, $type, $answer);
            return $this->redirect($this->buildLink('quiz-qsn'));
        }  
        else
        {   
            if ($type == 'radio')
            {   
                $radio = $this->filter('options-radio', 'array');
                $correct_radio = $this->filter('correct-radio', 'array');
                if (empty($correct_radio)) {
                    return $this->message(\XF::phrase('none_selected'));
                }
                $service->addRadioQuestion($title, $type, $radio, $correct_radio);
            }elseif($type == 'checkbox')
            {
                $checkbox = $this->filter('options-checkbox', 'array');
                $correct_check = $this->filter('correct-checkbox', 'array');
                if (empty($correct_check)) 
                {
                    return $this->message(\XF::phrase('none_selected'));
                }
                $service->addCheckQuestion($title, $type, $checkbox, $correct_check);
            }else
            {
                return $this->message(\XF::phrase('unsupported_type'));
            }
            return $this->redirect($this->buildLink('quiz-qsn'));
        }
    }

    public function actionDelete(ParameterBag $params)
    {
        $id = $params->question_id;

        if ($id != null) 
        {
            $repo = $this->getQuestionRepo();
            if (!$this->assertQuestionExists($id)) 
            {
                $this->message(\XF::phrase('error_message'));
            }
            $delete = $repo->displaySingleQuestion($id);
            $delete->delete();
        } else 
        {
            $this->error(\XF::phrase('error_message'));
        }
        return $this->redirectPermanently($this->buildLink('quiz-qsn'));
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\QuizSystem\Entity\Question
     */
    protected function assertQuestionExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('FS\QuizSystem:Question', $id, $with, $phraseKey);
    }

    /**
     * @return \FS\QuizSystem\Repository\Question
     */
    protected function getQuestionRepo()
    {
        return $this->repository('FS\QuizSystem:Question');
    }

    public function actionConfirm(ParameterBag $params)
    {
        $id = $params->question_id;

        $repo = $this->getQuestionRepo();


        $send = $repo->displaySingleQuestion($id);

        $viewParams = [
            'question' => $send
        ];
        return $this->view('FS\QuizSystem:View', 'fs_delete_qsn', $viewParams);
    }

     /**
     * @return \FS\QuizSystem\Service\Question
     */
    protected function getService($id)
    {
        return \XF::app()->service('FS\QuizSystem:Question', $id);
    }
    

}
