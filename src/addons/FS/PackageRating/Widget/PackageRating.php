<?php

namespace FS\PackageRating\Widget;

use XF\Widget\AbstractWidget;

class PackageRating extends AbstractWidget
{
    public function render()
    {
        $finder = $this->finder('FS\PackageRating:PackageRating');

        $finder->order('rating_id', 'DESC');

        $page = 1;
        $perPage = 5;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'reviews' => $finder->fetch(),
        ];

        return $this->renderer('fs_rating_reviews_all_list_widget', $viewParams);
    }

    public function getOptionsTemplate()
    {
        return null;
    }
}
