<?php

namespace FS\QuizSystem\Pub\Controller;

use Laminas\Validator\InArray;
use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;
use XF\Mvc\RouteMatch;

class Question extends AbstractController
{

    // public function actionIndex(ParameterBag $params)
    // {
    //     $page = 0;
    //     $perPage = 0;
    //     $categories = $this->finder('FS\QuizSystem:Category');
    //     $categoryTree = $this->createCategoryTree($categories->fetch());

    //     $finder = $this->finder('FS\QuizSystem:Quiz');

    //     if ($this->filter('search', 'uint')) {
    //         $finder = $this->getSearchFinder($finder);

    //         if (count($finder->getConditions()) == 0) {
    //             return $this->error(\XF::phrase('fs_quiz_please_complete_required_field'));
    //         }
    //     } else if ($params->category_id) {

    //         $finder->where('category_id', $params->category_id);
    //     } else {

    //         $perPage = 15;

    //         $page = $params->page;

    //         $finder->limitByPage($page, $perPage);
    //         $finder->order('quiz_id', 'DESC');
    //     }


    //     $viewParams = [
    //         'categories' => $categories,
    //         'categoryTree' => $categoryTree,

    //         'listings' => $finder->fetch(),


    //         'page' => $page,
    //         'perPage' => $perPage,
    //         'total' => $finder->total(),
    //         'totalReturn' => count($finder->fetch()),

    //         'conditions' => $this->filterSearchConditions(),
    //     ];

    //     return $this->view('FS\QuizSystem:QuizSystem', 'fs_quiz_landing', $viewParams);
    // }

    public function actionNext(ParameterBag $params)
    {
        /** @var \FS\QuizSystem\Entity\Quiz $quizExist */
        $quiz = $this->assertQuizExists($this->filter('id', 'uint'));

        $visitor = \XF::visitor();

        if (!$visitor) {
            return $this->noPermission();
        }

        if (!$quiz) {
            return $this->noPermission();
        }

        if (!in_array($params->question_id, $quiz->question_ids)) {
            return $this->noPermission();
        }

        $question = $this->assertQuestionExists($params->question_id);

        if (!$question) {
            return $this->noPermission();
        }

        $input = $this->filterInputs($question->question_type);

        $insert = $this->em()->create('FS\QuizSystem:QuestionAnswer');

        $insert->question_id = $question->question_id;
        $insert->quiz_id = $quiz->quiz_id;
        $insert->user_id = $visitor->user_id;

        if ($question->question_type == 'radio' || $question->question_type == 'checkbox') {
            $insert->at_index = $input['answer'];
            $insert->answer = $question['options'][$input['answer']];
            $insert->correct = in_array($input['answer'], $question['correct']);
        } else {
            $insert->answer = $input['answer'];
            $insert->correct = strtolower($input['answer']) == strtolower($question['question_correct_answer']);
        }

        $insert->save();

        // if ($question['question_correct_answer'] == 'textbox') {

        //     if (strtolower($input['answer']) == strtolower($question['question_correct_answer'])) {
        //         # code...
        //     }
        // }


        $index = array_search($question->question_id, $quiz->question_ids);

        $lastIndex = count($quiz->question_ids) - 1;

        if ($index == $lastIndex) {
            return $this->message("Quiz Done");
        }

        $nextIndex = $index + 1;

        $question = $this->assertQuestionExists($quiz['question_ids'][$nextIndex]);

        $template = 'fs_quiz_question_answer';

        if ($question->question_type == 'radio' || $question->question_type == 'checkbox') {
            $template = 'fs_quiz_question_radio';
        }

        $viewParams = [
            'quizId' => $quiz->quiz_id,
            'question' => $question,
            'quesNo' => $nextIndex + 1,
            'totalQuestions' => count($quiz->question_ids),
            'finish' => $nextIndex == $lastIndex ? true : false,
        ];

        return $this->view('FS\QuizSystem:Question', $template, $viewParams);
    }

    protected function filterInputs($type)
    {
        $input = null;

        if ($type == 'radio' || $type == 'checkbox') {
            $input = $this->filter([
                'answer' => 'int',
            ]);
        } else {

            $input = $this->filter([
                'answer' => 'str',
            ]);

            if ($input['answer'] == '') {
                throw $this->exception($this->error(\XF::phraseDeferred('please_complete_required_fields')));
            }
        }


        return $input;
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\QuizSystem\Entity\Quiz
     */
    protected function assertQuizExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\QuizSystem:Quiz', $id, $extraWith, $phraseKey);
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\QuizSystem\Entity\Quiz
     */
    protected function assertQuestionExists($id, array $extraWith = [], $phraseKey = null)
    {
        return $this->assertRecordExists('FS\QuizSystem:Question', $id, $extraWith, $phraseKey);
    }
}
