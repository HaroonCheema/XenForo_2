<?php

namespace XB\ArticleThreadUrl\XF\Mvc;

use XF\Mvc\RouteBuiltLink;
use function is_string;

/**
 * @Extends \XF\Mvc\Router
 */
class Router extends XFCP_Router
{

    protected function buildRouteUrl($prefix, array $route, $action, $data = null, array &$parameters = [])
    {

        if ($prefix != 'threads') {
            return parent::buildRouteUrl($prefix, $route, $action, $data, $parameters);
        }

        if ($data && isset($data['discussion_type']) && $data['discussion_type'] == 'article') {
            return parent::buildRouteUrl($prefix, $route, $action, $data, $parameters);
        }

        if (!empty($route['build_callback'])) {
            $output = call_user_func_array(
                [$route['build_callback'][0], $route['build_callback'][1]],
                [&$prefix, &$route, &$action, &$data, &$parameters, $this]
            );
            if (is_string($output) || $output instanceof RouteBuiltLink) {
                return $output;
            }
        }

        $url = $route['format'];

        $url = preg_replace_callback(
            '#:(?:\+)?int(_p)?<([a-zA-Z0-9_]+)(?:,([a-zA-Z0-9_]+))?>(/?)#',
            function ($match) use ($data, &$parameters) {
                $inParams = !empty($match[1]);
                $idKey = $match[2];
                $stringKey = $match[3];
                $trailingSlash = $match[4];

                $search = $inParams ? $parameters : $data;

                if ($search && isset($search[$idKey])) {
                    $idValue = intval($search[$idKey]);

                    if ($inParams) {
                        unset($parameters[$idKey]);
                    }

                    if ($stringKey && isset($search[$stringKey])) {
                        $string = strval($search[$stringKey]);

                        if ($inParams) {
                            unset($parameters[$stringKey]);
                        }

                        if ($this->includeTitleInUrls) {
                            $string = $this->prepareStringForUrl($string);
                            if (strlen($string)) {
                                return $string . "." . $idValue . $trailingSlash;
                            }
                        }
                    }

                    return $idValue . $trailingSlash;
                }

                return '';
            },
            $url
        );
        $url = preg_replace_callback(
            '#:(?:\+)?str(_p)?<([a-zA-Z0-9_]+)>(/?)#',
            function ($match) use ($data, &$parameters) {
                $inParams = !empty($match[1]);
                $stringKey = $match[2];
                $trailingSlash = $match[3];

                $search = $inParams ? $parameters : $data;

                if ($search && isset($search[$stringKey])) {
                    $key = strval($search[$stringKey]);

                    if ($inParams) {
                        unset($parameters[$stringKey]);
                    }

                    if (strlen($key)) {
                        return $key . $trailingSlash;
                    }
                }

                return '';
            },
            $url
        );
        $url = preg_replace_callback(
            '#:(?:\+)?str_int<([a-zA-Z0-9_]+),([a-zA-Z0-9_]+)(?:,([a-zA-Z0-9_]+))?>(/?)#',
            function ($match) use ($data, $action) {
                $stringKey = $match[1];
                $intKey = $match[2];
                $intStringKey = $match[3];
                $trailingSlash = $match[4];

                if ($data === '-') {
                    return '-' . $trailingSlash;
                }

                if ($data && isset($data[$stringKey])) {
                    $key = strval($data[$stringKey]);
                    if (strlen($key)) {
                        return $key . $trailingSlash;
                    }
                }

                if ($data && isset($data[$intKey])) {
                    $idValue = intval($data[$intKey]);
                    if ($intStringKey && isset($data[$intStringKey]) && $this->includeTitleInUrls) {
                        $string = strval($data[$intStringKey]);
                        $string = $this->prepareStringForUrl($string);
                        if (strlen($string)) {
                            return $string . "." . $idValue . $trailingSlash;
                        }
                    }

                    return $idValue . $trailingSlash;
                }

                return strlen($action) ? '-' . $trailingSlash : '';
            },
            $url
        );
        $url = preg_replace_callback(
            '#:page(<([a-zA-Z0-9_]+)>)?(/?)#',
            function ($match) use ($data, &$parameters) {
                $pageKey = !empty($match[2]) ? $match[2] : 'page';
                $trailingSlash = $match[3];

                if (isset($parameters[$pageKey])) {
                    $page = $parameters[$pageKey];
                    unset($parameters[$pageKey]);
                    if ($page === '%page%') {
                        return "page-%page%$trailingSlash";
                    } else {
                        $page = intval($page);
                        if ($page > 1) {
                            return "page-$page$trailingSlash";
                        }
                    }
                }

                return '';
            },
            $url
        );
        $url = preg_replace_callback(
            '#:action#',
            function ($match) use (&$action) {
                $thisAction = $action;
                $action = '';
                return $thisAction;
            },
            $url
        );
        $url = preg_replace_callback(
            '#:(?:\+)?any<([a-zA-Z0-9_]+)>(/?)#',
            function ($match) use ($data, &$parameters) {
                $stringKey = $match[1];
                $trailingSlash = $match[2];

                if ($data && isset($data[$stringKey])) {
                    $key = strval($data[$stringKey]);

                    if (strlen($key)) {
                        return $key . $trailingSlash;
                    }
                }

                return '';
            },
            $url
        );

        $url = str_replace('?', '', $url);
        if ($url && $action) {
            if (substr($url, -1) != '/') {
                $url .= '/';
            }
            $url .= $action;
        } else if ($action) {
            $url = $action;
        }

        $routeUrl = $prefix . '/' . $url;
        if ($this->indexRoute && $routeUrl === $this->indexRoute) {
            $routeUrl = '';
        } else {
            return $routeUrl;
            // $routeUrl = $this->applyRouteFilterToUrl($prefix, $routeUrl);
        }

        return $routeUrl;
    }
}
