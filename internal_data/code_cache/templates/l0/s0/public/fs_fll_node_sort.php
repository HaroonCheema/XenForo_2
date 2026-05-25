<?php
// FROM HASH: ee4caa2ec362928ded7c896c821a07c1
return array(
'macros' => array('node_list' => array(
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
			' . $__templater->callMacro(null, 'node_list_entry', array(
				'node' => $__vars['child'],
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
'node_list_entry' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'children' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li class="nestable-item" data-id="' . $__templater->escape($__vars['node']['id']) . '">
		<div class="nestable-handle" aria-label="' . $__templater->filter('Drag handle', array(array('for_attr', array()),), true) . '">' . $__templater->callMacro(null, 'node_icon', array(
		'node' => $__vars['node']['record'],
	), $__vars) . '</div>
		<div class="nestable-content">
			<strong>' . $__templater->escape($__vars['node']['record']['title']) . '</strong>
			<span class="nestable-label nestable-label--smallest" dir="auto">
				' . $__templater->escape($__vars['node']['record']['NodeType']['title']) . '
				';
	if (($__vars['node']['record']['node_type_id'] == 'Forum') AND ($__vars['node']['record']['Data']['TypeHandler'] AND ($__vars['node']['record']['Data']['forum_type_id'] != 'discussion'))) {
		$__finalCompiled .= '
					(' . $__templater->escape($__templater->method($__vars['node']['record']['Data']['TypeHandler'], 'getTypeTitle', array())) . ')
				';
	}
	$__finalCompiled .= '
			</span>
		</div>
		';
	if (!$__templater->test($__vars['node']['children'], 'empty', array())) {
		$__finalCompiled .= '
			' . $__templater->callMacro(null, 'node_list', array(
			'children' => $__vars['node']['children'],
		), $__vars) . '
		';
	}
	$__finalCompiled .= '
	</li>
';
	return $__finalCompiled;
}
),
'node_icon' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (($__vars['node']['node_type_id'] == 'Forum') AND $__vars['node']['Data']['TypeHandler']) {
		$__finalCompiled .= '
		';
		$__vars['typeIcon'] = $__templater->method($__vars['node']['Data']['TypeHandler'], 'getTypeIconClass', array());
		$__finalCompiled .= '
		';
		if ($__vars['typeIcon']) {
			$__finalCompiled .= '
			
		';
		} else {
			$__finalCompiled .= '
			<i class="fa fa-bars" aria-hidden="true"></i>
			
		';
		}
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
		<i class="fa fa-bars" aria-hidden="true"></i>
		
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('sort_nodes');
	$__finalCompiled .= '

' . $__templater->callMacro('public:nestable_macros', 'setup', array(), $__vars) . '

';
	$__templater->inlineCss('
.nodeIcon {
  font-family: \'Font Awesome 5 Pro\';
  font-size: inherit;
  font-style: normal;
  font-weight: 400;
  text-rendering: auto;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #505050;
}
.nodeIcon--Category:before {
  content: "\\f0c9";
  width: 1.28571429em;
  display: inline-block;
  text-align: center;
}

');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			<div class="nestable-container" data-xf-init="nestable">
				' . $__templater->callMacro(null, 'node_list', array(
		'children' => $__vars['nodeTree'],
	), $__vars) . '
				' . $__templater->formHiddenVal('nodes', '', array(
	)) . '
			</div>
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('forums/sort', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '

' . '

' . '


';
	return $__finalCompiled;
}
);