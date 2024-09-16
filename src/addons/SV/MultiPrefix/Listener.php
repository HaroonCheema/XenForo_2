<?php

namespace SV\MultiPrefix;

use SV\MultiPrefix\XF\Entity\Thread;
use SV\MultiPrefix\XFRM\Entity\ResourceItem;
use XF\Mvc\Entity\Entity;
use XF\Template\Templater;

class Listener
{
    /** @var null|Entity|ResourceItem|Thread */
    public static $draftEntity = null;

    /**
     * @var null|array
     */
    public static $prefixIds = null;

    /**
     * @var null|\SV\MultiPrefix\XF\Entity\Forum|\SV\MultiPrefix\XFRM\Entity\Category
     */
    public static $prefixContentParent = null;

    /**
     * @var null|Thread|ResourceItem
     */
    public static $prefixContent = null;

    /**
     * @var bool
     */
    public static $excludeRow = null;

    public static $listenTo = null;

    public static $listenToHref = null;

    /**
     * @var array
     */
    public static $supportedContentTypes = [
        'thread'   => true,
        'resource' => true,
        'dbtechEcommerceProduct' => true,
        'dbtechShopItem' => true,
        'xcpm_project' => true,
        'xcpm_project_task' => true,
    ];

    /**
     * @param $key
     * @param $template
     * @param array $params
     *
     * @return bool
     */
    protected static function rewriteForMultiPrefixSupport($key, &$template, array &$params)
    {
        if (isset($params[$key]) && isset(self::$supportedContentTypes[$params[$key]]))
        {
            $template = 'sv_multiprefix_prefix_input';
            $params['prefixMultiple'] = true;
            $params['prefixValue'] = Listener::$prefixIds ?: ($params['prefixValue'] ?: 0);
            $params['prefixContentParent'] = Listener::$prefixContentParent;
            $params['prefixContent'] = Listener::$prefixContent;
            $params['excludeRow'] = self::$excludeRow;

            if (!empty(Listener::$listenTo) && !empty(Listener::$listenToHref))
            {
                $params['listen-to'] = Listener::$listenTo;
                $params['href'] = Listener::$listenToHref;
            }

            return true;
        }

        return false;
    }

    /**
     * @param Templater $templater
     * @param $type
     * @param $template
     *
     * @param array $params
     */
    public static function prefixInputTemplatePreRender(/** @noinspection PhpUnusedParameterInspection */
        Templater $templater, &$type, &$template, array &$params)
    {
        self::rewriteForMultiPrefixSupport('prefixType', $template, $params);
    }

    protected static function calculatePrefixMacrosMultipleArgumentIfNeeded(array &$arguments)
    {
        if (\array_key_exists('includeAny', $arguments) && !\array_key_exists('includeNone', $arguments))
        {
            $arguments['includeNone'] = $arguments['includeAny'];
        }

        $noneLabel = $arguments['noneLabel'] ?? null;
        if (isset($arguments['href']) && isset($arguments['listenTo']))
        {
            // will cause possible reloading, so just remove the non-default phrases..
            unset($arguments['noneLabel']);
            unset($arguments['anyLabel']);
        }

        if (!\array_key_exists('selected', $arguments))
        {
            return;
        }

        $selected = $arguments['selected'];
        // try to shim filters
        if ($noneLabel !== null && isset($arguments['href']) && (\is_array($selected) || $selected === 0))
        {
            $args = [];
            unset($arguments['noneLabel']);
            if (!\array_key_exists('includeNone', $arguments))
            {
                $args[] = 'none=1';
                $arguments['includeNone'] = true;
            }
            if (!\array_key_exists('includeAny', $arguments))
            {
                $args[] = 'any=1';
                $arguments['includeAny'] = true;
            }
            $arguments['selected'] = [];
            if (\count($args) !== 0)
            {
                $arguments['href'] = $arguments['href'] . (\stripos($arguments['href'], '?') === false ? '?' : '&') . \implode('&', $args);
            }
        }

        if (!\is_array($selected))
        {
            return;
        }

        $arguments['multiple'] = true;
    }

    protected static function checkFilterAnyNoneSupport(array &$params)
    {
        if (!\array_key_exists('includeNone', $params))
        {
            $params['includeNone'] = \XF::app()->request()->filter('none', 'bool');
        }
        if (!\array_key_exists('includeAny', $params))
        {
            $params['includeAny'] = \XF::app()->request()->filter('any', 'bool');
        }
    }

    /**
     * @param Templater $templater
     * @param $type
     * @param $template
     * @param $name
     * @param array $arguments
     * @param array $globalVars
     */
    public static function templateMacroPreRender_prefix_macros_row(/** @noinspection PhpUnusedParameterInspection */
        Templater $templater, &$type, &$template, &$name, array &$arguments, array &$globalVars)
    {
        if (isset(self::$supportedContentTypes[$arguments['type']]))
        {
            $template = 'sv_multiprefix_prefix_macros';

            static::calculatePrefixMacrosMultipleArgumentIfNeeded($arguments);
        }
    }

    /**
     * @param Templater $templater
     * @param $type
     * @param $template
     * @param $name
     * @param array $arguments
     * @param array $globalVars
     */
    public static function templateMacroPreRender_prefix_macros_select(/** @noinspection PhpUnusedParameterInspection */
        Templater $templater, &$type, &$template, &$name, array &$arguments, array &$globalVars)
    {
        if (isset(self::$supportedContentTypes[$arguments['type']]))
        {
            $template = 'sv_multiprefix_prefix_macros';

            static::calculatePrefixMacrosMultipleArgumentIfNeeded($arguments);
        }
    }

    /**
     * @param Templater $templater
     * @param $type
     * @param $template
     * @param array $params
     */
    public static function templaterTemplatePreRender_forum_prefixes(/** @noinspection PhpUnusedParameterInspection */
        Templater $templater, &$type, &$template, array &$params)
    {
        $template = 'sv_multiprefix_forum_prefixes';
        static::checkFilterAnyNoneSupport($params);
    }

    /**
     * @param Templater $templater
     * @param $type
     * @param $template
     * @param array $params
     */
    public static function templaterTemplatePreRender_xfrm_category_prefixes(/** @noinspection PhpUnusedParameterInspection */
        Templater $templater, &$type, &$template, array &$params)
    {
        $template = 'sv_multiprefix_xfrm_category_prefixes';
        static::checkFilterAnyNoneSupport($params);
    }
    
    /**
     * @param Templater $templater
     * @param $type
     * @param $template
     * @param array $params
     */
    public static function templaterTemplatePreRender_dbtech_ecommerce_category_prefixes(/** @noinspection PhpUnusedParameterInspection */
        Templater $templater, &$type, &$template, array &$params)
    {
        $template = 'sv_multiprefix_dbtech_ecommerce_category_prefixes';
        static::checkFilterAnyNoneSupport($params);
    }
    
    /**
     * @param Templater $templater
     * @param $type
     * @param $template
     * @param array $params
     */
    public static function templaterTemplatePreRender_dbtech_shop_category_prefixes(/** @noinspection PhpUnusedParameterInspection */
        Templater $templater, &$type, &$template, array &$params)
    {
        $template = 'sv_multiprefix_dbtech_shop_category_prefixes';
        static::checkFilterAnyNoneSupport($params);
    }

    /**
     * @param Templater $templater
     * @param $type
     * @param $template
     * @param array $params
     */
    public static function templaterTemplatePreRender_xc_projectmanager_category_prefixes(/** @noinspection PhpUnusedParameterInspection */
        Templater $templater, &$type, &$template, array &$params)
    {
        $template = 'sv_multiprefix_xc_project_manager_category_prefixes';
    }
}