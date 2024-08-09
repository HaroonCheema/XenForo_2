<?php
// FROM HASH: a75221ce86861e705361cc8f10d3ba5a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['xf']['options']['altf_additional_filters']['lockedUnlockedStatus']) {
		$__finalCompiled .= '
    <div class="menu-row menu-row--separated">
        <label for="ctrl_last_updated">' . 'Discussion status' . $__vars['xf']['language']['label_separator'] . '</label>
        <div class="u-inputSpacer">
            ' . $__templater->formSelect(array(
			'name' => 'is_locked',
			'value' => $__vars['filters']['is_locked'],
			'id' => 'ctrl_last_updated',
		), array(array(
			'value' => '0',
			'label' => 'Any',
			'_type' => 'option',
		),
		array(
			'value' => '-1',
			'label' => 'Open',
			'_type' => 'option',
		),
		array(
			'value' => '1',
			'label' => 'Locked',
			'_type' => 'option',
		))) . '
        </div>
    </div>
';
	}
	return $__finalCompiled;
}
);