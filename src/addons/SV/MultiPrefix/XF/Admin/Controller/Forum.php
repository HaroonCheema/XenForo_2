<?php

namespace SV\MultiPrefix\XF\Admin\Controller;

use XF\Mvc\FormAction;
use XF\Entity\AbstractNode;
use XF\Entity\Node;
use XF\Mvc\ParameterBag;
use XF\Mvc\Reply\View;

class Forum extends XFCP_Forum
{
    /**
     * @param ParameterBag $params
     * @return View
     */
    public function actionPrefixes(ParameterBag $params)
    {
        $response = parent::actionPrefixes($params);

        if ($response instanceof View)
        {
            if ($forceLimitPrefix = $this->filter('force_limit_prefix', 'uint'))
            {
                $response->setParam('force_limit_prefix', $forceLimitPrefix);
            }
        }

        return $response;
    }

    /**
     * @param FormAction $form
     * @param Node $node
     * @param AbstractNode $data
     */
    protected function saveTypeData(FormAction $form, Node $node, AbstractNode $data)
    {
        /** @var \SV\MultiPrefix\XF\Entity\Forum $data */
        $data->sv_min_prefixes = $this->filter('sv_multiprefix_min_prefixes', 'uint');
        $data->sv_max_prefixes = $this->filter('sv_multiprefix_max_prefixes', 'uint');
        $data->sv_default_prefix_ids = $this->filter('sv_default_prefix_ids', 'array-uint');

        parent::saveTypeData($form, $node, $data);

        if ($data->sv_default_prefix_ids)
        {
            $arr = $data->sv_default_prefix_ids;
            $data->default_prefix_id = \reset($arr);
        }
        else
        {
            $data->default_prefix_id = 0;
        }
    }
}
