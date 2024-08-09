<?php
// FROM HASH: dd9a63ec6c4098a5f739b9073dff84e9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.filterSelectionContainer {
  span.select2-container {
    margin-left: 0 !important;
    -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
    -khtml-user-select: none; /* Konqueror HTML */
    -moz-user-select: none; /* Old versions of Firefox */
    -ms-user-select: none; /* Internet Explorer/Edge */
    user-select: none;
  }

  &.multipleSelectionContainer {
    span.select2-container {
      padding: 0 !important;
    }
  }

  &.singleSelectionContainer {
    span.select2-container.input {
      padding-right: 1em !important;
      background-size: 1em !important;
      background-repeat: no-repeat !important;
      -ltr-background-position: 100% !important;
      white-space: nowrap;
      word-wrap: normal;
      -webkit-appearance: none !important;
      -moz-appearance: none !important;
      appearance: none !important;
      -xf-select-gadget: xf-default(@xf-input--color, @xf-textColor);
    }
  }
}

.select2-dropdown.customFieldSelectionPopup {
  .select2-results__options {
    max-height: 300px;
  }
}

.select2-dropdown.customFieldSelectionPopup {
  .select2-search {
    min-width: 180px !important;
    display: block;
    input {
      width: 100%;
    }
  }

  .select2-results__options {
    max-width: 100%;

  }
}

@media (max-width: @xf-formResponsive) {
  span.input {
    width: 100% !important;
  }
}
';
	return $__finalCompiled;
}
);