<?php
// FROM HASH: 5cffea40ec670c1d0000a914a4edde18
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
                        <li>
                            ' . $__templater->escape($__vars['fieldDefinition']['title']) . ':
                            ' . $__compilerTemp2 . '
                        </li>
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
    <div class="contentRow-minor contentRow-minor--hideLinks">
        <ul class="listInline listInline--bullet">
            ' . $__compilerTemp1 . '
        </ul>
    </div>
';
	}
	return $__finalCompiled;
}
);