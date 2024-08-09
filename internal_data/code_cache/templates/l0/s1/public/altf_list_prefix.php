<?php
// FROM HASH: 01b9cd5908c20c30d31e99c671719bb7
return array(
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
                        ' . $__templater->callMacro('altf_thread_field_column_list', 'custom_field_value', array(
				'definition' => $__vars['fieldDefinition'],
				'value' => $__vars['fieldData'][$__vars['fieldId']],
			), $__vars) . '
                    ';
			if (strlen(trim($__compilerTemp2)) > 0) {
				$__compilerTemp1 .= '
                ';
				$__vars['labelClass'] = $__templater->preEscaped('label label--primary');
				$__compilerTemp1 .= '
                ';
				if ($__vars['fieldDefinition']['match_type'] == 'color') {
					$__compilerTemp1 .= '
                    ';
					$__vars['labelClass'] = $__templater->preEscaped('label label--color');
					$__compilerTemp1 .= '
                ';
				}
				$__compilerTemp1 .= '
                <span class="' . $__templater->escape($__vars['labelClass']) . ' fieldContainer--' . $__templater->escape($__vars['fieldId']) . '">
                    ' . $__compilerTemp2 . '
                </span>
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
    ' . '
    ' . $__compilerTemp1 . '
    ' . '
';
	}
	return $__finalCompiled;
}
);