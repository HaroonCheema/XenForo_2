<?php

namespace FS\RMChagneView\XFRM\Admin\Controller;

use XF\Mvc\ParameterBag;

class Category extends XFCP_Category
{
    public function actionDeleteImage(ParameterBag $params)
    {
        if ($params->resource_category_id) {
            $category = $this->assertCategoryExists($params->resource_category_id);
        }

        if (!$category) {
            return $this->noPermission();
        }

        if (!$category->getCatImage()) {
            return $this->error(\XF::phrase('no_icon_to_delete'));
        }

        if ($this->isPost()) {
            \XF\Util\File::deleteFromAbstractedPath('data://RmCategoryImage/' . $category->resource_category_id . '.jpg');

            return $this->redirect($this->buildLink('resource-manager/categories/edit', $category));
        }

        $viewParams = [
            'category' => $category
        ];

        return $this->view('FS\RMChagneView:DeleteImage', 'fs_rm_cat_delete_image', $viewParams);
    }
}
