<?php
// FROM HASH: c426cded63be3f4506a556f3eac5e8ec
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('[FS] Search Own Thread');
	$__finalCompiled .= '

' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => $__vars['data']['title'],
		'required' => 'required',
	), array(
		'hint' => 'Required',
		'label' => 'Title',
	)) . '
' . $__templater->formTextAreaRow(array(
		'name' => 'description',
		'value' => $__vars['data']['description'],
		'autosize' => 'true',
	), array(
		'label' => 'Description',
	)) . '

<hr class="formRowSep" />
' . $__templater->formTextBoxRow(array(
		'name' => 'url_portion',
		'value' => $__vars['data']['url_portion'],
		'dir' => 'ltr',
	), array(
		'label' => 'URL portion',
		'hint' => 'Optional',
	)) . '

' . $__templater->formNumberBoxRow(array(
		'name' => 'display_order',
		'value' => $__vars['data']['display_order'],
		'min' => '1',
		'step' => '1',
		'readonly' => ($__vars['readOnly'] ? 'readonly' : ''),
	), array(
		'label' => 'Display order',
		'hint' => $__templater->escape($__vars['hint']),
		'explain' => 'The position of this item relative to other nodes with the same parent.',
	)) . '
<hr class="formRowSep" />

' . $__templater->formDateInputRow(array(
		'name' => 'newer_than',
		'value' => $__vars['data']['newer_than'],
	), array(
		'label' => 'Newer than',
	)) . '

' . $__templater->formDateInputRow(array(
		'name' => 'older_than',
		'value' => $__vars['data']['older_than'],
	), array(
		'label' => 'Older than',
	)) . '

' . $__templater->formNumberBoxRow(array(
		'name' => 'min_reply_count',
		'value' => $__templater->filter($__vars['data']['min_reply_count'], array(array('default', array(0, )),), false),
		'min' => '0',
	), array(
		'label' => 'Minimum number of replies',
	)) . '

';
	if (!$__templater->test($__vars['prefixesGrouped'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = array(array(
			'value' => '',
			'label' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
			'_type' => 'option',
		));
		if ($__templater->isTraversable($__vars['prefixGroups'])) {
			foreach ($__vars['prefixGroups'] AS $__vars['groupId'] => $__vars['prefixGroup']) {
				if (($__templater->func('count', array($__vars['prefixesGrouped'][$__vars['groupId']], ), false) > 0)) {
					$__compilerTemp1[] = array(
						'label' => $__templater->func('prefix_group', array('thread', $__vars['groupId'], ), false),
						'_type' => 'optgroup',
						'options' => array(),
					);
					end($__compilerTemp1); $__compilerTemp2 = key($__compilerTemp1);
					if ($__templater->isTraversable($__vars['prefixesGrouped'][$__vars['groupId']])) {
						foreach ($__vars['prefixesGrouped'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
							$__compilerTemp1[$__compilerTemp2]['options'][] = array(
								'value' => $__vars['prefixId'],
								'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
								'_type' => 'option',
							);
						}
					}
				}
			}
		}
		$__finalCompiled .= $__templater->formSelectRow(array(
			'name' => 'prefixes[]',
			'size' => '7',
			'multiple' => 'true',
			'value' => $__templater->filter($__vars['data']['prefixes'], array(array('default', array(array(0, ), )),), false),
		), $__compilerTemp1, array(
			'label' => 'Prefixes',
		)) . '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp3 = array(array(
		'value' => '',
		'label' => 'All forums',
		'_type' => 'option',
	));
	$__compilerTemp4 = $__templater->method($__vars['nodeTree'], 'getFlattened', array(0, ));
	if ($__templater->isTraversable($__compilerTemp4)) {
		foreach ($__compilerTemp4 AS $__vars['treeEntry']) {
			$__compilerTemp3[] = array(
				'value' => $__vars['treeEntry']['record']['node_id'],
				'label' => $__templater->filter($__templater->func('repeat', array('&nbsp;&nbsp;', $__vars['treeEntry']['depth'], ), false), array(array('raw', array()),), true) . ' ' . $__templater->escape($__vars['treeEntry']['record']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formRow('

	<ul class="inputList">
		<li>' . $__templater->formSelect(array(
		'name' => 'nodes[]',
		'size' => '7',
		'multiple' => 'multiple',
		'value' => $__templater->filter($__vars['data']['nodes'], array(array('default', array(array(0, ), )),), false),
		'required' => 'required',
	), $__compilerTemp3) . '</li>
	</ul>
', array(
		'rowtype' => 'input',
		'hint' => 'Required',
		'label' => 'Search in forums',
	)) . '

' . $__templater->formRadioRow(array(
		'name' => 'order',
		'required' => 'required',
		'value' => $__templater->filter($__vars['data']['order'], array(array('default', array(($__vars['isRelevanceSupported'] ? 'relevance' : 'date'), )),), false),
	), array(array(
		'value' => 'date',
		'label' => 'Date',
		'_type' => 'option',
	),
	array(
		'value' => 'replies',
		'label' => 'Most replies',
		'_type' => 'option',
	)), array(
		'hint' => 'Required',
		'label' => 'Order by',
	));
	return $__finalCompiled;
}
);