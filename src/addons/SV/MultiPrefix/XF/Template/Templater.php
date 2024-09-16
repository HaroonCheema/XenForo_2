<?php
/**
 * @noinspection PhpMissingReturnTypeInspection
 */

namespace SV\MultiPrefix\XF\Template;

use SV\MultiPrefix\Listener;
use XF\Mvc\Entity\Entity;
use XF\Phrase;

/**
 * Class Templater
 *
 * @package SV\MultiPrefix\XF\Template
 */
class Templater extends XFCP_Templater
{
    /** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
    public function addDefaultHandlers()
    {
        parent::addDefaultHandlers();

        $hasFromCallable = \is_callable('\Closure::fromCallable');

        $callable = [$this, 'fnSvPrefixFilters'];
        if ($hasFromCallable)
        {
            $callable = \Closure::fromCallable($callable);
        }
        $this->addFunction('prefix_filters', $callable);

        $callable = [$this, 'fnSvPrefix'];
        if ($hasFromCallable)
        {
            $callable = \Closure::fromCallable($callable);
        }
        $this->addFunction('prefix', $callable);
    }

    /**
     * @param Templater  $templater
     * @param bool       $escape
     * @param string     $contentType
     * @param string     $route
     * @param Entity     $container
     * @param Entity     $content
     * @param array      $filters
     * @return string
     * @noinspection PhpMissingParamTypeInspection
     * @noinspection PhpUnusedParameterInspection
     */
    public function fnSvPrefixFilters($templater, &$escape, $contentType, $route, $container, $content, $filters)
    {
        $prefixIds = $content->sv_prefix_ids ?? null;

        if (\count($prefixIds) === 0)
        {
            return '';
        }
        if ($filters === null)
        {
            $filters = [];
        }
        if (!isset($filters['prefix_id']))
        {
            $filters['prefix_id'] = [];
        }
        if (!\is_array($filters['prefix_id']))
        {
            $filters['prefix_id'] = [$filters['prefix_id']];
        }

        $prefixCache = $this->app->container('prefixes.' . $contentType);
        $prefixesToRender = [];
        foreach ($prefixIds as $prefixId)
        {
            $prefixId = (int)$prefixId;
            $prefixCss = $prefixCache[$prefixId] ?? null;
            if ($prefixCss === null)
            {
                continue;
            }
            $prefixesToRender[$prefixId] = $prefixCss;
        }

        $escape = false;
        if (\count($prefixesToRender) === 0)
        {
            return '';
        }

        $viewParams = [
            'filters'     => $filters,
            'prefixes'    => $prefixesToRender,
            'contentType' => $contentType,
            'entity'      => $content,
            'container'   => $container,
            'route'       => $route,
        ];

        return $this->renderMacro('public:sv_multiprefix_prefix_macros', 'render_prefix_filters', $viewParams);
    }

    /**
     * @param       $prefixes
     * @param array $controlOptions
     * @param array $rowOptions
     * @return string
     */
    public function formPrefixInputRow($prefixes, array $controlOptions, array $rowOptions)
    {
        $this->addToClassAttribute($rowOptions, 'formRow--input', 'rowclass');

        $controlId = $this->assignFormControlId($controlOptions);
        $controlHtml = '';

        if (isset($controlOptions['full-row']) && $controlOptions['full-row'] === true && !empty($prefixes))
        {
            $controlHtmlTitleExcluded = $this->formPrefixInput($prefixes, \array_merge($controlOptions, ['exclude' => 'title']));
            $controlHtmlPrefixExcluded = $this->formPrefixInput($prefixes, \array_merge($controlOptions, ['exclude' => 'prefix']));
            $controlHtml .= $this->formRow($controlHtmlTitleExcluded, \array_merge($rowOptions, ['label' => \XF::phrase('prefixes')]), $controlId);
            $controlHtml .= $this->formRow($controlHtmlPrefixExcluded, $rowOptions, $controlId);
        }
        else
        {
            $controlHtml .= $this->formPrefixInput($prefixes, $controlOptions);
            $controlHtml = $this->formRow($controlHtml, $rowOptions, $controlId);
        }

        return $controlHtml;
    }

    /**
     * @param       $prefixes
     * @param array $controlOptions
     * @return string
     */
    public function formPrefixInput($prefixes, array $controlOptions)
    {
        $oldPrefixIds = Listener::$prefixIds;
        $oldPrefixContentParent = Listener::$prefixContentParent;
        $oldPrefixContent = Listener::$prefixContent;
        $oldExcludeRow = Listener::$excludeRow;
        $oldListenTo = Listener::$listenTo;
        $oldListenToHref = Listener::$listenToHref;

        Listener::$prefixIds = $controlOptions['multi-prefix-value'] ?: null;
        Listener::$prefixContentParent = $controlOptions['multi-prefix-content-parent'] ?: null;
        Listener::$prefixContent = $controlOptions['multi-prefix-content'] ?: null;
        Listener::$excludeRow = $controlOptions['exclude'] ?: null;
        Listener::$listenTo = $controlOptions['listen-to'] ?: null;
        Listener::$listenToHref = $controlOptions['href'] ?: null;

        try
        {
            return parent::formPrefixInput($prefixes, $controlOptions);
        }
        finally
        {
            Listener::$prefixIds = $oldPrefixIds;
            Listener::$prefixContentParent = $oldPrefixContentParent;
            Listener::$prefixContent = $oldPrefixContent;
            Listener::$excludeRow = $oldExcludeRow;
            Listener::$listenTo = $oldListenTo;
            Listener::$listenToHref = $oldListenToHref;
        }
    }

    /**
     * @param Templater   $templater
     * @param string      $escape
     * @param string      $contentType
     * @param int|Entity  $prefixId
     * @param string      $format
     * @param string|null $append
     * @param string|null $appendTrailing
     * @return string
     * @noinspection PhpMissingParamTypeInspection
     */
    public function fnSvPrefix($templater, &$escape, $contentType, $prefixId, $format = 'html', $append = null, $appendTrailing = null)
    {
        if (!$prefixId)
        {
            return '';
        }

        if (!is_array($prefixId) && (!($prefixId instanceof Entity) || !isset($prefixId->sv_prefix_ids)))
        {
            return $this->fnPrefix($templater, $escape, $contentType, $prefixId, $format, $append);
        }

        $content = $prefixId;
        if (!is_array($prefixId))
        {
            $prefixIds = $content->sv_prefix_ids ?? [];
        }
        else
        {
            $prefixIds = $prefixId;
        }

        if (\count($prefixIds) === 0)
        {
            return '';
        }
        $prefixCache = $this->app->container('prefixes.' . $contentType);
        $prefixesToRender = [];
        foreach ($prefixIds as $prefixId)
        {
            $prefixId = (int)$prefixId;
            $prefixCss = $prefixCache[$prefixId] ?? null;
            if ($prefixCss === null)
            {
                continue;
            }
            $prefixesToRender[$prefixId] = $prefixCss;
        }

        $escape = false;
        if (\count($prefixesToRender) === 0)
        {
            return '';
        }

        switch ($format)
        {
            case 'html-clicky':
            case 'html':
                $linkPrefixFilter = (\XF::options()->svClickablePrefixes ?? false)
                                    && ($format === 'html-clicky')
                                    && \is_callable([$content, 'getSvPrefixFilterLink']);
                $viewParams = [
                    'prefixes'    => $prefixesToRender,
                    'contentType' => $contentType,
                    'entity'      => $content,
                    'withLink'    => $linkPrefixFilter,
                    'linkType'    => '',
                    'suffixPad'   => $appendTrailing !== '',
                ];

                return $this->renderMacro('public:sv_multiprefix_prefix_macros', 'render_prefix_html', $viewParams);
            case 'plain':
            default:
                if ($append === null)
                {
                    $append = ' - ';
                }
                break;
        }

        $context = $format === 'plain' ? 'raw' : 'html';
        $output = [];
        $func = \XF::$versionId >= 2010370 ? 'func' : 'fn';

        foreach ($prefixesToRender as $prefixId => $prefixCss)
        {
            $phraseTitle = $this->$func('prefix_title', [$contentType, $prefixId], false);
            if ($phraseTitle instanceof Phrase)
            {
                $output[] = $phraseTitle->render($context);
            }
            else
            {
                $output[] = $context === 'raw' ? $phraseTitle : \XF::escapeString($phraseTitle, $context);
            }
        }

        $escape = false;
        if (\count($output) === 0)
        {
            return '';
        }

        $append = $append ?: '';
        $appendTrailing = $appendTrailing === null ? $append : $appendTrailing;

        return \join($append, $output) . $appendTrailing;
    }
}
