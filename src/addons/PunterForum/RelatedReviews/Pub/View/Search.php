<?php

namespace PunterForum\RelatedReviews\Pub\View;

class Search extends \XF\Mvc\View
{
    public function renderJson()
    {
        return $this->params;
    }
}