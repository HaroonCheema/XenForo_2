<?php

namespace CMTV\Math\BbCode;

class Cmtv
{
    public static function renderTagCmtv($tagChildren, $tagOption, $tag, array $options, \XF\BbCode\Renderer\AbstractRenderer $renderer)
    {
<<<<<<< HEAD
        // $content = $renderer->renderSubTree($tagChildren, $options);

        // if ($content === '') {
        //     return '';
        // }

        $empty = "";
=======

        $empty = "\begin{align*}
        \int_a^b f(x) dx &= \lim_{n \to \infty} \sum_{i=1}^n f(a + i \Delta x) \Delta x \\
        \frac{d}{dx} \sin(x) &= \cos(x)
        \end{align*}";
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0

        $viewParams = [
            'equation' => isset($tagChildren[0]) ? $tagChildren[0] : $empty
        ];

        return $renderer->getTemplater()->renderTemplate('public:cmtv_math_bbcode', $viewParams);
    }

    public static function renderTagCmtvs($tagChildren, $tagOption, $tag, array $options, \XF\BbCode\Renderer\AbstractRenderer $renderer)
    {
<<<<<<< HEAD
        // $content = $renderer->renderSubTree($tagChildren, $options);

        // if ($content === '') {
        //     return '';
        // }

        $empty = "";
=======

        $empty = "\begin{align*}
        \int_a^b f(x) dx &= \lim_{n \to \infty} \sum_{i=1}^n f(a + i \Delta x) \Delta x \\
        \frac{d}{dx} \sin(x) &= \cos(x)
        \end{align*}";
>>>>>>> ec84cb00a69fdecad2b7ec284b83c9f007c870e0

        $viewParams = [
            'equation' => isset($tagChildren[0]) ? $tagChildren[0] : $empty
        ];

        return $renderer->getTemplater()->renderTemplate('public:cmtv_math_bbcode', $viewParams);
    }
}
