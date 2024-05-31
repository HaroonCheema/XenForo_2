<?php

namespace FS\GameReviews\Widget;

use XF\Widget\AbstractWidget;

class GameReviews extends AbstractWidget
{
    public function render()
    {
        $finder = $this->finder('FS\GameReviews:GameReviews');

        $finder->order('review_id', 'DESC');

        $page = 1;
        $perPage = 5;

        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'reviews' => $finder->fetch(),
        ];

        return $this->renderer('fs_game_reviews_all_list_widget', $viewParams);
    }

    public function getOptionsTemplate()
    {
        return null;
    }
}
