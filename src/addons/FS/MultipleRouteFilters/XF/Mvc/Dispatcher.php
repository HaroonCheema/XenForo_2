<?php

namespace FS\MultipleRouteFilters\XF\Mvc;

use XF\Mvc\RouteMatch;

class Dispatcher extends XFCP_Dispatcher
{

    public function route($routePath)
    {
        $parts = explode('/', $routePath, 2);
        $prefix = $parts[0];

        $newRoutePath = $this->getRouter()->applyMultiRouteFilterToUrl($prefix, $routePath);

        if ($newRoutePath == $routePath) {
            return parent::route($routePath);
        }

        $match = $this->getRouter()->routeToController($newRoutePath, $this->request);

        if (!($match instanceof RouteMatch) || !$match->getController()) {
            $match = $this->app->getErrorRoute('DispatchError', [
                'code' => 'invalid_route',
                'match' => $match
            ]);
        }

        if (strlen($newRoutePath) > 1 && substr($newRoutePath, -1, 1) != '/') {
            // this is a route path that does not have a trailing slash which can be ambiguous
            // is it a controller action or is it a URL that contains a string param?
            // if it fails then we should retry the same route path with a trailing slash
            $match->setPathRetry("$newRoutePath/");
        }

        return $match;
    }
}
