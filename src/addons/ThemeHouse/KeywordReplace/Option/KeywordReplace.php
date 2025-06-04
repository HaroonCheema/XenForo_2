<?php

namespace ThemeHouse\KeywordReplace\Option;

use XF\Option\AbstractOption;

class KeywordReplace extends AbstractOption
{

    public static function renderOption(\XF\Entity\Option $option, array $htmlParams)
    {
        $choices = [];
        foreach ($option->option_value as $word) {
            $choices[] = [
                'word' => $word['word'],
                'replace' => is_string($word['replace']) ? $word['replace'] : '',
                'live' => $word['live'] ?? 0,
            ];
        }

        return self::getTemplate('admin:th_option_template_keyword_replace', $option, $htmlParams, [
            'choices' => $choices,
            'nextCounter' => count($choices)
        ]);
    }

    // public static function renderOption(\XF\Entity\Option $option, array $htmlParams)
    // {
    //     $value = $preparedOption['option_value'];

    //     $choices = array();
    //     foreach ($value as $word => $wordOptions) {
    //         $choices[] = array(
    //             'word' => $word,
    //             'live' => isset($wordOptions['live']) ? $wordOptions['live'] : 0,
    //             'replace' => isset($wordOptions['replace']) ? $wordOptions['replace'] : '',
    //             'limit' => isset($wordOptions['limit']) ? $wordOptions['limit'] : '',
    //             'replace_type' => isset($wordOptions['replace_type']) ? $wordOptions['replace_type'] : ''
    //         );
    //     }

    //     $editLink = $view->createTemplateObject(
    //         'option_list_option_editlink',
    //         array(
    //             'preparedOption' => $preparedOption,
    //             'canEditOptionDefinition' => $canEdit
    //         )
    //     );

    //     return $view->createTemplateObject(
    //         'th_option_template_keyword_replace',
    //         array(
    //             'fieldPrefix' => $fieldPrefix,
    //             'listedFieldName' => $fieldPrefix . '_listed[]',
    //             'preparedOption' => $preparedOption,
    //             'formatParams' => $preparedOption['formatParams'],
    //             'editLink' => $editLink,

    //             'choices' => $choices,
    //             'nextCounter' => count($choices)
    //         )
    //     );
    // }

    public static function verifyOption(array &$value)
    {
        $output = [];

        foreach ($value as $word) {
            if (!isset($word['word']) || !isset($word['replace'])) {
                continue;
            }

            $cache = self::buildCensorCacheValue($word['word'], $word['replace']);
            if ($cache) {
                $output[] = $cache;
            }
        }

        $value = $output;

        return true;
    }



    /**
     * Builds the regex and censor cache value for a find/replace pair
     *
     * @param string $find
     * @param string $replace
     *
     * @return array|bool
     */
    public static function buildCensorCacheValue($find, $replace)
    {
        $find = trim(strval($find));
        if ($find === '') {
            return false;
        }

        $prefixWildCard = preg_match('#^\*#', $find);
        $suffixWildCard = preg_match('#\*$#', $find);

        $replace = is_int($replace) ? '' : trim(strval($replace));
        if ($replace === '') {
            $replace = utf8_strlen($find);
            if ($prefixWildCard) {
                $replace--;
            }
            if ($suffixWildCard) {
                $replace--;
            }
        }

        $regexFind = $find;
        if ($prefixWildCard) {
            $regexFind = substr($regexFind, 1);
        }
        if ($suffixWildCard) {
            $regexFind = substr($regexFind, 0, -1);
        }

        if (!strlen($regexFind)) {
            return false;
        }

        $regex = '#'
            . ($prefixWildCard ? '' : '(?<=\W|^)')
            . preg_quote($regexFind, '#')
            . ($suffixWildCard ? '' : '(?=\W|$)')
            . '#iu';

        return [
            'word' => $find,
            'regex' => $regex,
            'replace' => $replace
        ];
    }


    // public static function renderOption(XenForo_View $view, $fieldPrefix, array $preparedOption, $canEdit)
    // {
    //     $value = $preparedOption['option_value'];

    //     $choices = array();
    //     foreach ($value as $word => $wordOptions) {
    //         $choices[] = array(
    //             'word' => $word,
    //             'live' => isset($wordOptions['live']) ? $wordOptions['live'] : 0,
    //             'replace' => isset($wordOptions['replace']) ? $wordOptions['replace'] : '',
    //             'limit' => isset($wordOptions['limit']) ? $wordOptions['limit'] : '',
    //             'replace_type' => isset($wordOptions['replace_type']) ? $wordOptions['replace_type'] : ''
    //         );
    //     }

    //     $editLink = $view->createTemplateObject('option_list_option_editlink',
    //         array(
    //             'preparedOption' => $preparedOption,
    //             'canEditOptionDefinition' => $canEdit
    //         ));

    //     return $view->createTemplateObject('th_option_template_keyword_replace',
    //         array(
    //             'fieldPrefix' => $fieldPrefix,
    //             'listedFieldName' => $fieldPrefix . '_listed[]',
    //             'preparedOption' => $preparedOption,
    //             'formatParams' => $preparedOption['formatParams'],
    //             'editLink' => $editLink,

    //             'choices' => $choices,
    //             'nextCounter' => count($choices)
    //         ));
    // }

    // public static function verifyOption(\XF\Http\Request $request, array &$options, &$error = null)
    // {
    //     $output = array();

    //     foreach ($words as $word) {
    //         if (!isset($word['word']) || strval($word['word']) === '') {
    //             continue;
    //         }

    //         $output[strval(strtolower($word['word']))] = $word;
    //     }

    //     $words = $output;

    //     return true;
    // }
}
