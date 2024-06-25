<?php
// FROM HASH: 79d9fe0bb5f4a2ca74c2c1c87360c27c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.p-breadcrumbs {
	display: none;
}

.DC_LinkProxy {
	max-width: @xf-responsiveMedium;
	padding: 20px;
	margin: 0 auto;
	border: 1px solid @xf-borderColor;
	border-radius: @xf-borderRadiusLarge;
	background: @xf-contentBg;
	
	.DC_LinkProxy__title {
		text-align: center;
		font-size: 2em;
		color: @xf-textColorDimmed;
	}
	
	.DC_LinkProxy__content {
		font-size: 1.05em;
		color: @xf-textColor;
		
		.m-clearFix();
		
		.message
		{
			margin-bottom: 10px;
			
			&.redirecting
			{
				font-weight: 500;
				text-align: center;
				color: @xf-textColorMuted;
			}
		}
		
		.DC_LinkProxy_Continune
		{
			float: right;
		}
	}
}

/** Time Countdown Animation */
.circle {
    width: 100px;
    height: 100px;
    position: relative;
    border-radius: 999px;
    box-shadow: inset 0 0 0 20px @xf-pageBg;
	margin: 1.5em auto;
}

.l-half, .r-half {
    float: left;
    width: 50%;
    height: 100%;
    overflow: hidden;
    
    &:before {
        content: "";
        display: block;
        width: 100%;
        height: 100%;
        box-sizing: border-box;
        border: 20px solid @xf-textColorFeature;
    }
        
}

.l-half:before {
    border-right: none;
    border-top-left-radius: 999px;
    border-bottom-left-radius: 999px;
    -webkit-transform-origin: center right;
    -webkit-animation-name: l-rotate;
}
    
.r-half:before {
    border-left: none;
    border-top-right-radius: 999px;
    border-bottom-right-radius: 999px;
    -webkit-transform-origin: center left;
    -webkit-animation-name: r-rotate;
}

.count {
    position: absolute;
    width: 100%;
    line-height: 100px;
    text-align: center;
    font-weight: 500;
    font-size: 20px;
    color: @xf-textColorFeature;
    z-index: 2;
}
.d-none{
	display:none !important;
}

@-webkit-keyframes l-rotate {
	0% { -webkit-transform: rotate(0deg); }
	50% { -webkit-transform: rotate(-180deg); }
	100% { -webkit-transform: rotate(-180deg); }
}

@-webkit-keyframes r-rotate {
	0% { -webkit-transform: rotate(0deg); }
	50% { -webkit-transform: rotate(0deg); }
	100% { -webkit-transform: rotate(-180deg); }
}

@-webkit-keyframes fadeout {
	0% { opacity: 1; }
	100% { opacity: 0.5; }
}';
	return $__finalCompiled;
}
);