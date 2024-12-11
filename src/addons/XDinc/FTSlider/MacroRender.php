<?php

/*
 * Updated on 19.10.2020
 * HomePage: https://xentr.net
 * Copyright (c) 2020 XENTR | XenForo Add-ons - Styles -  All Rights Reserved
 */

namespace XDinc\FTSlider;

class MacroRender
{
    /** @noinspection PhpUnusedParameterInspection */
    /** @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection */
    public static function preRender(\XF\Template\Templater $templater, &$type, &$template, &$name, array &$arguments, array &$globalVars)
    {
        /** @var \XF\Entity\OptionGroup $group */
        $group = $arguments['group'] ?? null;
        if ($group && $group->group_id === 'FTSlider_Options')
        {
            $template = 'FTSlider_options_macros';
        }
    }
}