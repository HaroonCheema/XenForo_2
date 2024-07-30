<?php
// FROM HASH: b943cb5d4646a6c2c1fb9779cb4d4dcd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped(' ' . 'Favourite Team' . ' ');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['data'])) {
		foreach ($__vars['data'] AS $__vars['val']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['val']['id'],
				'label' => $__templater->escape($__vars['val']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('

				<ul class="inputList">
					<li>' . $__templater->formSelect(array(
		'name' => 'team_ids[]',
		'size' => '7',
		'multiple' => 'multiple',
		'value' => $__templater->filter($__vars['xf']['visitor']['team_ids'], array(array('default', array(array(0, ), )),), false),
		'required' => 'required',
	), $__compilerTemp1) . '</li>
				</ul>
			', array(
		'rowtype' => 'input',
		'hint' => 'Required',
		'label' => 'Teams',
		'explain' => 'You can select your ' . $__templater->escape($__vars['xf']['options']['fs_teams_total']) . ' favourite teams.',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => '',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('team/save', ), false),
		'ajax' => 'true',
		'class' => 'block',
		'data-force-flash-message' => 'true',
	));
	return $__finalCompiled;
}
);