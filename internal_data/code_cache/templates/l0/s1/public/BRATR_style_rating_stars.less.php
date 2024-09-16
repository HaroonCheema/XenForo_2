<?php
// FROM HASH: c5b14f304e3d54484a301b849fa975cb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.ratingStars' . ($__vars['xf']['options']['BRATR_onlyAddon'] ? '.bratr-rating' : '') . '{
	.ratingStars-star{
		width: ' . $__templater->escape($__vars['xf']['options']['BRATR_styleRating']['width']) . 'px;
		height: ' . $__templater->escape($__vars['xf']['options']['BRATR_styleRating']['height']) . 'px;
		background: transparent url(' . $__templater->func('base_url', array($__vars['xf']['options']['BRATR_styleRating']['url'], ), true) . ') no-repeat ' . $__templater->escape($__vars['xf']['options']['BRATR_styleRating']['background_posission_x']) . 'px;
		font-size: 0px;
		&.ratingStars-star--full{
			background-position: 0px;
		}

		&.ratingStars-star--half{
			background-position: ' . $__templater->escape($__vars['xf']['options']['BRATR_styleRating']['background_position']) . 'px;
		}
	}
}

.br-theme-fontawesome-stars{
	.br-widget' . ($__vars['xf']['options']['BRATR_onlyAddon'] ? '.bratr-rating' : '') . ' {
		height: ' . $__templater->escape($__vars['xf']['options']['BRATR_styleRating']['height']) . 'px;
		a {
			width: ' . $__templater->escape($__vars['xf']['options']['BRATR_styleRating']['width']) . 'px;
			height: ' . $__templater->escape($__vars['xf']['options']['BRATR_styleRating']['height']) . 'px;
			background: transparent url(' . $__templater->func('base_url', array($__vars['xf']['options']['BRATR_styleRating']['url'], ), true) . ') no-repeat ' . $__templater->escape($__vars['xf']['options']['BRATR_styleRating']['background_posission_x']) . 'px;
			display: inline-block;
			font-size: 0px;
		}

		a:after{
			display: none !important;
		}

		a.br-active,
		a.br-selected {
			background-position: 0;
		}

		a.br-fractional{
			background-position: ' . $__templater->escape($__vars['xf']['options']['BRATR_styleRating']['background_position']) . 'px;
			&:before{
				display: none !important;
			}
		}
	}
}';
	return $__finalCompiled;
}
);