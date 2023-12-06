<?php
// FROM HASH: 7e31b14264406b85939bc0fba1178f88
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

<style>
.p-body-section{
		margin-bottom:0 !important;
	}
#container
{

height: auto;
overflow: hidden;
margin: 0 auto;
position: relative;
margin-bottom:20px;
}
#list-container
{
overflow: hidden;
width: 100%;
float: left;
}
.list
{

min-width: 3400px;
float: left;
display: flex;
}
	
#arrowL::before,#arrowR::before{
    font-family: "Font Awesome 5 Pro";
    content: "\\f053";
    background: #fff;
    border-radius: 50%;
  
    color: #2196f3;
    display: block;
    font-size: 20px;
    font-weight: bold;
    height: 40px;
    line-height: 40px;
    opacity: 1;
    width: 40px;
    text-align: center;
}



#arrowR::before {
    font-family: "Font Awesome 5 Pro";
    content: "\\f054";
}	
	
	
#arrowR
{
background: transparent;
width: 40px;
height: 40px;
border-radius: 50%;
float: right;
cursor: pointer;
top: 126px;
text-align: center;
font-family: Arial;
font-size: 0px;
color: transparent;
padding:2px 2px;
position: absolute;
z-index: 100;
right: 20px;

display: block;
line-height: 0px;
font-size: 0px;
padding: 0;
border: none;
outline: none;
}
#arrowL
{
top: 145px;
left: 9px;
background: transparent;
width: 40px;
height: 40px;
float: left;
cursor: pointer;
text-align: center;
font-family: Arial;
color: transparent;
position: absolute;
z-index: 100;
border-radius: 50%;
cursor: pointer;
display: block;
line-height: 0px;
font-size: 0px;
-webkit-transform: translate(0, -50%);
padding: 0;
border: none;
outline: none;
}
.item
{
width: 350px;
height: 350px;
margin: 0 30px 0 0;
float: left;
position: relative;
text-align: center;
font-family: Arial;
font-size: 20px;
color: White;
}

div.item iframe{
width: 100%;
height: 100%;
}
div.p-body-section div.p-body-section-header span.p-body-section-icon i.fa-gamepad-alt.screen-icon:before {
content: "\\f108" !important;
}


/* MEDIA QUERIES.............
MEDIA QUERIES.............
MEDIA QUERIES............. */

@media only screen and (max-width: 600px) {
#container{
width: 100%;
}
	.item{
		    margin: 0 15px 0 15px;
	}
}


</style>

<br>

<div class="p-body-section">
<div class="p-body-section-header">
		<span class="p-body-section-icon">
			<i class="fas fa-gamepad-alt screen-icon"></i>
		</span>
		<span class="p-body-section-title" id="highlights">
			<span>' . 'Latest_tournament_highlights' . '</span>
		</span>
		<span class="p-body-section-view-more">
			<a href="' . $__templater->func('base_url', array('tournament-results', ), true) . '">' . 'View more' . ' <i class="fas fa-chevron-right"></i></a>
		</span>
		
	</div>
</div>


<div id="container">
	
<div id="arrowL" class="left_glitchvideo" style="">
<i class="fa fa-chevron-left"></i>
</div>
<div id="arrowR" class="right_glitchvideo"  style="">
<i class="fa fa-chevron-right"></i>
</div>	
	
<div id="list-container">
	
' . '
	
		<div class=\'list glitchvideo\' style="">


		<div class=\'item\'>
			<img
            src="https://images.unsplash.com/photo-1643148636637-58b3eb95cdad?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHx8MTY0MzM5ODg0OA&ixlib=rb-1.2.1&q=80&w=400"
            alt="">
		</div>
		<div class=\'item\'>
			<img
            src="https://images.unsplash.com/photo-1643039952431-38adfa91f320?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHx8MTY0MzM5ODg0OA&ixlib=rb-1.2.1&q=80&w=400"
            alt="">
		</div>
		<div class=\'item\'>
			<img
            src="https://images.unsplash.com/photo-1640808238224-5520de93c939?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHx8MTY0MzM5ODg4OQ&ixlib=rb-1.2.1&q=80&w=400"
            alt="">
		</div>
		<div class=\'item\'>
			<img
            src="https://images.unsplash.com/photo-1642034451735-2a8df1eaa2c0?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwxNDU4OXwwfDF8cmFuZG9tfHx8fHx8fHx8MTY0MzM5ODg4OQ&ixlib=rb-1.2.1&q=80&w=400"
            alt="">
		</div>

		</div>


</div>
	
</div>

<br>

';
	$__templater->inlineJs('

	$(document).ready(function(){
            $(".right_glitchvideo").click(function(){
                var item_width = $(\'#list-container div.glitchvideo div.item\').width(); 
                var left_value = item_width * (-1); 
                var left_indent = parseInt($(\'#list-container div.glitchvideo\').css(\'left\')) - item_width;
                $(\'#list-container div.glitchvideo \').animate({\'left\' : left_indent}, 100, function () {
                $(\'#list-container div.glitchvideo div.item:last\').after($(\'#list-container div.glitchvideo div.item:first\'));                  
                $(\'#list-container div.glitchvideo\').css({\'left\' : left_value});
            });
            });

            $(".left_glitchvideo").click(function(){
                var item_width = $(\'#list-container div.glitchvideo div.item\').width(); 
                var right_value = item_width * (+1); 
                var right_indent = parseInt($(\'#list-container div.glitchvideo\').css(\'right\')) + item_width;
                $(\'#list-container div.glitchvideo \').animate({\'right\' : right_indent}, 100, function () {
                $(\'#list-container div.glitchvideo div.item:first\').before($(\'#list-container div.glitchvideo div.item:last\'));                  
                $(\'#list-container div.glitchvideo\').css({\'right\' : right_value});
            });
            });
        });

');
	$__finalCompiled .= '


';
	return $__finalCompiled;
}
);