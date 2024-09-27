<?php
// FROM HASH: e498e6f58bd08f1d2053fa60e6298f04
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@resource-grid-gap: 10px;
@resource-grid-width: 250px;
@resource-grid-thumb: 108px;
@supports(display: grid) {
    body[data-template="fs_xfrm_overview"] {
        .structItemContainer-group,
        .structItemContainer-group--sticky {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(@resource-grid-width, 1fr));
            grid-gap: @resource-grid-gap;
            padding: @resource-grid-gap;
            background-color: @xf-contentAltBg;
        }
        .structItem--thread {
            display: grid;
            grid-template-areas: \'icon icon\' \'main main\' \'meta latest\' \'iconEnd iconEnd\';
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.28);
            border-radius: 5px;
            position: relative;
            .structItem-cell--icon {
                grid-area: icon;
                width: 100%;
                padding: 0px 0px 10px 0px;
                border-radius: 5px 5px 0px 0px;
            }
            .structItem-cell--main {
                grid-area: main;
                margin-top: 5px;
            }
            .structItem-cell--meta {
                grid-area: meta;
                width: 100%;
                position: absolute;
                width: 70px;
                font-size: 13px;
                color: #8c8c8c !important;
            }
            .structItem-cell--latest {
                grid-area: latest;
                width: 100%;
                font-size: 13px;
                white-space: nowrap;
            }
            .structItem-cell--iconEnd {
                padding: 0px 0px 0px 5px !important;
                height: 38px;
            }
        }
        .structItem-cell--meta .pairs--justified dd {
            float: left;
        }
        .structItem-iconContainer .structItem-secondaryIcon {
            position: absolute;
            width: 60px;
            height: 60px;
            font-size: 12px;
            bottom: -20px;
            border: 3px solid #fefefe;
            left: 50%;
            transform: translateX(-50%);
        }
        .structItem-cell--meta .pairs--justified:first-child dd:before {
            font-family: \'Font Awesome 5 Pro\';
            content: "\\f3e5\\20";
            padding-right: 5px;
        }
        .structItem-cell--meta .pairs--justified:last-child dd:before {
            font-family: \'Font Awesome 5 Pro\';
            content: "\\f06e  :";
            padding-right: 5px;
        }
        .structItem-cell--meta .pairs--justified:last-child dt {
            font-size: 0px;
        }
        .structItem-cell--meta .pairs--justified:first-child dt {
            font-size: 0px;
        }
        @media (max-width: 650px) {
            .js-threadList {
                padding: 0px !important;
            }
            .structItem--thread .structItem-cell--main {
                   padding-left: 10px !important;
    				padding-right: 10px;
            }
            .structItem--thread {
                border-radius: 0px !important;
            }
            .structItem-cell.structItem-cell--latest:before {
                display: none;
            }
			.structItem-cell--meta{
				padding-left: 10px !important;
    			padding-right: 10px;
			}
			.structItem-cell--latest{
				 padding-right: 10px;
			}
			.structItem-cell.structItem-cell--iconEnd, .structItem-cell.structItem-cell--meta .structItem-minor, .structItem-cell.structItem-cell--latest .structItem-minor{
				display:block;
			}
			.structItem-cell.structItem-cell--latest{				
    		padding-bottom: 10px;
			}
        }
    }
}';
	return $__finalCompiled;
}
);