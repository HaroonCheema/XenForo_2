<?php
// FROM HASH: 81f07e9e7c1c43d90f75b74a45d0ac64
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
                        <li class="fieldContainer--' . $__templater->escape($__vars['fieldId']) . '">
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
    <div class="structItem-minor structItem-minor--fieldList">
        <ul class="structItem-parts">
            ' . $__compilerTemp1 . '
        </ul>
    </div>
';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
);