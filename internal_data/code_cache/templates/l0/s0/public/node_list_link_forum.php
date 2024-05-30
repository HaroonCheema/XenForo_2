<?php
// FROM HASH: 5d0b3a9a4d7c40c5913275285de8ecb9
return array(
'macros' => array('depth1' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'extras' => '!',
		'children' => '!',
		'childExtras' => '!',
		'depth' => '1',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				' . $__templater->callMacro(null, 'link_forum', array(
		'node' => $__vars['node'],
		'extras' => $__vars['extras'],
		'children' => $__vars['children'],
		'childExtras' => $__vars['childExtras'],
		'depth' => $__vars['depth'],
	), $__vars) . '
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'depth2' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'extras' => '!',
		'children' => '!',
		'childExtras' => '!',
		'depth' => '1',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->callMacro(null, 'link_forum', array(
		'node' => $__vars['node'],
		'extras' => $__vars['extras'],
		'children' => $__vars['children'],
		'childExtras' => $__vars['childExtras'],
		'depth' => $__vars['depth'],
	), $__vars) . '
';
	return $__finalCompiled;
}
),
'depthN' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'extras' => '!',
		'children' => '!',
		'childExtras' => '!',
		'depth' => '1',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li>
		<a href="' . $__templater->func('link', array('link-forums', $__vars['node'], ), true) . '" class="subNodeLink subNodeLink--link">' . $__templater->escape($__vars['node']['title']) . '</a>
		' . $__templater->callMacro('forum_list', 'sub_node_list', array(
		'children' => $__vars['children'],
		'childExtras' => $__vars['childExtras'],
		'depth' => ($__vars['depth'] + 1),
	), $__vars) . '
	</li>
';
	return $__finalCompiled;
}
),
'link_forum' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'extras' => '!',
		'children' => $__vars['children'],
		'childExtras' => $__vars['childExtras'],
		'depth' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="node node--id' . $__templater->escape($__vars['node']['node_id']) . ' node--depth' . $__templater->escape($__vars['depth']) . ' node--link">
		<div class="node-body">
			';
	if ($__templater->method($__vars['node'], 'getIcon', array())) {
		$__finalCompiled .= '
	<div class="node-icon--custom" 
		 style="background-image: url(' . $__templater->func('base_url', array($__templater->method($__vars['node'], 'getIcon', array()), ), true) . ');
				width: ' . $__templater->escape($__vars['xf']['options']['Fs_NodeIcon_nodeDimensions']['width']) . 'px;
				height: ' . $__templater->escape($__vars['xf']['options']['Fs_NodeIcon_nodeDimensions']['height']) . 'px;">
	</div>
';
	} else {
		$__finalCompiled .= '
	<span class="node-icon" aria-hidden="true"
		  style="width: ' . $__templater->escape($__vars['xf']['options']['Fs_NodeIcon_nodeDimensions']['width']) . 'px;
				 height: ' . $__templater->escape($__vars['xf']['options']['Fs_NodeIcon_nodeDimensions']['height']) . 'px;">
		<i></i>
	</span>
';
	}
	$__finalCompiled .= '
			<div class="node-main js-nodeMain">
				';
	$__vars['descriptionDisplay'] = $__templater->func('property', array('nodeListDescriptionDisplay', ), false);
	$__finalCompiled .= '
				<h3 class="node-title">
					 <a href="' . $__templater->func('link', array('link-forums', $__vars['node'], ), true) . '" data-xf-init="' . (($__vars['descriptionDisplay'] == 'tooltip') ? 'element-tooltip' : '') . '" data-shortcut="node-description">' . $__templater->escape($__vars['node']['title']) . '</a>
				</h3>
				';
	if (($__vars['descriptionDisplay'] != 'none') AND $__vars['node']['description']) {
		$__finalCompiled .= '
					<div class="node-description ' . (($__vars['descriptionDisplay'] == 'tooltip') ? 'node-description--tooltip js-nodeDescTooltip' : '') . '">' . $__templater->filter($__vars['node']['description'], array(array('raw', array()),), true) . '</div>
				';
	}
	$__finalCompiled .= '

				';
	if (($__vars['depth'] == 2) AND ($__templater->func('property', array('nodeListSubDisplay', ), false) == 'menu')) {
		$__finalCompiled .= '
					<div class="node-meta">
						' . $__templater->callMacro('forum_list', 'sub_nodes_menu', array(
			'children' => $__vars['children'],
			'childExtras' => $__vars['childExtras'],
			'depth' => ($__vars['depth'] + 1),
		), $__vars) . '
					</div>
				';
	}
	$__finalCompiled .= '

				';
	if (($__vars['depth'] == 2) AND ($__templater->func('property', array('nodeListSubDisplay', ), false) == 'flat')) {
		$__finalCompiled .= '
					' . $__templater->callMacro('forum_list', 'sub_nodes_flat', array(
			'children' => $__vars['children'],
			'childExtras' => $__vars['childExtras'],
			'depth' => ($__vars['depth'] + 1),
		), $__vars) . '
				';
	}
	$__finalCompiled .= '
			</div>
		</div>
	</div>

	';
	if ($__vars['depth'] == 1) {
		$__finalCompiled .= '
		' . $__templater->callMacro('forum_list', 'node_list', array(
			'children' => $__vars['children'],
			'extras' => $__vars['childExtras'],
			'depth' => ($__vars['depth'] + 1),
		), $__vars) . '
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
	$__finalCompiled .= '

' . '

' . '

';
	return $__finalCompiled;
}
);