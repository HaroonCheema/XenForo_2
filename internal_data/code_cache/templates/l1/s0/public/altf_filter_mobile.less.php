<?php
// FROM HASH: c144fb87c0efa2e4acc756c3117e01c9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '@_nav-elTransitionSpeed: @xf-animationSpeed;
@_navAccount-hPadding: @xf-paddingLarge;

.p-navgroup-link {
  &.p-navgroup-link--filter {
    display: none;

    i:after {
      .m-faContent(@fa-var-filter, .5em);
    }
  }
}

.p-filter-link {
  display: none;
  float: right;

  &:hover {
    text-decoration: none;
    background: xf-intensify(@xf-publicHeaderAdjustColor, 5%);
  }

  &.is-menuOpen {
    .xf-publicNavTabMenuOpen();
    .m-dropShadow(0, 5px, 10px, 0, .35);
    opacity: 1;
  }

  &.p-filter-link--iconic {
    .p-filter-linkText {
      display: none;
    }

    i:after {
      .m-faBase();
      display: inline-block;
      min-width: 1.2em;
      text-align: center;
    }
  }

  &.p-filter-link--filter {
    i:after {
      .m-faContent(@fa-var-filter, .5em);
    }
  }
}

@media (max-width: @xf-publicNavCollapseWidth) {
  .has-js {
    .block.filterAboveThreadList,
    .block.filterSideBar {
      display: none;
    }

    .p-navgroup-link {
      &.p-navgroup-link--filter {
        display: inline-block;
      }
    }

    .offCanvasMenu--nav .offCanvasMenu-content a.button--clear-filter {
      color: @xf-buttonPrimary--color;
    }

    .p-filter-link {
      display: inline-block;
    }

    .block-filterBar {
      .filterBar-menuTrigger {
        overflow: hidden;
        visibility: hidden;
        display: block;
        width: 0;
      }

      .p-filter-link {
        border-left: none;
        float: right;
        padding: 0;
      }
    }
  }
}

.js-headerOffCanvasFilter {
  .menu-footer {
    background: inherit !important;
  }
}';
	return $__finalCompiled;
}
);