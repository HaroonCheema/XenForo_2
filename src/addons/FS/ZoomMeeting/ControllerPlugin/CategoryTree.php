<?php

namespace FS\ZoomMeeting\ControllerPlugin;

use XF\ControllerPlugin\AbstractCategoryTree;

class CategoryTree extends AbstractCategoryTree
{
    protected $viewFormatter = 'FS\ZoomMeeting:Category\%s';
    protected $templateFormatter = 'zoom_category_%s';
    protected $routePrefix = 'zoom-categories';
    protected $entityIdentifier = 'FS\ZoomMeeting:Category';
    protected $primaryKey = 'category_id';
}
