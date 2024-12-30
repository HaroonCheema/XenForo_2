<?php
// FROM HASH: 3afa7ba9637b94e8c5015eb30e1e9fa3
return array(
'macros' => array('question_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'children' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<ol class="nestable-list">
		';
	if ($__templater->isTraversable($__vars['children'])) {
		foreach ($__vars['children'] AS $__vars['id'] => $__vars['child']) {
			$__finalCompiled .= '
			' . $__templater->callMacro(null, 'question_list_entry', array(
				'ques' => $__vars['child'],
				'children' => $__vars['child']['children'],
			), $__vars) . '
		';
		}
	}
	$__finalCompiled .= '
	</ol>
';
	return $__finalCompiled;
}
),
'question_list_entry' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'ques' => '!',
		'children' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li class="nestable-item" data-id="' . $__templater->escape($__vars['ques']['id']) . '">
		<div class="nestable-handle" aria-label="' . 'Drag handle' . '"><i class="fa fa-bars" aria-hidden="true"></i></div>
		<div class="nestable-content">
			';
	if ($__vars['ques']['record']['type'] == 9) {
		$__finalCompiled .= '
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . 'Agreement Text' . '
			';
	} else {
		$__finalCompiled .= '
				<div style="width:50%;float:left;overflow:hidden;text-overflow: ellipsis;"><span ' . (($__vars['ques']['record']['type'] === 6) ? 'style="float:right;text-align:center;"' : '') . '>' . $__templater->escape($__vars['ques']['record']['text']) . '</span></div><div style="float:right;overflow:hidden;">' . ($__vars['ques']['record']['hasconditional'] ? ((('QID' . $__vars['xf']['language']['label_separator'] . ' ') . $__templater->escape($__vars['ques']['record']['questionid'])) . ($__vars['ques']['record']['conditional'] ? ' & ' : '')) : '') . ($__vars['ques']['record']['conditional'] ? ('Conditional for QID' . $__templater->escape($__vars['ques']['record']['conditional'])) : '') . '</div>
			';
	}
	$__finalCompiled .= '
		</div>
		';
	if (!$__templater->test($__vars['ques']['children'], 'empty', array())) {
		$__finalCompiled .= '
			' . $__templater->callMacro(null, 'question_list', array(
			'children' => $__vars['ques']['children'],
		), $__vars) . '
		';
	}
	$__finalCompiled .= '
	</li>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeJs(array(
		'src' => 'vendor/nestable/jquery.nestable.min.js',
	));
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'Snog/Forms/nestable.min.js',
	));
	$__finalCompiled .= '
';
	$__templater->includeCss('public:nestable.less');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Question Order');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div style="width:100%;padding-right:20px;padding-left:20px;">
			' . 'If you use question answers in your report title, be sure to match the new question numbers in the report title after changing the order.' . '
		</div>
		<div class="block-body">
			<div class="nestable-container" data-xf-init="nestable">
				' . $__templater->callMacro(null, 'question_list', array(
		'children' => $__vars['questionList'],
	), $__vars) . '
				' . $__templater->formHiddenVal('questions', '', array(
	)) . '
			</div>
		</div>
		<input type="hidden" name="posid" value="' . $__templater->escape($__vars['posid']) . '"/>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('form-editquestions/sort', $__vars['form'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '

' . '

';
	return $__finalCompiled;
}
);