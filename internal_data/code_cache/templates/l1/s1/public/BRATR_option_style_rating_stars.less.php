<?php
// FROM HASH: 5d8b69fdb99f6e4f3257dbf660090691
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.ratingStars' . ($__vars['xf']['options']['BRATR_onlyAddon'] ? '.bratr-rating' : '') . '{
	.ratingStars-star{
		.br-option-style-fn(' . $__templater->escape($__vars['xf']['options']['BRATR_iconRating']) . ', width);
		.br-option-style-fn(' . $__templater->escape($__vars['xf']['options']['BRATR_iconRating']) . ', height);
		background: transparent url(\'styles/brivium/AdvancedThreadRating/' . $__templater->escape($__vars['xf']['options']['BRATR_iconRating']) . '.png\') no-repeat;
		.br-option-style-fn(' . $__templater->escape($__vars['xf']['options']['BRATR_iconRating']) . ', empty-position);
		font-size: 0px;

		&.ratingStars-star--full{
			background-position: 0px;
		}

		&.ratingStars-star--half{
			.br-option-style-fn(' . $__templater->escape($__vars['xf']['options']['BRATR_iconRating']) . ', half-position);
		}
	}
}

.br-theme-fontawesome-stars{
	.br-widget' . ($__vars['xf']['options']['BRATR_onlyAddon'] ? '.bratr-rating' : '') . '{
		.br-option-style-fn(' . $__templater->escape($__vars['xf']['options']['BRATR_iconRating']) . ', height);

		a{
			.br-option-style-fn(' . $__templater->escape($__vars['xf']['options']['BRATR_iconRating']) . ', width);
			.br-option-style-fn(' . $__templater->escape($__vars['xf']['options']['BRATR_iconRating']) . ', height);
			background: transparent url(\'styles/brivium/AdvancedThreadRating/' . $__templater->escape($__vars['xf']['options']['BRATR_iconRating']) . '.png\') no-repeat;
			.br-option-style-fn(' . $__templater->escape($__vars['xf']['options']['BRATR_iconRating']) . ', empty-position);
			display: inline-block;
			font-size: 0px;
		}

		a:after{
		display: none !important;
		}

		a.br-active,
		a.br-selected {
			background-position: 0px;
		}
		a.br-fractional{
			.br-option-style-fn(' . $__templater->escape($__vars['xf']['options']['BRATR_iconRating']) . ', half-position);
			
			&:before{
				display: none !important;
			}
		}
	}
}

.br-option-style-fn(@icon, @type){
  & when (@type = width){
    & when(@icon = heart-blue),
		(@icon = heart-green),
		(@icon = heart-red),
		(@icon = heart-yellow),

		(@icon = circle-star-blue),
		(@icon = circle-star-green),
		(@icon = circle-star-red),
		(@icon = circle-star-yellow),

		(@icon = arrow-blue),
		(@icon = arrow-green),
		(@icon = arrow-red),
		(@icon = arrow-yellow)
	{
		width: 22px;
    }
    & when(@icon = paw-blue),
		(@icon = paw-green),
		(@icon = paw-red),
		(@icon = paw-yellow),

		(@icon = star-blue),
		(@icon = star-green),
		(@icon = star-red),
		(@icon = star-yellow),

		(@icon = tick-blue),
		(@icon = tick-green),
		(@icon = tick-red),
		(@icon = tick-yellow)
	{
		width: 25px;
    }
    & when(@icon = drop-blue),
		(@icon = drop-green),
		(@icon = drop-red),
		(@icon = drop-yellow)
	{
		width: 16px;
    }
  }

  & when (@type = height){
    & when(@icon = heart-blue),
		(@icon = heart-green),
		(@icon = heart-red),
		(@icon = heart-yellow),

		(@icon = circle-star-blue),
		(@icon = circle-star-green),
		(@icon = circle-star-red),
		(@icon = circle-star-yellow),

		(@icon = tick-blue),
		(@icon = tick-green),
		(@icon = tick-red),
		(@icon = tick-yellow),

	  	(@icon = drop-blue),
		(@icon = drop-green),
		(@icon = drop-red),
		(@icon = drop-yellow)
	{
		height: 22px;
    }
    & when(@icon = star-blue),
		(@icon = star-green),
		(@icon = star-red),
		(@icon = star-yellow)
	{
		height: 23px;
    }
    & when(@icon = paw-blue),
		(@icon = paw-green),
		(@icon = paw-red),
		(@icon = paw-yellow),
		(@icon = arrow-blue),
		(@icon = arrow-green),
		(@icon = arrow-red),
		(@icon = arrow-yellow)
	{
		height: 25px;
    }
  }

  & when (@type = half-position){
    & when(@icon = heart-blue),
		(@icon = heart-green),
		(@icon = heart-red),
		(@icon = heart-yellow)
	{
		background-position: -30px;
    }
    & when(@icon = circle-star-blue),
		(@icon = circle-star-green),
		(@icon = circle-star-red),
		(@icon = circle-star-yellow)
	{
		background-position: -28px;
    }
    & when(@icon = paw-blue),
		(@icon = paw-green),
		(@icon = paw-red),
		(@icon = paw-yellow),

		(@icon = star-blue),
		(@icon = star-green),
		(@icon = star-red),
		(@icon = star-yellow),

		(@icon = tick-blue),
		(@icon = tick-green),
		(@icon = tick-red),
		(@icon = tick-yellow)
	{
		background-position: -25px;
    }
    & when(@icon = drop-blue),
		(@icon = drop-green),
		(@icon = drop-red),
		(@icon = drop-yellow)
	{
		background-position: -24px;
    }
    & when(@icon = arrow-blue),
		(@icon = arrow-green),
		(@icon = arrow-red),
		(@icon = arrow-yellow)
	{
		background-position: -22px;
    }
  }

  & when (@type = empty-position){
    & when(@icon = heart-blue),
		(@icon = heart-green),
		(@icon = heart-red),
		(@icon = heart-yellow)
	{
		background-position: -61px;
    }
    & when(@icon = circle-star-blue),
		(@icon = circle-star-green),
		(@icon = circle-star-red),
		(@icon = circle-star-yellow)
	{
		background-position: -54px;
    }
    & when(@icon = paw-blue),
		(@icon = paw-green),
		(@icon = paw-red),
		(@icon = paw-yellow),
		(@icon = star-blue),
		(@icon = star-green),
		(@icon = star-red),
		(@icon = star-yellow),
		(@icon = tick-blue),
		(@icon = tick-green),
		(@icon = tick-red),
		(@icon = tick-yellow)
	{
		background-position: -50px;
    }
    & when(@icon = drop-blue),
		(@icon = drop-green),
		(@icon = drop-red),
		(@icon = drop-yellow)
	{
		background-position: -53px;
    }
    & when(@icon = arrow-blue),
		(@icon = arrow-green),
		(@icon = arrow-red),
		(@icon = arrow-yellow)
	{
		background-position: -44px;
    }
  }
}';
	return $__finalCompiled;
}
);