<?php

namespace FS\QuizSystem\Service;

use XF\Service\AbstractService;

class Question extends AbstractService
{
    protected $question_id;

    public function __construct(\XF\App $app, $question_id)
    {
        parent::__construct($app);
        $this->question_id = $question_id;
    }

    public function addTextQuestion($title, $type, $answer)
    {
        $repo = $this->getQuestionRepo();
        if ($this->question_id) 
        {
            $edit = $repo->editQuestion($this->question_id);
            $edit->question_title = $title;
            $edit->question_type = $type;
            $edit->question_correct_answer = $answer;
            $edit->options = [];
            $edit->correct = [];
            $edit->save();
        }else
        {
            $add = $repo->addQuestion();
            $add->question_title = $title;
            $add->question_type = $type;
            $add->question_correct_answer = $answer;
            $add->options = [];
            $add->correct = [];
            $add->save();
        }
        return true;
    }
    public function addRadioQuestion($title, $type, $radio, $correct)
    {
        $repo = $this->getQuestionRepo();
        if ($this->question_id) 
        {
            $edit = $repo->editQuestion($this->question_id);
            $edit->question_title = $title;
            $edit->question_type = $type;
            $edit->question_correct_answer = '';
            $edit->options = $radio;
            $edit->correct = $correct;
            $edit->save();
        }else
        {
            $add = $repo->addQuestion();
            $add->question_title = $title;
            $add->question_type = $type;
            $add->question_correct_answer = '';
            $add->options = $radio;
            $add->correct = $correct;
            $add->save();
        }
        return true;
        
    }
    public function addCheckQuestion($title, $type, $checkbox, $correct)
    {
        $repo = $this->getQuestionRepo();
        if ($this->question_id) 
        {
            $edit = $repo->editQuestion($this->question_id);
            $edit->question_title = $title;
            $edit->question_type = $type;
            $edit->question_correct_answer = '';
            $edit->options = $checkbox;
            $edit->correct = $correct;
            $edit->save();
        }else
        {
            $add = $repo->addQuestion();
            $add->question_title = $title;
            $add->question_type = $type;
            $add->question_correct_answer = '';
            $add->options = $checkbox;
            $add->correct = $correct;
            $add->save();
        }
        return true;   
    }
    /**
     * @return \FS\QuizSystem\Repository\Question
     */
    protected function getQuestionRepo()
    {
        return $this->repository('FS\QuizSystem:Question');
    }
}
