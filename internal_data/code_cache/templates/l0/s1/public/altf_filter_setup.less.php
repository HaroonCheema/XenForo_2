<?php
// FROM HASH: e94d568b0cf147385174727a28404164
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '/** CSS used for the filter form independent of its injection point */
// The form element should have relative positioning
form.filterFormElement {
  position: relative;

  .filterOverlay {
    display: none;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.7);
    font-size: 4rem;
    z-index: 10000;

    &.activeOverlay {
      display: flex;
    }
  }
}';
	return $__finalCompiled;
}
);