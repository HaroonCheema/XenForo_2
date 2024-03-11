<?php

namespace CMTV\Math\BbCode;

class Cmtv
{
    public static function renderTagCmtv($tagChildren, $tagOption, $tag, array $options, \XF\BbCode\Renderer\AbstractRenderer $renderer)
    {
        // $content = $renderer->renderSubTree($tagChildren, $options);

        // if ($content === '') {
        //     return '';
        // }

        $empty = "";


        $viewParams = [
            'equation' => isset($tagChildren[0]) ? $tagChildren[0] : $empty
        ];

        return $renderer->getTemplater()->renderTemplate('public:cmtv_math_bbcode', $viewParams);
    }

    public static function renderTagCmtvs($tagChildren, $tagOption, $tag, array $options, \XF\BbCode\Renderer\AbstractRenderer $renderer)
    {
        // $content = $renderer->renderSubTree($tagChildren, $options);

        // if ($content === '') {
        //     return '';
        // }

        $empty = "";


        $viewParams = [
            'equation' => isset($tagChildren[0]) ? $tagChildren[0] : $empty
        ];

        return $renderer->getTemplater()->renderTemplate('public:cmtv_math_bbcode', $viewParams);
    }
}
