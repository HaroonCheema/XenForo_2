<?php
// FROM HASH: 18d69e2144dd68bbd0bb68d371f4488f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['meeting'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add Meeting');
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['meeting']['topic']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['meeting'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('zoom-meeting/delete', $__vars['meeting'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['userGroups'])) {
		foreach ($__vars['userGroups'] AS $__vars['userGroup']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['userGroup']['user_group_id'],
				'label' => $__templater->escape($__vars['userGroup']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">
		<div class="block-body">

			' . $__templater->formTextBoxRow(array(
		'name' => 'topic',
		'value' => $__vars['meeting']['topic'],
		'required' => 'true',
		'autofocus' => 'true',
	), array(
		'label' => 'Topic',
	)) . '

			<h2 class="block-formSectionHeader"><span class="block-formSectionHeader-aligner">' . 'Timing' . '</span></h2>
			' . $__templater->formRow('
				<div class="inputGroup">

					' . $__templater->formDateInput(array(
		'name' => 'start_date',
		'class' => 'date start',
		'value' => ($__vars['meeting']['start_time'] ? $__vars['meeting']['start_time'] : ''),
		'required' => 'true',
	)) . '

					<span class="inputGroup-splitter"></span>

					' . $__templater->formTextBox(array(
		'name' => 'start_time',
		'class' => 'input--date time start',
		'required' => 'true',
		'type' => 'time',
		'value' => ($__vars['meeting']['start_time'] ? $__templater->method($__vars['meeting'], 'getStartTimeConvert', array()) : ''),
		'data-xf-init' => 'time-picker',
		'data-moment' => ($__vars['meeting']['start_time'] ? $__templater->method($__vars['meeting'], 'getStartTimeConvert', array()) : ''),
		'data-format' => $__vars['xf']['language']['time_format'],
	)) . '

				</div>
			', array(
		'rowtype' => 'input',
		'label' => 'Start Time',
	)) . '

			' . $__templater->formNumberBoxRow(array(
		'name' => 'duration',
		'value' => $__vars['meeting']['duration'],
		'min' => '10',
	), array(
		'label' => 'Duration',
		'explain' => 'Duration should be count in minutes.',
	)) . '

			<h2 class="block-formSectionHeader"><span class="block-formSectionHeader-aligner">' . 'Join Meeting Validation' . '</span></h2>
			' . $__templater->formSelectRow(array(
		'name' => 'join_usergroup_ids[]',
		'multiple' => 'multiple',
		'size' => '5',
		'value' => $__vars['meeting']['join_usergroup_ids'],
	), $__compilerTemp1, array(
		'label' => 'UserGroups',
		'explain' => 'User Groups Allow to join meeting.',
	)) . '
		</div>
	</div>
	' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '

', array(
		'action' => $__templater->func('link', array('zoom-meeting/save', $__vars['meeting'], ), false),
		'ajax' => 'true',
		'data-xf-init' => 'attachment-manager',
	));
	return $__finalCompiled;
}
);