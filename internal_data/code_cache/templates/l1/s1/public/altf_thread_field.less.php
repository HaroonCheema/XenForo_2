<?php
// FROM HASH: 83c4018b87e74be0f7c0f7df39c38a93
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '.threadFieldContainer {
  .input--date {
    width: 100% !important;
  }
}

.customFieldContainer {
  &--faded {
    opacity: 0.5;
  }

  .customFieldOption--faded {
    opacity: 0.5;
  }

  // Add fixed height to the multiple selection lists that should be converted to a select2 popup
  // via JS to prevent page flickering
  &.filterTemplate--multiselect.customFieldContainer--hasFilterableList {
    &:not(.multipleSelectionContainer) {
      select[multiple] {
        height: 36px;
      }
    }
  }
}

.totalCountIndicator {
  span {
    font-style: italic;
    font-weight: bold;
  }
}';
	return $__finalCompiled;
}
);