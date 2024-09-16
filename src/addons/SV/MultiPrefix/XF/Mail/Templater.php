<?php

namespace SV\MultiPrefix\XF\Mail;



use SV\MultiPrefix\ILinkablePrefix;
use XF\Mvc\Entity\Entity;
use XF\Phrase;

/**
 * Extends \XF\Mail\Templater
 */
class Templater extends XFCP_Templater
{
    /**
     * @param \SV\MultiPrefix\XF\Template\Templater $templater
     * @param string                                $escape
     * @param string                                $contentType
     * @param int|Entity                            $prefixId
     * @param string                                $format
     * @param string|null                           $append
     * @param string|null                           $appendTrailing
     * @return string
     * @noinspection PhpMissingParamTypeInspection
     */
    public function fnPrefix($templater, &$escape, $contentType, $prefixId, $format = 'html', $append = null, $appendTrailing = null)
    {
        if (!($prefixId instanceof Entity) || !isset($prefixId->sv_prefix_ids))
        {
            return parent::fnPrefix($templater, $escape, $contentType, $prefixId, $format, $append);
        }

        $content = $prefixId;
        $prefixIds = $content->sv_prefix_ids ?? [];

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
                                    && $content instanceof ILinkablePrefix;
                $viewParams = [
                    'prefixes'    => $prefixesToRender,
                    'contentType' => $contentType,
                    'entity'      => $content,
                    'withLink'    => $linkPrefixFilter,
                    'linkType'    => 'canonical:',
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