<?php
// FROM HASH: 6abd77c05bb12b17183ea54a0ec8a5c5
return array(
'macros' => array('node_tree_edit' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'bot' => '!',
		'nodeTree' => '!',
		'groupedPrompts' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp1)) {
		foreach ($__compilerTemp1 AS $__vars['treeEntry']) {
			$__finalCompiled .= '
		';
			$__vars['node'] = $__vars['treeEntry']['record'];
			$__finalCompiled .= '
		';
			$__compilerTemp2 = '';
			if ($__vars['node']['node_type_id'] === 'Forum') {
				$__compilerTemp2 .= '
					<a href="' . $__templater->func('link', array('ai-bots/chat-gpt-node-prompts/edit', $__vars['node'], array('bot_id' => $__vars['bot']['bot_id'], ), ), true) . '">
						' . $__templater->callMacro(null, 'node_title', array(
					'node' => $__vars['node'],
					'treeEntry' => $__vars['treeEntry'],
				), $__vars) . '
					</a>
					';
			} else {
				$__compilerTemp2 .= '
					' . $__templater->callMacro(null, 'node_title', array(
					'node' => $__vars['node'],
					'treeEntry' => $__vars['treeEntry'],
				), $__vars) . '
				';
			}
			$__finalCompiled .= $__templater->dataRow(array(
				'rowtype' => (($__vars['node']['node_type_id'] !== 'Forum') ? 'subsection' : ''),
				'rowclass' => (($__vars['node']['node_type_id'] !== 'Forum') ? 'dataList-row--noHover' : '') . ($__vars['groupedPrompts'][$__vars['node']['node_id']]['prompt'] ? ' dataList-row--custom' : ''),
			), array(array(
				'class' => 'dataList-cell--min',
				'_type' => 'cell',
				'html' => '
				' . $__templater->callMacro(null, 'node_list::node_icon', array(
				'node' => $__vars['node'],
			), $__vars) . '
			',
			),
			array(
				'class' => 'dataList-cell--link dataList-cell--main',
				'_type' => 'cell',
				'html' => '
				' . $__compilerTemp2 . '
			',
			))) . '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'node_title' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'node' => '!',
		'treeEntry' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="u-depth' . $__templater->escape($__vars['treeEntry']['depth']) . '">
		<div class="dataList-mainRow">
			' . $__templater->escape($__vars['node']['title']) . '
			<span class="dataList-hint" dir="auto">
				' . $__templater->escape($__vars['node']['NodeType']['title']) . '
				';
	if (($__vars['node']['node_type_id'] == 'Forum') AND ($__vars['node']['Data']['TypeHandler'] AND ($__vars['node']['Data']['forum_type_id'] != 'discussion'))) {
		$__finalCompiled .= '
					(' . $__templater->escape($__templater->method($__vars['node']['Data']['TypeHandler'], 'getTypeTitle', array())) . ')
				';
	}
	$__finalCompiled .= '
			</span>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('ChatGPT node prompts');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['bots'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			';
		if ($__templater->isTraversable($__vars['bots'])) {
			foreach ($__vars['bots'] AS $__vars['bot']) {
				$__finalCompiled .= '
				<h3 class="block-formSectionHeader">
					<span class="collapseTrigger collapseTrigger--block" data-xf-click="toggle" data-target="< :up:next">
						' . $__templater->func('avatar', array($__vars['bot']['User'], 'xxs', false, array(
					'href' => '',
				))) . '
						' . $__templater->escape($__vars['bot']['username']) . '
					</span>
				</h3>
				<div class="block-body block-body--collapsible">
					' . $__templater->dataList('
						' . $__templater->callMacro(null, 'node_tree_edit', array(
					'bot' => $__vars['bot'],
					'nodeTree' => $__vars['nodeTree'],
					'groupedPrompts' => $__vars['groupedPrompts'][$__vars['bot']['bot_id']],
				), $__vars) . '
					', array(
				)) . '
				</div>
			';
			}
		}
		$__finalCompiled .= '
		</div>
	</div>
	';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There are currently no active bots.' . '</div>
';
	}
	$__finalCompiled .= '

' . '

';
	return $__finalCompiled;
}
);