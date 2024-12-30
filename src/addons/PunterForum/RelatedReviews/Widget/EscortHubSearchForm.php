<?php

namespace PunterForum\RelatedReviews\Widget;

use XF\Widget\AbstractWidget;
use XF\Widget\WidgetRenderer;

class EscortHubSearchForm extends AbstractWidget
{

    public function getOptionsTemplate(): string
    {
        return '';
    }


    /**
     * @return WidgetRenderer
     */
    public function render(): WidgetRenderer
    {
        return $this->renderer('widget_escorthub_search_form');
    }
}