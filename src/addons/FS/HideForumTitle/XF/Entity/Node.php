<?php

namespace FS\HideForumTitle\XF\Entity;

class Node extends XFCP_Node
{
    public function getBreadcrumbs($includeSelf = true, $linkType = 'public')
    {
        /** @var \XF\Mvc\Router $router */
        $router = $this->app()->container('router.' . $linkType);
        $nodeTypes = $this->app()->container('nodeTypes');

        $output = [];
        if ($this->breadcrumb_data) {
            foreach ($this->breadcrumb_data as $crumb) {
                if (!isset($nodeTypes[$crumb['node_type_id']])) {
                    continue;
                }

                $nodeType = $nodeTypes[$crumb['node_type_id']];
                $route = $linkType == 'public' ? $nodeType['public_route'] : $nodeType['admin_route'];

                $output[] = [
                    'value' => preg_replace('/^\[[^\]]+\]\s*/', '', $crumb['title']),
                    // 'value' => $crumb['title'],
                    'href' => $router->buildLink($route, $crumb),
                    'node_id' => $crumb['node_id']
                ];
            }
        }

        $nodeType = $this->node_type_info;

        if ($includeSelf && $nodeType) {
            $route = $linkType == 'public' ? $nodeType['public_route'] : $nodeType['admin_route'];

            $output[] = [
                'value' => preg_replace('/^\[[^\]]+\]\s*/', '', $this->title),
                // 'value' => $this->title,
                'href' => $router->buildLink($route, $this),
                'node_id' => $this->node_id
            ];
        }

        return $output;
    }

    public function getNodeTitle()
    {
        return preg_replace('/^\[[^\]]+\]\s*/', '', $this->title);
    }
}
