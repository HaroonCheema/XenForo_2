<?php

namespace FS\RMChagneView\XFRM\Repository;

class Category extends XFCP_Category
{
    public function setCategoryImage($category, $upload)
    {
        $upload->requireImage();

        if (!$upload->isValid($errors)) {
            throw new \XF\PrintableException(reset($errors));
        }

        $target = 'data://RmCategoryImage/' . $category->resource_category_id . '.jpg';

        try {
            $image = \XF::app()->imageManager->imageFromFile($upload->getTempFile());

            $tempFile = \XF\Util\File::getTempFile();
            if ($tempFile && $image->save($tempFile)) {
                $output = $tempFile;
            }
            unset($image);

            \XF\Util\File::copyFileToAbstractedPath($output, $target);
        } catch (Exception $e) {
            throw new \XF\PrintableException(\XF::phrase('unexpected_error_occurred'));
        }
    }
}
