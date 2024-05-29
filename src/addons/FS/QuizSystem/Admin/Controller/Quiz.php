<?php

namespace FS\QuizSystem\Admin\Controller;

use FS\QuizSystem\Entity\Question;
use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;


class Quiz extends AbstractController
{
    public function actionIndex()
    {
        $repo = $this->getQuizRepo();
        $quiz = $repo->displayAllQuiz()->fetch();
        $viewParams = [
            'quiz' => $quiz,
        ];

        return $this->view('FS\QuizSystem:Question', 'fs_quiz_list', $viewParams);
    }

    public function actionAddEdit(ParameterBag $params)
    {
        /** @var \XF\Entity\UserGroup $userGroup */
        $userGroup = $this->finder('XF:UserGroup')->fetch();

        /** @var \FS\QuizSystem\Entity\Category $category */
        $category = $this->finder('FS\QuizSystem:Category')->fetch();

        $to = $this->filter('to', 'str');


        /** @var \FS\QuizSystem\Repository\Question $repo */
        $repo = $this->repository('FS\QuizSystem:Question');
        $allQsn = $repo->displayQuestions();
        $finder =  $this->finder('FS\QuizSystem:Question');

        if ($params->quiz_id) {
            $quizRepo = $this->getQuizRepo();
            $quiz = $quizRepo->displaySingleQuiz($params->quiz_id);
            $startDate = gmdate("Y-m-d", $quiz->quiz_start_date);
            $startTime = date("H:i", $quiz->quiz_start_date);
            $endDate = gmdate("Y-m-d", $quiz->quiz_end_date);
            $endTime = date("H:i", $quiz->quiz_end_date);
            $pre_qsn = [];
            for ($i = 0; $i < sizeof($quiz->quiz_questions); $i++) {
                $title = $quiz->quiz_questions[$i];
                $qsn = $this->em()->findOne('FS\QuizSystem:Question', ['question_title' => $title]);
                array_push($pre_qsn, $qsn->question_title);
            }
            $viewParams = [
                'categories' => $category,
                'quiz' => $quiz,
                'st_date' => $startDate,
                'st_time' => $startTime,
                'end_time' => $endTime,
                'end_date' => $endDate,
                'userGroups' => $userGroup,
                'question' => $allQsn->fetch(),
                'to' => $to,
                'pre_qsn' => implode(', ', $pre_qsn),
            ];
        } else {
            $viewParams = [
                'categories' => $category,
                'userGroups' => $userGroup,
                'question' => $allQsn->fetch(),
                'to' => $to,
            ];
        }
        return $this->view('FS\QuizSystem:Quiz', 'fs_quiz_edit', $viewParams);
    }



    public function actionSave(ParameterBag $params)
    {
        if ($params->quiz_id) {
            $id = $params->quiz_id;
            $existQuiz = $this->assertQuizExists($id);

            if (!$existQuiz) {
                $this->message(\XF::phrase('error_message'));
            }
        } else {
            $id = null;
        }
        $service = $this->getService($id);

        $input = $this->filter([
            'quiz_name' => 'str',
            'quiz_des' => 'str',
            'quiz_state' => 'str',
            'start_time' => 'str',
            'end_time' => 'str',
            'quiz_start_date' => 'str',
            'quiz_end_date' => 'str',
            'qsn_time' => 'uint',
            'user_groups' => 'array',
            'quiz_questions' => 'str',
            'quiz_category' => 'uint'
        ]);
        $quiz_qsn = $input['quiz_questions'];
        $questions = [];
        $questionsIds = [];
        $finder = $this->finder('FS\QuizSystem:Question');
        $elements = [];
        $elements = explode(', ', $quiz_qsn);
        for ($i = 0; $i < sizeof($elements); $i++) {
            $qsn = $this->em()->findOne('FS\QuizSystem:Question', ['question_title' => $elements[$i]]);
            if ($qsn != null) {
                array_push($questions, $qsn->question_title);
                array_push($questionsIds, $qsn->question_id);
            } else {
                return $this->message($elements[$i] . " Not Found, Add Valid Question");
            }
        }
        if (!empty($input['quiz_name'])) {
            $finder = $this->finder('FS\QuizSystem:Quiz');
            $quiz = $finder
                ->where('quiz_name', 'like', $finder->escapeLike($input['quiz_name']))
                ->fetch();
            if (count($quiz) != 0 && $id == null) {
                return $this->message(\XF::phrase('fs_already_exists'));
            }
        }
        $start_date = $this->convertDateTime($input['quiz_start_date'], $input['start_time']);
        $end_date = $this->convertDateTime($input['quiz_end_date'], $input['end_time']);
        if ($start_date >= $end_date) {
            return $this->message(\XF::phrase('date_error'));
        }
        $total_qsn_time = $input['qsn_time'] * count($questions);
        $total_quiz_time = $end_date - $start_date;
        if ($total_qsn_time > $total_quiz_time) {
            return $this->message(\XF::phrase('fs_time_error'));
        }
        if ($start_date <= time()) {
            return $this->message(\XF::phrase('fs_date_expired'));
        }

        if (!$params->quiz_id) {

            \XF::db()->query('update fs_quiz_category set quiz_count = quiz_count + 1 where category_id =' . $input['quiz_category']);
        } elseif ($existQuiz && $existQuiz['category_id'] != $input['quiz_category']) {

            \XF::db()->query('update fs_quiz_category set quiz_count = quiz_count - 1 where category_id =' . $existQuiz['category_id']);
            \XF::db()->query('update fs_quiz_category set quiz_count = quiz_count + 1 where category_id =' . $input['quiz_category']);
        }

        $service->saveQuiz($input, $questions, $questionsIds);

        return $this->redirect($this->buildLink('quiz'));
    }

    public function actionDelete(ParameterBag $params)
    {
        $id = $params->quiz_id;

        if ($id != null) {
            $repo = $this->getQuizRepo();
            if (!$this->assertQuizExists($id)) {
                $this->message(\XF::phrase('error_message'));
            }
            $delete = $repo->displaySingleQuiz($id);

            \XF::db()->query('update fs_quiz_category set quiz_count = quiz_count - 1 where category_id =' . $delete['category_id']);

            $delete->delete();
        } else {
            $this->error(\XF::phrase('error_message'));
        }
        return $this->redirectPermanently($this->buildLink('quiz'));
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\QuizSystem\Entity\Quiz
     */
    protected function assertQuizExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('FS\QuizSystem:Quiz', $id, $with, $phraseKey);
    }

    /**
     * @return \FS\QuizSystem\Repository\Quiz
     */
    protected function getQuizRepo()
    {
        return $this->repository('FS\QuizSystem:Quiz');
    }

    public function actionConfirm(ParameterBag $params)
    {
        $id = $params->quiz_id;

        $repo = $this->getQuizRepo();


        $send = $repo->displaySingleQuiz($id);

        $viewParams = [
            'quiz' => $send
        ];
        return $this->view('FS\QuizSystem:View', 'fs_delete_quiz', $viewParams);
    }

    /**
     * @return \FS\QuizSystem\Service\Quiz
     */
    protected function getService($id)
    {
        return \XF::app()->service('FS\QuizSystem:Quiz', $id);
    }

    public function actionFind()
    {
        $q = $this->filter('q', 'str', ['no-trim']);
        // var_dump($q);exit;

        if ($q !== '' && utf8_strlen($q) >= 2) {
            /** @var \FS\QuizSystem\Finder\Question $questions */
            $questions = $this->finder('FS\QuizSystem:Question');

            $allQuestions = $questions
                ->where('question_title', 'like', $questions->escapeLike($q, '?%'))
                ->fetch();
        } else {
            $allQuestions = [];
            $q = '';
        }
        // var_dump($users);exit;
        $viewParams = [
            'q' => $q,
            'questions' => $allQuestions,
        ];
        return $this->view('FS\QuizSystem:Quiz\Find', '', $viewParams);
    }

    protected function convertDateTime($date = null, $time = null)
    {

        $dateTimeFormat = gmdate("YmdHis", strtotime($date . $time));
        $dateTimeStamp = strtotime($dateTimeFormat);
        return $dateTimeStamp;
    }
}
