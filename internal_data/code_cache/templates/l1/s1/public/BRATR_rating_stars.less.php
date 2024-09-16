<?php
// FROM HASH: b3d902e8c3b8c838e54230128dd01583
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.ratingStarsRow-text {
	display: inline-block;
    margin-left: 5px;
	[data-xf-click="overlay"]{
		.xf-link();
	}
	&:hover{
		[data-xf-click="overlay"]{
			.xf-linkHover();
		}
	}
}
.br-theme-fontawesome-stars {
	.br-widget' . ($__vars['xf']['options']['BRATR_onlyAddon'] ? '.bratr-rating' : '') . ' {
		a.br-fractional{
		    position: relative;

		    &:before{
				.m-faBase();
				.m-faContent(@fa-var-star, .93em);
				color: @xf-starEmptyColor;
			}

			&:after{
				position: absolute;
				left: 0;
				.m-faBase();
				.m-faContent(@fa-var-star-half, .93em);
				color: @xf-starFullColor;

				& when(@rtl){
					.m-transform(scaleX(-1));
				}
			}
		}
		.bratr-vote-content{
            display: inline-block !important;
            margin-left: 5px;
			[data-xf-click="overlay"]{
				.xf-link();
			}
			&:hover{
				[data-xf-click="overlay"]{
					.xf-linkHover();
				}
			}
		}
	}
}';
	return $__finalCompiled;
}
);