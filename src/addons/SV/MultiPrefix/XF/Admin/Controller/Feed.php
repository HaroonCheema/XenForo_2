<?php

namespace SV\MultiPrefix\XF\Admin\Controller;



/**
 * Extends \XF\Admin\Controller\Feed
 */
class Feed extends XFCP_Feed
{
    protected function getFeedInput()
    {
        $input = parent::getFeedInput();

        $prefixIds = $this->filter('prefix_id', '?array-uint');
        if ($prefixIds !== null)
        {
            $input['sv_prefix_ids'] = $prefixIds;
            $input['prefix_id'] = \reset($input['sv_prefix_ids']);
        }
        else
        {
            $input['sv_prefix_ids'] = [$input['prefix_id']];
        }

        return $input;
    }
}