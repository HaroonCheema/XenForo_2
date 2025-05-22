<?php

namespace PF\EditorSymbols\BbCode;

class Symbols
{
    public static function renderTag($tagChildren, $tagOption, $tag, array $options, \XF\BbCode\Renderer\AbstractRenderer $renderer)
    {
        /* Check data provided and existing */
        if (!$tag['option'] || !isset($GLOBALS['tipps'][$tagOption]))
        {
            return $renderer->renderUnparsedTag($tag, $options);
        }

        /** @var \XFMG\XF\Entity\User $visitor */
        $visitor = \XF::visitor();

        /* No data returned if can't view tipps */
        if (!$visitor->canSeeTipp())
        {
            return '';
        }

        $tipp = $GLOBALS['tipps'][$tagOption];

        return $renderer->getTemplater()->renderTemplate('public:xfa_tipp_bbcode', ['tipp' => $tipp]);
    }
}