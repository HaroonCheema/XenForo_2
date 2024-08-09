<?php
// FROM HASH: 1629b89b98ce19446964cc489b63d54e
return array(
'macros' => array('filter_value' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'info' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	if ($__vars['info']['phrase_text']) {
		$__finalCompiled .= '
        ' . $__templater->escape($__vars['info']['phrase_text']) . '
        ';
	} else if ($__vars['info']['phrase']) {
		$__finalCompiled .= '
        ' . $__templater->filter($__templater->method($__vars['info']['phrase'], 'render', array('raw', )), array(array('raw', array()),), true) . '
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__vars['info']['template']) {
		$__finalCompiled .= '
        ' . $__templater->callMacro(null, 'filter_value_' . $__vars['info']['template'], array(
			'info' => $__vars['info'],
		), $__vars) . '
    ';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'filter_value_location' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'info' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ' . $__templater->callMacro('allf_custom_fields_macros', 'filter_value_location', array(
		'info' => $__vars['info'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'filter_value_color' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'info' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    <span class="color-block" style="color: ' . $__templater->escape($__vars['info']['templateParams']['color']) . '; background-color: ' . $__templater->escape($__vars['info']['templateParams']['backgroundColor']) . ';">' . $__templater->escape($__vars['info']['title']) . '</span>
';
	return $__finalCompiled;
}
),
'filter_value_stars' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'info' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ' . $__templater->callMacro('rating_macros', 'rating', array(
		'readOnly' => 'true',
		'currentRating' => $__vars['info']['templateParams']['stars'],
		'deselectable' => 'false',
		'row' => false,
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'filter_value_selection' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'info' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    <ul class="listInline listInline--comma listInline--selfInline">
        ';
	if ($__templater->isTraversable($__vars['info']['templateParams']['options'])) {
		foreach ($__vars['info']['templateParams']['options'] AS $__vars['selection']) {
			$__finalCompiled .= '
            <li>' . $__templater->escape($__vars['selection']) . '</li>
        ';
		}
	}
	$__finalCompiled .= '
    </ul>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
';
	$__vars['additionalFieldInfo'] = ($__vars['additionalFieldInfo'] ? $__vars['additionalFieldInfo'] : $__vars['__globals']['additionalFieldInfo']);
	$__finalCompiled .= '
';
	if ($__vars['additionalFieldInfo']) {
		$__finalCompiled .= '
    ';
		if ($__templater->isTraversable($__vars['additionalFieldInfo'])) {
			foreach ($__vars['additionalFieldInfo'] AS $__vars['fieldId'] => $__vars['activeFilterInfo']) {
				$__finalCompiled .= '
        ';
				$__vars['fieldId'] = ($__vars['activeFilterInfo']['field_name'] ? $__vars['activeFilterInfo']['field_name'] : $__vars['fieldId']);
				$__finalCompiled .= '
        <li class="filter-field-' . $__templater->escape($__vars['activeFilterInfo']['field_type']) . ' filter-match-' . $__templater->escape($__vars['activeFilterInfo']['match_type']) . '">
            <a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('thread_fields_array_sub_replace', array('thread_fields', $__vars['fieldId'], null, $__vars['activeFilterInfo']['sub_item_id'], )),), false), ), true) . '"
               class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
                ';
				if ($__vars['activeFilterInfo']['showLabel']) {
					$__finalCompiled .= '
                    <span class="filterBar-filterToggle-label">' . $__templater->escape($__vars['activeFilterInfo']['title']) . '</span>
                ';
				}
				$__finalCompiled .= '
                ' . $__templater->callMacro(null, 'filter_value', array(
					'info' => $__vars['activeFilterInfo'],
				), $__vars) . '
            </a>
        </li>
    ';
			}
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__vars['filters']['is_locked']) {
		$__finalCompiled .= '
    <li><a href="' . $__templater->func('link', array('forums', $__vars['forum'], $__templater->filter($__vars['filters'], array(array('replace', array('is_locked', null, )),), false), ), true) . '"
           class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
        <span class="filterBar-filterToggle-label">' . 'Discussion status' . $__vars['xf']['language']['label_separator'] . '</span>
        ' . (($__vars['filters']['is_locked'] === 1) ? 'Locked' : 'Open') . '</a></li>
';
	}
	$__finalCompiled .= '

' . '
' . '
' . '
' . '
' . '
';
	return $__finalCompiled;
}
);