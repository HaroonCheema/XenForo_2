<?php

namespace FS\MultipleRouteFilters\XF\Mvc;

class Router extends XFCP_Router
{

    public function applyMultiRouteFilterToUrl($prefix, $routeUrl)
    {
        $filters = $this->routeFiltersOut;

        if (isset($filters[$prefix])) {
            if (!isset($this->routeFiltersOutRegex[$prefix])) {
                $regexes = [];

                foreach ($filters[$prefix] as $filter) {
                    list($from, $to) = $this->routeFilterToRegex(
                        $filter['find_route'],
                        $filter['replace_route']
                    );
                    $regexes[] = ['from' => $from, 'to' => $to];
                }

                $this->routeFiltersOutRegex[$prefix] = $regexes;
            }

            foreach ($this->routeFiltersOutRegex[$prefix] as $filter) {
                $newLink = preg_replace($filter['from'], $filter['to'], $routeUrl);
                if ($newLink != $routeUrl) {
                    $routeUrl = $newLink;
                    break;
                }
            }
        }

        $maxIterations = 10;
        $iteration = 0;

        while ($iteration < $maxIterations) {
            $iteration++;

            // $newPrefix = strstr($routeUrl, '/', true);
            $parts = explode('/', $routeUrl, 2);
            $newPrefix = $parts[0];

            if ($newPrefix === false || $newPrefix === $prefix) {
                break;
            }

            if (!isset($filters[$newPrefix])) {
                break;
            }

            if (!isset($this->routeFiltersOutRegex[$newPrefix])) {
                $regexes = [];
                foreach ($filters[$newPrefix] as $filter) {
                    list($from, $to) = $this->routeFilterToRegex(
                        $filter['find_route'],
                        $filter['replace_route']
                    );
                    $regexes[] = ['from' => $from, 'to' => $to];
                }
                $this->routeFiltersOutRegex[$newPrefix] = $regexes;
            }

            $replaced = false;
            foreach ($this->routeFiltersOutRegex[$newPrefix] as $filter) {
                $newLink = preg_replace($filter['from'], $filter['to'], $routeUrl);
                if ($newLink != $routeUrl) {
                    $routeUrl = $newLink;
                    $prefix = $newPrefix;
                    $replaced = true;
                    break;
                }
            }

            if (!$replaced) {
                break;
            }
        }

        return $routeUrl;
    }
}
