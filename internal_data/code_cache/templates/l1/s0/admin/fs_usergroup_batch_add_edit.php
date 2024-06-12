<?php
// FROM HASH: 0332edfd1b83a23727b4d460b802372f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['data']['batch_id']) {
		$__compilerTemp1 .= ' ' . 'Edit Batch' . ' : ' . $__templater->escape($__vars['data']['title']) . ' ';
		$__templater->breadcrumb($__templater->preEscaped('Edit Batch'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	} else {
		$__compilerTemp1 .= 'Add Batch' . '
		';
		$__templater->breadcrumb($__templater->preEscaped('Add Batch'), '#', array(
		));
		$__compilerTemp1 .= ' ';
	}
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . $__compilerTemp1 . '
');
	$__finalCompiled .= '
';
	$__compilerTemp2 = '';
	if ($__vars['autoForumManager']['forum_manage_id']) {
		$__compilerTemp2 .= '
						';
		$__compilerTemp3 = array();
		if ($__templater->isTraversable($__vars['forums'])) {
			foreach ($__vars['forums'] AS $__vars['forum']) {
				$__compilerTemp3[] = array(
					'value' => $__vars['forum']['value'],
					'disabled' => $__vars['forum']['disabled'],
					'selected' => ($__vars['autoForumManager']['node_id'] == $__vars['forum']['value']),
					'label' => $__templater->escape($__vars['forum']['label']),
					'_type' => 'option',
				);
			}
		}
		$__compilerTemp2 .= $__templater->formSelectRow(array(
			'name' => 'usergroup_ids[]',
			'required' => 'required',
		), $__compilerTemp3, array(
			'label' => 'Select Usergroups',
			'hint' => 'Required',
		)) . '
						';
	} else {
		$__compilerTemp2 .= '
						';
		$__compilerTemp4 = array();
		if ($__templater->isTraversable($__vars['userGroups'])) {
			foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
				$__compilerTemp4[] = array(
					'value' => $__vars['userGroup']['user_group_id'],
					'selected' => $__templater->func('in_array', array($__vars['userGroup']['user_group_id'], $__vars['data']['usergroup_ids'], ), false),
					'label' => $__templater->escape($__vars['userGroup']['title']),
					'_type' => 'option',
				);
			}
		}
		$__compilerTemp2 .= $__templater->formSelectRow(array(
			'name' => 'usergroup_ids[]',
			'multiple' => 'multiple',
			'size' => '5',
			'required' => 'required',
		), $__compilerTemp4, array(
			'label' => 'Select Usergroups',
			'hint' => 'Required',
		)) . '
					';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['data']['title'],
		'required' => 'required',
	), array(
		'label' => 'Title',
		'hint' => 'Required',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'desc',
		'value' => $__vars['data']['desc'],
		'rows' => '2',
		'autosize' => 'true',
	), array(
		'label' => 'Description',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'img_path',
		'value' => $__vars['data']['img_path'],
		'required' => 'required',
	), array(
		'label' => 'Image Path',
		'hint' => 'Required',
	)) . '

			' . $__templater->formNumberBoxRow(array(
		'name' => 'type_repeat',
		'value' => $__vars['data']['type_repeat'],
		'min' => '0',
		'autosize' => 'true',
		'row' => '5',
	), array(
		'label' => 'Number Of Type Repeat',
	)) . '

			' . $__templater->formNumberBoxRow(array(
		'name' => 'mini_post',
		'value' => $__vars['data']['mini_post'],
		'min' => '0',
		'autosize' => 'true',
		'row' => '5',
	), array(
		'label' => 'Minimum Posts',
	)) . '

			<ul class="inputList">
				<li>
					' . $__compilerTemp2 . '
				</li>
			</ul>

		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => '',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('batch/save', $__vars['data'], ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);