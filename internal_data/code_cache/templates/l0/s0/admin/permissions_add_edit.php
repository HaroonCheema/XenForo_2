<?php
// FROM HASH: f502411836fb6ad02477e59e1408b187
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Permissions' . $__vars['xf']['language']['label_separator'] . ' [' . $__templater->escape($__vars['bbCode']['bb_code_id']) . ']');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['userGroup']['user_group_id'],
				'selected' => $__templater->func('in_array', array($__vars['userGroup']['user_group_id'], $__vars['bbCode']['usergroup_ids'], ), false),
				'label' => $__templater->escape($__vars['userGroup']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">

			<ul class="inputList">
				<li>
					' . $__templater->formSelectRow(array(
		'name' => 'usergroup_ids[]',
		'multiple' => 'multiple',
		'size' => '5',
	), $__compilerTemp1, array(
		'label' => 'Applicable Usergroups',
	)) . '
				</li>
			</ul>

		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('bb-codes/permissions-save', $__vars['bbCode'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);