<?php
// FROM HASH: 35c976f2463ebad2c97cb7921b3477d7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.porta-article .message .message-body
{
	margin: 10px;
}

.porta-listInline-left { float: left; }
.porta-listInline-right { float: right; }
.porta-category-form li { display: inline-flex; min-width: 240px; }

.p-body-header:has(+ .p-body-main--withSidebar) .porta-listInline-right
{
	margin-right: ~"calc(@xf-sidebarWidth + @xf-pageEdgeSpacer)"; 
}

.porta-author-block
{
	.contentRow-main { margin-right: 10px; }
	
	.porta-author-byline { margin-top: 10px; }
	.porta-author-byline, .porta-author-byline div { display: block; }
	.porta-author-image.contentRow-figure
	{
		.xf-messageUserBlock(no-border);
		border-right: @xf-messageUserBlock--border-width solid @xf-messageUserBlock--border-color;
		
		padding: 10px;
		width: 170px;
	}

	.porta-author-icon
	{
		float: right;
		padding-right: 10px;
	}
}

.porta-block-icon
{
	.xf-messageUserBlock;
	display: grid;
	float: right;
	margin-left: 10px;
	max-width: 60%;
	padding: 10px;
	
	>a { display: grid; }
}

.porta-widgets-split
{
	display: flex;
	flex-wrap: wrap;
	align-items: stretch;
	margin: 0 -((@xf-pageEdgeSpacer) / 2) 0;
	width: auto;

	> *
	{
		margin: 0 ((@xf-pageEdgeSpacer) / 2) @xf-elementSpacer;
		min-width: @xf-sidebarWidth;
		flex: 1 1 @xf-sidebarWidth;
	}

	.block-container
	{
		display: flex;
		flex-direction: column;
		height: 100%;

		.block-footer
		{
			margin-top: auto;
		}
	}
}

@media (max-width: @xf-responsiveWide)
{
	.porta-listInline-right { margin-right: 0; }
}

@media (max-width: @xf-responsiveEdgeSpacerRemoval)
{
	.porta-widgets-split
	{
		display: block;
		margin-left: 0;
		margin-right: 0;

		> *
		{
			margin-left: 0;
			margin-right: 0;
			min-width: 0;
		}
	}
}';
	return $__finalCompiled;
}
);