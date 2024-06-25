<?php
// FROM HASH: 2c0a144864f78dd1c88fb95b02e24dab
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[limit]',
		'value' => $__vars['options']['limit'],
		'min' => '1',
		'step' => '1',
	), array(
		'label' => 'Maximum entries',
	)) . '

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[dateLimit]',
		'value' => $__vars['options']['dateLimit'],
		'units' => 'Days',
		'min' => '0',
	), array(
		'label' => 'Date limit',
		'explain' => 'Gifted content age limit (in days). Use 0 for no limit.',
	)) . '

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[cacheTime]',
		'value' => $__vars['options']['cacheTime'],
		'min' => '0',
		'step' => '1',
		'units' => 'Seconds',
	), array(
		'label' => 'Cache Time',
		'explain' => 'The time in seconds to cache the recent gifted post list. Set to 0 to disable',
	)) . '

' . $__templater->formNumberBoxRow(array(
		'name' => 'options[snippetLength]',
		'value' => $__vars['options']['snippetLength'],
		'min' => '1',
		'step' => '1',
		'units' => 'Characters',
	), array(
		'label' => 'Snippet Length',
		'explain' => 'When showing gifted posts show the first X characters, 0 to disable displaying snippets',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'value' => '1',
		'name' => 'options[skipLockedThreads]',
		'checked' => $__vars['options']['skipLockedThreads'],
		'label' => 'Exclude locked threads',
		'_type' => 'option',
	)), array(
		'label' => '',
	)) . '

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'value' => '1',
		'name' => 'options[skipWarnedPosts]',
		'checked' => $__vars['options']['skipWarnedPosts'],
		'label' => 'Exclude warned posts',
		'_type' => 'option',
	)), array(
		'label' => '',
	)) . '

' . '

';
	$__compilerTemp1 = array(array(
		'value' => '',
		'label' => 'None',
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['prefixList'])) {
		foreach ($__vars['prefixList'] AS $__vars['prefixId'] => $__vars['title']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['prefixId'],
				'label' => '
			' . $__templater->escape($__vars['title']) . '
		',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'options[skipPrefixes][]',
		'value' => ($__vars['options']['skipPrefixes'] ?: ''),
		'multiple' => 'multiple',
		'size' => '7',
	), $__compilerTemp1, array(
		'label' => 'Exclude Thread Prefixes',
		'explain' => 'Excludes posts from threads with a given set of prefixes',
	)) . '

';
	$__compilerTemp2 = array(array(
		'value' => '0',
		'label' => 'All forums',
		'_type' => 'option',
	));
	$__compilerTemp3 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp3)) {
		foreach ($__compilerTemp3 AS $__vars['treeEntry']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['treeEntry']['record']['node_id'],
				'disabled' => ($__vars['treeEntry']['record']['node_type_id'] != 'Forum'),
				'label' => '
			' . $__templater->filter($__templater->func('repeat', array('&nbsp;&nbsp;', $__vars['treeEntry']['depth'], ), false), array(array('raw', array()),), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']) . '
		',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formSelectRow(array(
		'name' => 'options[node_ids][]',
		'value' => ($__vars['options']['node_ids'] ?: ''),
		'multiple' => 'multiple',
		'size' => '7',
	), $__compilerTemp2, array(
		'label' => 'Forum limit',
		'explain' => 'Only include threads in the selected forums.',
	));
	return $__finalCompiled;
}
);