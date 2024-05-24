<?php

namespace FS\QuizSystem\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Quiz extends Repository
{
    /**
     * @return Finder
     */
    public function displayAllQuiz()
    {
        $finder = $this->finder('FS\QuizSystem:Quiz');

        $finder->order('quiz_id', 'DESC');

        return $finder;
    }
    public function displaySingleQuiz($id)
    {
        $finder = $this->em->find('FS\QuizSystem:Quiz', $id);
        return $finder;
    }
    public function addQuiz()
    {
        $add = $this->em->create('FS\QuizSystem:Quiz');
        return $add;
    }
    public function editQuiz($id)
    {
        $finder = $this->em->find('FS\QuizSystem:Quiz', $id);
        return $finder;
    }
}
