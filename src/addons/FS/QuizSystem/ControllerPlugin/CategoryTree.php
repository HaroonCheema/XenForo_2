<?php

namespace FS\QuizSystem\ControllerPlugin;

use XF\ControllerPlugin\AbstractCategoryTree;

class CategoryTree extends AbstractCategoryTree
{
    protected $viewFormatter = 'FS\QuizSystem:Category\%s';
    protected $templateFormatter = 'fs_quiz_category_%s';
    protected $routePrefix = 'quiz-categories';
    protected $entityIdentifier = 'FS\QuizSystem:Category';
    protected $primaryKey = 'category_id';
}
