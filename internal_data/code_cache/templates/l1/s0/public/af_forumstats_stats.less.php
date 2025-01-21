<?php
// FROM HASH: af6508462d467a35b03a16b471663774
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.forumStatsContainer
{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
        flex-wrap: wrap;
    -webkit-box-align: stretch;
        -ms-flex-align: stretch;
            align-items: stretch;
    -ms-flex-line-pack: stretch;
        align-content: stretch;
    margin-bottom: 10px;

    a
    {
        cursor: pointer;
    }

    // like 2.0.x
    .avatar
    {
        &.avatar--default
        {
            &.avatar--default--dynamic,
            &.avatar--default--text
            {
                // converts our avatar sized LH to a font sized version which adapts based solely on font-size
                line-height: (@xf-avatarDynamicLineHeight) / ((@xf-avatarDynamicTextPercent) / 100);
            }
        }
    }

    .dataList-cell--forumStats-counter
    {
        color: @xf-afForumStatsCounterColor;
    }
}

.forumStats-sidebar
{
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;
    width: 20%;
    margin-bottom: 0;
    /* flex: 1;*/

    -webkit-box-ordinal-group:2;
        -ms-flex-order:1;
            order:1;

    .block-minorHeader
    {
        .xf-contentAltBase();
        border-bottom-color: @xf-borderColorHeavy;
        border-bottom-width: @xf-borderSize;
        border-bottom-style: solid;
    }

    .tabs--standalone
    {
        padding: 6px 10px 6px;
        margin-bottom: 0;
        border-top-right-radius: 0 !important;
        border-left: 0;
        border-right: 0;
    }

    .block-container
    {
        -webkit-box-flex: 1;
            -ms-flex: 1 0 auto;
                flex: 1 0 auto;
        border-top: 0;
        border-right: 0;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .block-body.block-row
    {
    }

    a
    {
        font-size: @xf-fontSizeNormal;
    }

    // fix main width for sidebar
    .dataList-cell.dataList-cell--main
    {
        min-width: initial;
    }
}
.forumStats-main
{
    width: 80%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
        -ms-flex-direction: column;
            flex-direction: column;

    -webkit-box-ordinal-group:3;
        -ms-flex-order:2;
            order:2;

    .block-container
    {
        -webkit-box-flex: 1;
            -ms-flex: 1 0 auto;
                flex: 1 0 auto;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
        border-top: 0;
    }

    .dataList
    {
        overflow-x: auto;
    }
}

.forumStats-footer
{
    text-align: center;
    -webkit-box-flex: 1;
        -ms-flex: 1;
            flex: 1;
    -webkit-transition: none;
    transition: none;

    -webkit-box-ordinal-group:4;
        -ms-flex-order:3;
            order:3;
}

// fix for some styles that push the auto-refresh input into the next row
.forumStats-shown > .iconic
{
    width: auto !important;
}

.forumStatsContainer.forumStats-shown .forumStats-footer
{
    border-top: 0;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.refreshNow
{
    float: right;
}

.hideForumStats, .showForumStats
{
    float: left;
}

.forumStatsContainer
{
    &.forumStats-shown
    {
        .forumStats-hidden
        {
            display: none;
        }
    }
    &.forumStats-hidden
    {
        margin-bottom: 5px;

        .forumStats-shown
        {
            display: none;
        }
    }
}

// mini mode stuff
@af-fs-avatar-mini-1: @avatar-xxs; // same as XXS
@af-fs-avatar-mini-2: (@_avatarBaseSize) / 5;
@af-fs-avatar-mini-3: (@_avatarBaseSize) / 6;

.forumStatsContainer.forumStats-mini
{
    .dataList-cell
    {
        padding: 0 3px;

        &.dataList-cell--action,
        &.dataList-cell--link
        {
            padding: 0 3px;

            a,
            label,
            .dataList-blockLink
            {
                padding: 0;
            }
        }
    }

    .forumStats-main
    {
        .dataList-cell
        {
            &.dataList-cell--alt,
            &.dataList-cell--link
            {
                .m-overflowEllipsis();
                max-width: 175px;
            }
        }
    }

    .forumStats-sidebar
    {
        .dataList-cell
        {
            &.dataList-cell--alt,
            &.dataList-cell--link
            {
                .m-overflowEllipsis();
                max-width: 100px;
            }
        }
    }

    // default
    .dataList-cell.dataList-cell--imageSmall .avatar,
    .dataList-cell.dataList-cell--imageSmall .avatar > img
    {

		    width: 24px;
			height: 24px;
			font-size: 14px;
    }

    &.forumStats-mini-2
    {
        .dataList-cell.dataList-cell--imageSmall .avatar,
        .dataList-cell.dataList-cell--imageSmall .avatar > img
        {

			    width: 19.2px;
				height: 19.2px;
				font-size: 12px;

        }
    }
    &.forumStats-mini-3
    {
        .dataList-cell.dataList-cell--imageSmall .avatar,
        .dataList-cell.dataList-cell--imageSmall .avatar > img
        {
                width: 16px;
				height: 16px;
				font-size: 10px;
        }
    }
}

@media (max-width: @xf-responsiveWide)
{
    .forumStatsContainer
    {
        display: block !important;
    }
    .forumStats-sidebar
    {
        display: none !important;
    }
    .forumStats-main
    {
        width: 100% !important;
    }
}


@media (max-width: @xf-responsiveEdgeSpacerRemoval)
{
    .forumStatsContainer .tabPanes
    {
        margin-left: -@xf-pageEdgeSpacer;
        margin-right: -@xf-pageEdgeSpacer;
    }
    .forumStatsContainer .forumStats-sidebar .tabs--standalone
    {
        margin-left: 0;
        margin-right: 0;
    }
}

@media (max-width: @xf-responsiveNarrow)
{
    .forumStatsContainer .miniCol
    {
        // width: 100px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 11px;
    }
}';
	return $__finalCompiled;
}
);