<?php
// FROM HASH: d0214825fea1d8f69575f50de0d0323d
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
    height: 100%;
}
	*{
	  margin:0;
	  padding:0;
	  box-sizing: border-box;
	  font-family: Arial, Helvetica, sans-serif;
	}
	.body{
	  background: black;
	  width:100%;
	  height: auto;
	  margin: 0;
	  box-sizing: border-box;
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
	.body-inner{
		width: 100%;
	}
	.container{
	  width: 100%;
	  height:auto;
	}
	.featured-video{
	  width: 100%;
	  height: 500px;
	  margin:0;
	}
	.logo-image{
	  width: 100%;
	  max-width: 215px;
	  margin-left: auto;
	  margin-right: auto;
	  height: auto;
	  margin-top: 10px;
	  margin-bottom: 10px;
	}
	.inner-logo-img{
	  width: 100%;
	height: 40px;
	background:url("styles/What\'s_Best_Audio_Video_Forum/img/xen8-1.png");
	background-repeat: no-repeat;
	background-position: center;
    background-size: cover;
	}
	.text{
	  width:100%;
	  height:auto;
	  max-width: 80%;
	  margin-right: auto;
	  margin-left: auto;
	  margin-top: 10px;
	  margin-bottom: 30px;
	  color:#fff;
	}
	.p1{
	  font-style: italic;
	  margin-top: 20px;
	  margin-bottom: 20px;
	  text-align: center;
	  width: 100%;
	  font-family: system-ui;
	}
	.p2{
	  text-align: center;
	  width: 100%;
	  font-family: system-ui;
	}
	.p3{
	  font-size: 13px;
	  margin-bottom: 10px;
	  text-align: center;
	  width: 100%;
	  font-family: system-ui;
	}
	.text-image{
	  background:#fff;
	  color:black;
	  display:flex;
	padding: 20px;
	}
	.inner-text{
	padding-top: 40px;
    padding-bottom: 40px;
    padding-right: 30px;
    width: 56%;
    font-family: system-ui;
	}
	.textpara{
	  margin-bottom:10px;
	}
	.content-img{
	width: 44%;
    height: fit-content;
    max-height: 500px;
    margin-top: auto;
    margin-bottom: auto;
	}
	.side-img{
	width:100%;
	height: 100%;
	background:url("styles/What\'s_Best_Audio_Video_Forum/img/speakers.jpg");
	background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
	object-fit: contain;
	}
	.video-list{
	 width: 32.80%;
    height: auto;
    margin: 2px 1px 4px 2px;
    padding: 0px 5px;
	  position: relative;
	  display: inline-table;
	}

	.thumbnail{
	  width: 100%;
	  height: 100%;
	  border: 1px solid #fff;
	  border-radius: 2px;
	object-fit: contain;
	}
	.video-title-text {
	  width: 100%;
	  padding: 7px;
	  text-align: center;
	  margin: 2px auto;
	  color: white;
	}
	.video-container{
	  padding: 50px 40px;
	}
	.big-image-box{
	  width: 100%;
	  height: 100%;
	  border-top: 2px solid #fff;
	background:url("styles/What\'s_Best_Audio_Video_Forum/img/sgmextreme.jpg");
	background-position: center;
    background-size: cover;
    border: transparent;
    background-repeat: no-repeat;
	object-fit: contain;
	}
	@media screen and (min-width:1094px) and (max-width:1183px){
	.video-list{
	width:32.75%;
	}
	}
	@media screen and (min-width:1016px) and (max-width:1093px){
	.video-list{
	width:32.70%;
	}
	}
	@media screen and (min-width:950px) and (max-width:1015px){
	.video-list{
	width: 32.65%;
	}
	}
	@media screen and (min-width:803px) and (max-width:949px){
	.video-list{
	width:32.65%;
	margin:2px 1px 4px 1px;
	}
	.video-title-text {
    font-size: 14px;
	}
	}
	@media screen and (min-width:598px) and (max-width:802px){
	.video-container {
    padding: 38px 35px;
	}
	.video-list{
	width: 32.60%;
    margin: 2px 0px 4px 1px;
	}
	.thumbnail{
	height:100%;
	}
	
	}
	@media screen and (min-width:473px) and (max-width:597px){
	.video-container {
    padding: 35px 30px;
	}
	.video-list{
	width:32.40%;
	margin: 2px 0px 4px 1px;
	}
	.thumbnail {
	height:100%;
	}
	}
	@media screen and (min-width:404px) and (max-width:472px){
	.video-container {
    padding: 30px 24px;
	}
	.video-list{
	width:32.20%;
	margin: 2px 0px 4px 1px;
	}
	.thumbnail {
	height:100%;
	}
	}
	@media screen and (min-width:344px) and (max-width:403px){
	.video-container {
    padding: 15px 10px;
	}
	.video-list{
	width:49%;
	margin: 2px 0px 4px 1px;
	}
	.thumbnail {
	height:100%;
	}
	}
	@media screen and (max-width:343px){
	.video-container {
    padding: 15px 10px;
	}
	.video-list{
	width:49%;
	margin: 2px 0px 4px 0px;
	}
	.thumbnail {
	height:100%;
	}
	}
	@media screen and (min-width:701px) and (max-width:900px){
	.featured-video {
    height: 400px;
	}
	.big-image-box{
	height: 400px;
	}
	.logo-image{
	max-width: 200px;
	}
	.text{
	max-width: 75%;
	}
	.inner-text {
	padding-top:35px;
	padding-bottom:35px;
	}
	.side-img{
	height: 215px;
	}
	}
	@media screen and (min-width:551px) and (max-width:700px){
	.featured-video {
    height: 300px;
	}
	.big-image-box{
	height: 300px;
	}
	.logo-image{
	max-width: 185px;
	}
	.text{
	max-width: 72%;
	font-size: 14px;
	}
	.p3{
	font-size:13px;
	}
	.text-image{
	flex-direction: column-reverse;
	}
	.inner-text {
	padding-top: 20px;
    padding-bottom: 20px;
    padding-right: 0px;
    width: 100%;
    font-size: 14px;
	}
	.content-img {
    width: 100%;
    padding-bottom: 0px;
    padding-top: 0px;
	margin-top: 0px;
    margin-bottom: 0px;
	}
	.side-img{
	height: 300px;
	}
	}
	@media screen and (min-width:451px) and (max-width:550px){
	.featured-video {
    height: 200px;
	}
	.big-image-box{
	height: 200px;
	}
	.logo-image{
	max-width: 130px;
	}
	.text{
	max-width: 68%;
	font-size: 13px;
	}
	.p3{
	font-size:11px;
	}
	.text-image{
	flex-direction: column-reverse;
	}
	.inner-text {
	padding-top: 20px;
    padding-bottom: 20px;
    padding-right: 0px;
    width: 100%;
    font-size: 13px;
	}
	.content-img {
    width: 100%;
    padding-bottom: 0px;
    padding-top: 0px;
	margin-top: 0px;
    margin-bottom: 0px;
	}
	.side-img{
	height: 200px;
	}
	}
	@media screen and (min-width:351px) and (max-width:450px){
	.featured-video {
    height: 150px;
	}
	.big-image-box{
	height: 150px;
	}
	.logo-image{
	max-width: 115px;
	}
	.inner-logo-img{
	height:30px;
	}
	.text{
	max-width: 80%;
	font-size: 12px;
	}
	.p3{
	font-size:10px;
	}
	.text-image{
	flex-direction: column-reverse;
	}
	.inner-text {
	padding-top: 20px;
    padding-bottom: 20px;
    padding-right: 0px;
    width: 100%;
    font-size: 12px;
	}
	.content-img {
    width: 100%;
    padding-bottom: 0px;
    padding-top: 0px;
	margin-top: 0px;
    margin-bottom: 0px;
	}
	.side-img{
	height: 150px;
	}
	}
	@media screen and (max-width:350px){
	.featured-video {
    height: 100px;
	}
	.big-image-box{
	height: 100px;
	}
	.logo-image{
	max-width: 115px;
	}
	.inner-logo-img{
	height:30px;
	}
	.text{
	max-width: 80%;
	font-size: 12px;
	}
	.p3{
	font-size:10px;
	}
	.text-image{
	flex-direction: column-reverse;
	}
	.inner-text {
	padding-top: 20px;
    padding-bottom: 20px;
    padding-right: 0px;
    width: 100%;
    font-size: 12px;
	}
	.content-img {
    width: 100%;
    padding-bottom: 0px;
    padding-top: 0px;
	margin-top: 0px;
    margin-bottom: 0px;
	}
	.side-img{
	height: 100px;
	}
	}
	
	' . '
	@media screen and (min-width:701px) and (max-width:800px){
	.video-title-text{
	font-size: 14px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 180px;
	}
	}
	@media screen and (min-width:601px) and (max-width:700px){
	.video-title-text{
	font-size: 14px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 156px;
	}
	}
	@media screen and (min-width:501px) and (max-width:600px){
	.video-title-text{
	font-size: 13px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 126px;
	}
	}
	@media screen and (min-width:401px) and (max-width:500px){
	.video-title-text{
	font-size: 13px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 97px;
	}
	}
	@media screen and (min-width:301px) and (max-width:400px){
	.video-title-text{
	font-size: 12px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 103px;
	}
	}
	@media screen and (max-width:300px){
	.video-title-text{
	font-size: 12px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    width: 92px;
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

   <div class="body">
    <div class="navbar">
    <div class="nav-inner">
        <a href="' . $__templater->func('link', array('videos', ), true) . '">Latest Added</a>
        <a href="' . $__templater->func('link', array('rons', ), true) . '" style="border-right:1px solid black;" >Ron\'s Interviews</a>
        <div class="subnav" style="background:#fff;color:black;">
          <button class="subnavbtn" style="background:#fff;color:black;border-left:1px soild black;" >Audio Brand Videos<i class="fa fa-caret-down"></i></button>
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
    <div class="body-inner">
      <div class="container">
        <iframe class="featured-video" src="' . $__templater->escape($__vars['brand']['feature_embed']) . '?controls=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	  </div>
      <div class="container">
        <div class="logo-image">
          <img class="inner-logo-img" src="' . $__templater->escape($__vars['logo']) . '">
        </div>
        <div class="text">
          <p class="p1">
           ' . $__templater->escape($__vars['intro']) . '
          </p>
        
        </div>
      </div>
      <div class="container">
        <div class="text-image">
          <div class="inner-text">
            <p class="textpara">
             ' . $__templater->escape($__vars['desc']) . '
            </p>
            
          </div>
          <div class="content-img">
            <img class="side-img" src="' . $__templater->escape($__vars['side']) . '">
          </div>
        </div>
      </div>
      <div class="container">
        <div class="video-container">
			';
	if ($__templater->isTraversable($__vars['iframes'])) {
		foreach ($__vars['iframes'] AS $__vars['function']) {
			$__finalCompiled .= '
			
          <div class="video-list">
            <a class="bla-1" href="' . $__templater->func('iframUrl', array($__vars['function'], ), true) . '">
            <img class="thumbnail" src="' . $__templater->func('get_vpthumbnail', array($__vars['function']['thumbNail'], ), true) . '">
          </a>
			  <div class="video-title-text">
                ' . $__templater->escape($__vars['function']['iframe_title']) . '
            </div>
          </div>
        
        ';
		}
	}
	$__finalCompiled .= '
       
         
         	 ' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => $__vars['link'],
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
          
        </div>
      </div>
      <div class="container">
        <img class="big-image-box" src="' . $__templater->escape($__vars['brand_img']) . '">
      </div>
    </div>
  </div>';
	return $__finalCompiled;
}
);