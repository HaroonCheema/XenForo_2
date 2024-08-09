<?php
// FROM HASH: aba97d7afbf8f9c976df76d6ec7b891c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= 'div.structItem-cell {
    &.structItem-cell--fieldColumn {
        width: 120px;
        dd {
            div {
                display: inline;
            }
        }
    }

    .structItem-minor.structItem-minor--fieldList {
        float: none;
        .structItem-parts {
            display: block;
        }
    }
}

.contentRow-minor--hideLinks {
    li {
        .colorChip {
            top: 4px;
            position: relative;
        }
    }
}

@media (max-width: @xf-responsiveWide) {
    div.structItem-cell {
        &.structItem-cell--fieldColumn {
            font-size: @xf-fontSizeSmaller;
        }
    }
}

@media (max-width: @xf-responsiveMedium) {
    div.structItem-cell {
        &.structItem-cell--fieldColumn {
            display: block;
            width: 100%;
            float: none;
            padding-top: 0;
            padding-left: 0;
            color: @xf-textColorMuted;
            .pairs {
                > dt,
                > dd {
                    display: inline;
                    float: none;
                    margin: 0;

                    .colorChip {
                        top: 4px;
                        position: relative;
                    }
                }
            }
        }
    }
}
';
	return $__finalCompiled;
}
);