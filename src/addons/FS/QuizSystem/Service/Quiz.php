<?php

namespace FS\QuizSystem\Service;

use XF\Service\AbstractService;

class Quiz extends AbstractService
{
    protected $quiz_id;

    public function __construct(\XF\App $app, $quiz_id)
    {
        parent::__construct($app);
        $this->quiz_id = $quiz_id;
    }

    public function saveQuiz($input = [], $questions = [], $questionsIds = [])
    {
        $repo = $this->getQuizRepo();
        if ($this->quiz_id != null) {
            $edit = $repo->editQuiz($this->quiz_id);
            $edit->quiz_name = $input['quiz_name'];
            $edit->quiz_des = $input['quiz_des'];
            $edit->quiz_state = $input['quiz_state'];
            $edit->quiz_start_date = $this->convertDateTime($input['quiz_start_date'], $input['start_time']);
            $edit->quiz_end_date = $this->convertDateTime($input['quiz_end_date'], $input['end_time']);
            $edit->time_per_question = $input['qsn_time'];
            $edit->user_group = $input['user_groups'];
            $edit->quiz_questions = $questions;
            $edit->question_ids = $questionsIds;
            $edit->category_id = $input['quiz_category'];
            $edit->save();
        } else {
            $add = $repo->addQuiz();
            $add->quiz_name = $input['quiz_name'];
            $add->quiz_des = $input['quiz_des'];
            $add->quiz_state = $input['quiz_state'];
            $add->quiz_start_date = $this->convertDateTime($input['quiz_start_date'], $input['start_time']);
            $add->quiz_end_date = $this->convertDateTime($input['quiz_end_date'], $input['end_time']);
            $add->time_per_question = $input['qsn_time'];
            $add->user_group = $input['user_groups'];
            $add->quiz_questions = $questions;
            $add->question_ids = $questionsIds;
            $add->category_id = $input['quiz_category'];
            $add->save();
        }
        return true;
    }

    protected function convertDateTime($date = null, $time = null)
    {

        $dateTimeFormat = gmdate("YmdHis", strtotime($date . $time));
        $dateTimeStamp = strtotime($dateTimeFormat);
        return $dateTimeStamp;
    }

    /**
     * @return \FS\QuizSystem\Repository\Quiz
     */
    protected function getQuizRepo()
    {
        return $this->repository('FS\QuizSystem:Quiz');
    }
}
