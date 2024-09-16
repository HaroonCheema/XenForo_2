<?php

namespace SV\MultiPrefix\XF\InlineMod\Post;

use XF\Http\Request;
use XF\Mvc\Entity\AbstractCollection;

class Copy extends XFCP_Copy
{
    /**
     * @param AbstractCollection $entities
     * @param Request $request
     *
     * @return array
     */
    public function getFormOptions(AbstractCollection $entities, Request $request)
    {
        $options = parent::getFormOptions($entities, $request);

        $options['prefix_id'] = $request->filter('prefix_id', 'array-uint');

        return $options;
    }
}