<?php
// FROM HASH: 64dfc8b77f27d8fcbc85ee4982dbbaa5
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
';
	$__templater->includeJs(array(
		'src' => 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js',
	));
	$__finalCompiled .= '


';
	$__templater->inlineCss('
		@charset "UTF-8";

' . '
.p-body-header .p-title h1
{
	display: none;
}
	
.YouTubePopUp-Wrap{
    position:fixed;
    width:100%;
    height:100%;
    background-color:#000;
    background-color:rgba(0,0,0,0.8);
    top:0;
    left:0;
    z-index:9999999999999;
}

.YouTubePopUp-animation{
    opacity: 0;
    -webkit-animation-duration: 0.5s;
    animation-duration: 0.5s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
    -webkit-animation-name: YouTubePopUp;
    animation-name: YouTubePopUp;
}

@-webkit-keyframes YouTubePopUp {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}

@keyframes YouTubePopUp {
    0% {
        opacity: 0;
    }

    100% {
        opacity: 1;
    }
}

body.logged-in .YouTubePopUp-Wrap{ /* For WordPress */
    top:32px;
    z-index:99998;
}

.YouTubePopUp-Content{
    max-width: 846px;
    display:block;
    margin:0 auto;
    height:100%;
    position:relative;
}

.YouTubePopUp-Content iframe{
    max-width:100% !important;
    width:100% !important;
    display:block !important;
    height:480px !important;
    border:none !important;
    position:absolute;
    top: 0;
    bottom: 0;
    margin: auto 0;
}
	.video-title-text {
	  width: 100%;
	  padding: 7px;
	  text-align: center;
	  margin: 2px auto;
	  color: white;
	}
.YouTubePopUp-Hide{
    -webkit-animation-duration: 0.5s;
    animation-duration: 0.5s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
    -webkit-animation-name: YouTubePopUpHide;
    animation-name: YouTubePopUpHide;
}

@-webkit-keyframes YouTubePopUpHide {
    0% {
        opacity: 1;
    }

    100% {
        opacity: 0;
    }
}

@keyframes YouTubePopUpHide {
    0% {
        opacity: 1;
    }

    100% {
        opacity: 0;
    }
}

.YouTubePopUp-Close{
    position:absolute;
    top:0;
    cursor:pointer;
    bottom: 475px;
    right: -57px;
    margin:auto 0;
    width:24px;
    height:24px;
    background:url("styles/img/close.png") no-repeat;
    background-size:24px 24px;
    -webkit-background-size:24px 24px;
    -moz-background-size:24px 24px;
    -o-background-size:24px 24px;
}

.YouTubePopUp-Close:hover{
    opacity:0.5;
}

@media all and (max-width: 1050px) and (min-width: 10px){
    .YouTubePopUp-Close{
        bottom:550px;
        right:0px
    }
    .YouTubePopUp-Content {
        max-width: 85%;
    }
}
@media all and (max-width: 768px) and (min-width: 10px){
    .YouTubePopUp-Content{
        max-width:90%;
    }
}

@media all and (max-width: 600px) and (min-width: 10px){
    .YouTubePopUp-Content iframe{
        height:320px !important;
    }

    .YouTubePopUp-Close{
        bottom:362px;
    }
}

@media all and (max-width: 480px) and (min-width: 10px){
    .YouTubePopUp-Content iframe{
        height:220px !important;
    }

    .YouTubePopUp-Close{
        bottom:262px;
        right:0px
    }
}	
.p-body-inner{
    max-width: 1200px;
	}
	.thumbnail{
    width:100%;
    object-fit: contain;
}
	*{
  margin:0;
  padding:0;
  box-sizing: border-box;
  font-family: Arial, Helvetica, sans-serif;
}
.body{
  width:100%;
  height: auto;
  margin: 0;
  padding: 5px 25px;
  box-sizing: border-box;
  background: black;
}
.body-inner{
  width: 100%;
  margin: 10px auto;
  padding: 10px;
	' . '
	background: #2d2b2b
    
}
.navbar {
	  overflow: hidden;
	 color: #fff;
	  border-bottom: 2px solid;
	  background: rgb(19 18 18);
	  transition: ease-in .15s all;
	}

	.nav-inner {
	  max-width: 800px;
		margin-left: auto;
		margin-right: auto;
		width: fit-content;
		transition: max-width .2s;
		height: 43px;
		display: flex;
		align-items: center;
		text-decoration: none;
	}
	.nav-inner a {
		color:rgba(255,255,255,0.7);
		text-decoration: none;
		color:#fff;
		 padding: 12px 16px;
	}

	.subnav {
	  float: left;
	  overflow: hidden;
	}

	.subnav .subnavbtn {  
	  border: none;
	  outline: none;
	  color: white;
	  padding: 12px 16px;
	  background-color: inherit;
	  font-family: inherit;
	  margin: 0;

	}

	.navbar a:hover, .subnav:hover .subnavbtn {
	  background-color: #fff;
	  color:black;
	}

	.subnav-content {
	   display: none;
		background-color: black;
		width: 11.60em;
		z-index: 1;
		position: absolute;
	}

	.subnav-content a {
		 color: white;
		text-decoration: none;
		display: block;
	padding: 10px 0px 5px 10px;
	}

	.subnav-content a:hover {
	  background-color: #eee;
	  color: black;
	}

	.subnav:hover .subnav-content {
	  display: block;
	}


.container{
	min-width: 19%;
	max-width: 19%;
    height: auto;
    position: relative;
    display: inline-grid;
}


.title-text {
  width: 100%;
  padding: 2px;
  margin: 2px auto;
  color: white;
	margin-bottom: 5px;
}
@media screen and (min-width:978px) and (max-width:1177px){
	.container{
	margin: 2px 0px 4px 1px;
	}
	}
@media screen and (min-width:934px) and (max-width:977px){
	.container{
	width: 24.5%;
	margin: 2px 0px 4px 1px;
	}
}
@media screen and (min-width:834px) and (max-width:933px){
	.container{
	 width: 24.5%;
     margin: 2px 0.5px 4px 0px;
	}
}
@media screen and (min-width:734px) and (max-width:833px){
	.container{
	 width: 24.5%;
     margin: 2px 0px 4px 0px;
	}
}
@media screen and (min-width:601px) and (max-width:733px){
	.container{
	 width: 24%;
     margin: 2px 0px 4px 2px;
	}
}
@media screen and (min-width:523px) and (max-width:600px){
	.container{
	 width: 32%;
     margin: 2px 0px 4px 3px;
	}
}
@media screen and (min-width:448px) and (max-width:522px){
	.container{
	 width: 32%;
     margin: 2px 0px 4px 2px;
	}
	
}
@media screen and (min-width:380px) and (max-width:447px){
	.container{
	 width: 31%;
     margin: 2px 1px 4px 3px;
	}
}
@media screen and (min-width:301px) and (max-width:379px){
	.container{
	width: 47.12%;
    margin: 2px 1px 4px 3px;
	}
}
@media screen and (max-width:300px){
	.container{
	width: 97%;
    margin: 2px 1px 4px 3px;
	}
}
	' . '
	@media screen and (min-width:701px) and (max-width:800px){
	.title-text{
	font-size: 14px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 141px;
	}
	}
	@media screen and (min-width:601px) and (max-width:700px){
	.title-text{
	font-size: 14px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 123px;
	}

	}
	@media screen and (min-width:501px) and (max-width:600px){
	.title-text{
	font-size: 13px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 132px;
	}

	}
	@media screen and (min-width:401px) and (max-width:500px){
	.title-text{
	font-size: 13px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 96px;
	}

	}
	@media screen and (min-width:380px) and (max-width:400px){
	.title-text{
	font-size: 12px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 90px;
	}

	}
	@media screen and (min-width:301px) and (max-width:379px){
	.title-text{
	font-size: 12px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 99px;
	}

	}
	@media screen and (max-width:300px){
	.title-text{
	font-size: 12px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 184px;
	}

	}
	' . '
	@media screen and (min-width:501px) and (max-width:600px){
	.nav-inner a{
	padding: 12px 13px;
	}
	.subnav .subnavbtn{
	padding: 12px 13px;
	}
	.subnav-content{
	width: 11.15em;
	}
	}
	@media screen and (min-width:401px) and (max-width:500px){
	.nav-inner a{
	padding: 12px 5px;
    	font-size: 14px;
	}
	.subnav .subnavbtn{
	padding: 12px 5px;
    	font-size: 14px;
	}
	.subnav-content{
	width: 9.50em;
	}
	}
	@media screen and (min-width:301px) and (max-width:400px){
	.nav-inner a{
	padding: 8px 4px;
    	font-size: 11px;
	}
	.subnav .subnavbtn{
	padding: 8px 4px;
    	font-size: 11px;
	}
	.subnav-content{
	width: 7.5em;
	}
	.nav-inner {
	height: 31px;
	}
	}
	@media screen and (max-width:300px){
	.nav-inner a{
	padding: 8px 4px;
    	font-size: 10px;
	}
	.subnav .subnavbtn{
	padding: 8px 4px;
    	font-size: 10px;
	}
	.subnav-content{
	width: 6.9em;
	}
	.nav-inner {
	height: 31px;
	}
	}
.featured-video {
    width: 100%;
    height: 500px;
    margin: 0;
}	

');
	$__finalCompiled .= ' 
';
	$__templater->inlineJs('
     $(document).ready(function () {
            
    	         jQuery(\'a.bla-1\').magnificPopup({
                type: \'iframe\'
            });
	
            });
');
	$__finalCompiled .= '
<div class="navbar">
			<div class="nav-inner">
		  <a href="' . $__templater->func('link', array('videos', ), true) . '">Latest Added</a>
		  <a href="' . $__templater->func('link', array('Rons', $__vars['rons'], ), true) . '" style="background:#fff;color:black;border-left: 1px solid black;
    border-right: 1px solid black;">Ron\'s Interviews</a>
	      <div class="subnav" >
		    <button class="subnavbtn" >Audio Brand Videos<i class="fa fa-caret-down"></i></button>
		      <div class="subnav-content">
				  ';
	if ($__templater->isTraversable($__vars['video'])) {
		foreach ($__vars['video'] AS $__vars['function']) {
			$__finalCompiled .= '
		        <a href="' . $__templater->func('link', array('brand', $__vars['function'], ), true) . '">' . $__templater->escape($__vars['function']['video_feature']) . '</a>
          ';
		}
	}
	$__finalCompiled .= '
                </div>
		  </div>
	  </div>
	</div>
    <div class="body">
		
			';
	if (!$__templater->test($__vars['featurevideo'], 'empty', array())) {
		$__finalCompiled .= '
		<div id="mainPlayer" data-activethumb="0">
			 <p id="promptText">
			 	<iframe  class="featured-video" src="' . $__templater->escape($__vars['featurevideo']['feature_embed']) . '?rel=0&controls=0"  style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			 </p>
		</div>
	';
	}
	$__finalCompiled .= '
		
		
		
    <div class="body-inner">
	';
	if ($__templater->isTraversable($__vars['rons'])) {
		foreach ($__vars['rons'] AS $__vars['ron']) {
			$__finalCompiled .= '
    <div class="container">
    <a class="bla-1" href="' . $__templater->func('iframUrl', array($__vars['ron'], ), true) . '">
    <img class="thumbnail" src="' . $__templater->func('get_vpthumbnail', array($__vars['ron']['thumbNail'], ), true) . '">
			  <div class="video-title-text">
      ' . $__templater->escape($__vars['ron']['iframe_title']) . '
    </div>
    </a>

  </div>
 
  ';
		}
	}
	$__finalCompiled .= '
	  ' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'rons',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
  

  
  
  
 
  
  
   
  </div>
</div>';
	return $__finalCompiled;
}
);