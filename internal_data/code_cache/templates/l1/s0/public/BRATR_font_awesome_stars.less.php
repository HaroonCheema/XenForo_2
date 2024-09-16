<?php
// FROM HASH: f37698f4b3cb7b802648038fa514b28b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.ratingStars' . ($__vars['xf']['options']['BRATR_onlyAddon'] ? '.bratr-rating' : '') . '
{
	.ratingStars-star
	{
		&.ratingStars-star--full
		{
			&:before
			{
				content: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['fullIcon']['content']) . '\' !important;
				font-family: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['fullIcon']['fontFamily']) . '\' !important;
			}
		}
		&:before
		{
			content: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['disableIcon']['content']) . '\' !important;
			font-family: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['disableIcon']['fontFamily']) . '\' !important;
		}

		&.ratingStars-star--half
		{
			&:after
			{
				display: none !important;
			}
			&:before
			{
				content: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['halfIcon']['content']) . '\' !important;
				font-family: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['halfIcon']['fontFamily']) . '\' !important;
				color: @xf-starFullColor;
			}
		}
	}
}

.br-theme-fontawesome-stars 
{
	.br-widget' . ($__vars['xf']['options']['BRATR_onlyAddon'] ? '.bratr-rating' : '') . '  
	{
		a:after 
		{
			content: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['disableIcon']['content']) . '\' !important;
			font-family: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['disableIcon']['fontFamily']) . '\' !important;
		}

		a.br-active:after,
		a.br-selected:after 
		{
			content: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['fullIcon']['content']) . '\' !important;
			font-family: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['fullIcon']['fontFamily']) . '\' !important;
		}
		a.br-fractional
		{
			&:after
			{
				display: none !important;
			}
			&:before
			{
				content: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['halfIcon']['content']) . '\' !important;
				font-family: \'' . $__templater->escape($__vars['xf']['options']['BRATR_fontAwesome']['halfIcon']['fontFamily']) . '\' !important;
				color: @xf-starFullColor !important;
			}
		}
	}
}';
	return $__finalCompiled;
}
);