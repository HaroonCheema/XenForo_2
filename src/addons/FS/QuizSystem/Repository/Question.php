<?php

namespace FS\QuizSystem\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class Question extends Repository
{
    /**
     * @return Finder
     */
    public function displayQuestions()
    {
        $finder = $this->finder('FS\QuizSystem:Question');
        return $finder;
    }
    public function displaySingleQuestion($id)
    {
        $visitor = \XF::visitor();
        $finder = $this->em->find('FS\QuizSystem:Question', $id);
        return $finder;
    }
    public function addQuestion()
    { 
        $add = $this->em->create('FS\QuizSystem:Question');
        return $add;
    }
    public function editQuestion($id)
    {
        $finder = $this->em->find('FS\QuizSystem:Question', $id);
        return $finder;
    }
}
