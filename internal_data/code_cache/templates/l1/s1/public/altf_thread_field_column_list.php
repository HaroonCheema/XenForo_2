<?php
// FROM HASH: c5f499ce14a8b528436dd92f8189b0b9
return array(
'macros' => array('custom_field_value' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'definition' => '!',
		'value' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	if ($__vars['definition']['field_type'] == 'stars') {
		$__finalCompiled .= '
        ' . $__templater->callMacro('rating_macros', 'stars', array(
			'rating' => ((!$__templater->func('empty', array($__vars['value']))) ? $__vars['value'] : 0),
		), $__vars) . '
        ';
	} else {
		$__finalCompiled .= '
        ';
		if ($__vars['definition']['match_type'] == 'date') {
			$__finalCompiled .= '
            ' . $__templater->callMacro('custom_fields_macros', 'custom_field_value_date', array(
				'date' => $__vars['value'],
			), $__vars) . '
            ';
		} else if ($__vars['definition']['match_type'] == 'color') {
			$__finalCompiled .= '
            ';
			if ($__vars['value']) {
				$__finalCompiled .= '
                ' . $__templater->callMacro('custom_fields_macros', 'custom_field_value_color', array(
					'color' => $__vars['value'],
				), $__vars) . '
            ';
			}
			$__finalCompiled .= '
            ';
		} else {
			$__finalCompiled .= '
            ' . $__templater->filter($__templater->method($__vars['definition'], 'getFormattedValueForColumn', array($__vars['value'], )), array(array('raw', array()),), true) . '
        ';
		}
		$__finalCompiled .= '
    ';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('altf_thread_field_column_list.less');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
                ';
	if ($__templater->isTraversable($__vars['columnList'])) {
		foreach ($__vars['columnList'] AS $__vars['fieldId'] => $__vars['fieldDefinition']) {
			$__compilerTemp1 .= '
                    ';
			$__compilerTemp2 = '';
			$__compilerTemp2 .= '
                                ' . $__templater->callMacro(null, 'custom_field_value', array(
				'definition' => $__vars['fieldDefinition'],
				'value' => $__vars['fieldData'][$__vars['fieldId']],
			), $__vars) . '
                            ';
			if (strlen(trim($__compilerTemp2)) > 0) {
				$__compilerTemp1 .= '
                        <dt class="fieldLabel--' . $__templater->escape($__vars['fieldId']) . '">
                            ' . $__templater->escape($__vars['fieldDefinition']['title']) . '
                        </dt>
                        <dd class="fieldValue--' . $__templater->escape($__vars['fieldId']) . '">
                            ' . $__compilerTemp2 . '
                        </dd>
                    ';
			}
			$__compilerTemp1 .= '
                ';
		}
	}
	$__compilerTemp1 .= '
            ';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
    <div class="structItem-cell structItem-cell--fieldColumn">
        <dl class="pairs pairs--justified fieldContainer">
            ' . $__compilerTemp1 . '
        </dl>
    </div>
';
	}
	$__finalCompiled .= '

' . '
';
	return $__finalCompiled;
}
);