<?php
// FROM HASH: c67021ada0dd9f22daaead2717a5c403
return array(
'macros' => array('type_list' => array(
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
			' . $__templater->callMacro(null, 'type_list_entry', array(
				'type' => $__vars['child'],
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
'type_list_entry' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'type' => '!',
		'children' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li class="nestable-item" data-id="' . $__templater->escape($__vars['type']['id']) . '">
		<div class="nestable-handle" aria-label="' . 'Drag handle' . '"><i class="fa fa-bars" aria-hidden="true"></i></div>
		<div class="nestable-content">
			<div style="width:50%;float:left;overflow:hidden;text-overflow: ellipsis;">' . $__templater->escape($__vars['type']['record']['type']) . '</div>
		</div>
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Type order');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			<div class="nestable-container" data-xf-init="nestable">
				' . $__templater->callMacro(null, 'type_list', array(
		'children' => $__vars['typeList'],
	), $__vars) . '
				' . $__templater->formHiddenVal('types', '', array(
	)) . '
			</div>
		</div>
		<input type="hidden" name="display_parent" value="0"/>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('form-types/sort', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '

' . '

';
	return $__finalCompiled;
}
);