<?php

namespace FS\RMChagneView\XFRM\Entity;

use XF\Mvc\Entity\Structure;

class Category extends XFCP_Category
{
    protected function _postSave()
    {
        if ($upload = \xf::app()->request->getFile('upload', false, false)) {
            \xf::app()->repository('XFRM:Category')->setCategoryImage($this, $upload);
        }
    }

    public function getCatImage()
    {
        $image = 'data://RmCategoryImage/' . $this->resource_category_id . '.jpg';

        if (\XF\Util\File::abstractedPathExists($image)) {
            return $this->app()->applyExternalDataUrl('RmCategoryImage/' . $this->resource_category_id . '.jpg?' . time(), true);
        }

        return;
    }

    protected function _postDelete()
    {
        $parent = parent::_postDelete();

        \XF\Util\File::deleteFromAbstractedPath('data://RmCategoryImage/' . $this->resource_category_id . '.jpg');

        return $parent;
    }
}
