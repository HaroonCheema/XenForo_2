<?php

namespace FS\QuizSystem\Admin\Controller;

use XF\Admin\Controller\AbstractController;
use XF\Mvc\ParameterBag;
use XF\Option\Forum;

class Category extends AbstractController
{
    protected function preDispatchController($action, ParameterBag $params)
    {
//        $this->assertAdminPermission('xc_market_category');
    }

    protected function getCategoryTreePlugin()
    {
        return $this->plugin('FS\QuizSystem:CategoryTree');
    }

    public function actionIndex()
    {
       
        return $this->getCategoryTreePlugin()->actionList([
            'permissionContentType' => 'fs_quiz_category'
        ]);
    }

    public function actionEdit(ParameterBag $params)
    {
        $category = $this->assertCategoryExists($params->category_id);
        return $this->categoryAddEdit($category);
    }

    public function actionAdd()
    {
        $parentCategoryId = $this->filter('parent_category_id', 'uint');

        $category = $this->em()->create('FS\QuizSystem:Category');
        $category->parent_category_id = $parentCategoryId;

        return $this->categoryAddEdit($category);
    }

    protected function categoryAddEdit(\FS\QuizSystem\Entity\Category $category)
    {
        $categoryRepo = $this->getCategoryRepo();

        $categoryTree = $categoryRepo->createCategoryTree();

        $viewParams = [
            'category' => $category,
            'categoryTree' => $categoryTree,
        ];
        return $this->view('FS\QuizSystem:Category\Edit', 'fs_edit_quiz_category', $viewParams);
    }

    protected function categorySaveProcess(\FS\QuizSystem\Entity\Category $category)
    {
        $form = $this->formAction();

        $input = $this->filter([
            'title' => 'str',
            'description' => 'str',
            'parent_category_id' => 'uint',
            'display_order' => 'uint',
        ]);
        


        $form->basicEntitySave($category, $input);

        return $form;
    }

    public function actionSave(ParameterBag $params)
    {
        if ($params->category_id) {
            $category = $this->assertCategoryExists($params->category_id);
        } else {
            $category = $this->em()->create('FS\QuizSystem:Category');
        }

        $this->categorySaveProcess($category)->run();

        return $this->redirect($this->buildLink('quiz-categories') . $this->buildLinkHash($category->category_id));
    }

    public function actionDelete(ParameterBag $params)
    {
        return $this->getCategoryTreePlugin()->actionDelete($params);
    }

    public function actionSort()
    {
        return $this->getCategoryTreePlugin()->actionSort();
    }

    /**
     * @param string $id
     * @param array|string|null $with
     * @param null|string $phraseKey
     *
     * @return \FS\QuizSystem\Entity\Category
     */
    protected function assertCategoryExists($id, $with = null, $phraseKey = null)
    {
        return $this->assertRecordExists('FS\QuizSystem:Category', $id, $with, $phraseKey);
    }

    /**
     * @return \FS\QuizSystem\Repository\Category
     */
    protected function getCategoryRepo()
    {
        return $this->repository('FS\QuizSystem:Category');
    }
}
