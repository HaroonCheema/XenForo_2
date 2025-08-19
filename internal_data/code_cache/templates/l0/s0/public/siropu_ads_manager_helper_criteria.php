<?php
// FROM HASH: d9b4697e57099cbf654649d87e42f690
return array(
'macros' => array('position_tabs' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<a class="tabs-tab" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('criteriaPosition', ), true) . '">' . 'Position criteria' . '</a>
';
	return $__finalCompiled;
}
),
'position_panes' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'criteria' => '!',
		'data' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li role="tabpanel" class="is-active" id="' . $__templater->func('unique_id', array('criteriaPosition', ), true) . '">

		' . $__templater->formHiddenVal('position_criteria[item_id][rule]', 'item_id', array(
	)) . '
		' . $__templater->formTextBoxRow(array(
		'name' => 'position_criteria[item_id][data][id]',
		'value' => $__vars['criteria']['item_id']['id'],
	), array(
		'label' => 'Item ID',
		'explain' => 'This option can only be used with dynamic positions. Depending on the position used, ID can be a page result item number relative to the total results on the page, a node ID, a thread ID, or a flag: R, L, U, X<small>number</small>.

<p>Flags:</p>

<p>
	<ul class="listPlain">
		<li><b>R</b> - Random</li>
		<li><b>L</b> - Last</li>
		<li><b>U</b> - First unread thread post or conversation message</li>
		<li><b>X</b><small>number</small> - Every x items (x3, x5, etc)</li>
	</ul>
</p>

You can combine the <b>U</b> flag with other flags and numbers. The <b>U</b> flag will have priority over the others.<br>

You can use multiple IDs separated by comma.',
	)) . '

		';
	$__compilerTemp1 = array();
	$__compilerTemp2 = $__templater->func('array_keys', array($__vars['data']['threadPrefixes'], ), false);
	if ($__templater->isTraversable($__compilerTemp2)) {
		foreach ($__compilerTemp2 AS $__vars['groupId']) {
			if ($__vars['groupId'] > 0) {
				$__compilerTemp1[] = array(
					'label' => $__templater->func('prefix_group', array('thread', $__vars['groupId'], ), false),
					'_type' => 'optgroup',
					'options' => array(),
				);
				end($__compilerTemp1); $__compilerTemp3 = key($__compilerTemp1);
				if ($__templater->isTraversable($__vars['data']['threadPrefixes'][$__vars['groupId']])) {
					foreach ($__vars['data']['threadPrefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp1[$__compilerTemp3]['options'][] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
							'_type' => 'option',
						);
					}
				}
			} else {
				if ($__templater->isTraversable($__vars['data']['threadPrefixes'][$__vars['groupId']])) {
					foreach ($__vars['data']['threadPrefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp1[] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
							'_type' => 'option',
						);
					}
				}
			}
		}
	}
	$__compilerTemp4 = array();
	$__compilerTemp5 = $__templater->func('array_keys', array($__vars['data']['threadPrefixes'], ), false);
	if ($__templater->isTraversable($__compilerTemp5)) {
		foreach ($__compilerTemp5 AS $__vars['groupId']) {
			if ($__vars['groupId'] > 0) {
				$__compilerTemp4[] = array(
					'label' => $__templater->func('prefix_group', array('thread', $__vars['groupId'], ), false),
					'_type' => 'optgroup',
					'options' => array(),
				);
				end($__compilerTemp4); $__compilerTemp6 = key($__compilerTemp4);
				if ($__templater->isTraversable($__vars['data']['threadPrefixes'][$__vars['groupId']])) {
					foreach ($__vars['data']['threadPrefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp4[$__compilerTemp6]['options'][] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
							'_type' => 'option',
						);
					}
				}
			} else {
				if ($__templater->isTraversable($__vars['data']['threadPrefixes'][$__vars['groupId']])) {
					foreach ($__vars['data']['threadPrefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp4[] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
							'_type' => 'option',
						);
					}
				}
			}
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'position_criteria[thread_prefix_filter][rule]',
		'value' => 'thread_prefix_filter',
		'selected' => $__vars['criteria']['thread_prefix_filter'],
		'label' => 'Thread prefix filter is' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'position_criteria[thread_prefix_filter][data][prefix_id]',
		'value' => $__vars['criteria']['thread_prefix_filter']['prefix_id'],
		'multiple' => 'true',
	), $__compilerTemp1)),
		'afterhint' => 'For multiple selections, hold down Ctrl (Command for Macs) while clicking selections. ',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_prefix_filter_not][rule]',
		'value' => 'thread_prefix_filter_not',
		'selected' => $__vars['criteria']['thread_prefix_filter_not'],
		'label' => 'Thread prefix filter is NOT' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'position_criteria[thread_prefix_filter_not][data][prefix_id]',
		'value' => $__vars['criteria']['thread_prefix_filter_not']['prefix_id'],
		'multiple' => 'true',
	), $__compilerTemp4)),
		'afterhint' => 'For multiple selections, hold down Ctrl (Command for Macs) while clicking selections. ',
		'_type' => 'option',
	)), array(
		'label' => 'Forums',
		'hint' => 'Available in forum view',
	)) . '

		<hr class="formRowSep" />

		';
	$__compilerTemp7 = array();
	$__compilerTemp8 = $__templater->func('array_keys', array($__vars['data']['threadPrefixes'], ), false);
	if ($__templater->isTraversable($__compilerTemp8)) {
		foreach ($__compilerTemp8 AS $__vars['groupId']) {
			if ($__vars['groupId'] > 0) {
				$__compilerTemp7[] = array(
					'label' => $__templater->func('prefix_group', array('thread', $__vars['groupId'], ), false),
					'_type' => 'optgroup',
					'options' => array(),
				);
				end($__compilerTemp7); $__compilerTemp9 = key($__compilerTemp7);
				if ($__templater->isTraversable($__vars['data']['threadPrefixes'][$__vars['groupId']])) {
					foreach ($__vars['data']['threadPrefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp7[$__compilerTemp9]['options'][] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
							'_type' => 'option',
						);
					}
				}
			} else {
				if ($__templater->isTraversable($__vars['data']['threadPrefixes'][$__vars['groupId']])) {
					foreach ($__vars['data']['threadPrefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp7[] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
							'_type' => 'option',
						);
					}
				}
			}
		}
	}
	$__compilerTemp10 = array();
	$__compilerTemp11 = $__templater->func('array_keys', array($__vars['data']['threadPrefixes'], ), false);
	if ($__templater->isTraversable($__compilerTemp11)) {
		foreach ($__compilerTemp11 AS $__vars['groupId']) {
			if ($__vars['groupId'] > 0) {
				$__compilerTemp10[] = array(
					'label' => $__templater->func('prefix_group', array('thread', $__vars['groupId'], ), false),
					'_type' => 'optgroup',
					'options' => array(),
				);
				end($__compilerTemp10); $__compilerTemp12 = key($__compilerTemp10);
				if ($__templater->isTraversable($__vars['data']['threadPrefixes'][$__vars['groupId']])) {
					foreach ($__vars['data']['threadPrefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp10[$__compilerTemp12]['options'][] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
							'_type' => 'option',
						);
					}
				}
			} else {
				if ($__templater->isTraversable($__vars['data']['threadPrefixes'][$__vars['groupId']])) {
					foreach ($__vars['data']['threadPrefixes'][$__vars['groupId']] AS $__vars['prefixId'] => $__vars['prefix']) {
						$__compilerTemp10[] = array(
							'value' => $__vars['prefixId'],
							'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
							'_type' => 'option',
						);
					}
				}
			}
		}
	}
	$__compilerTemp13 = array();
	$__compilerTemp14 = $__templater->method($__vars['xf']['samAdmin'], 'getUserGroupTitlePairs', array());
	if ($__templater->isTraversable($__compilerTemp14)) {
		foreach ($__compilerTemp14 AS $__vars['userGroupId'] => $__vars['userGroupTitle']) {
			$__compilerTemp13[] = array(
				'value' => $__vars['userGroupId'],
				'label' => $__templater->escape($__vars['userGroupTitle']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp15 = array();
	$__compilerTemp16 = $__templater->method($__vars['xf']['samAdmin'], 'getUserGroupTitlePairs', array());
	if ($__templater->isTraversable($__compilerTemp16)) {
		foreach ($__compilerTemp16 AS $__vars['userGroupId'] => $__vars['userGroupTitle']) {
			$__compilerTemp15[] = array(
				'value' => $__vars['userGroupId'],
				'label' => $__templater->escape($__vars['userGroupTitle']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp17 = '';
	$__compilerTemp18 = '';
	$__compilerTemp18 .= '
							';
	$__compilerTemp19 = $__templater->method($__templater->method($__vars['xf']['app']['em'], 'getRepository', array('XF:ThreadField', )), 'getDisplayGroups', array());
	if ($__templater->isTraversable($__compilerTemp19)) {
		foreach ($__compilerTemp19 AS $__vars['fieldGroup'] => $__vars['phrase']) {
			$__compilerTemp18 .= '
								';
			$__vars['customFields'] = $__templater->method($__vars['xf']['app'], 'getCustomFields', array('threads', $__vars['fieldGroup'], ));
			$__compilerTemp18 .= '
								';
			if ($__templater->isTraversable($__vars['customFields'])) {
				foreach ($__vars['customFields'] AS $__vars['fieldId'] => $__vars['fieldDefinition']) {
					$__compilerTemp18 .= '
									';
					$__vars['choices'] = $__vars['fieldDefinition']['field_choices'];
					$__compilerTemp18 .= '
									';
					$__vars['fieldName'] = 'position_criteria[thread_custom_fields][data][' . $__vars['fieldId'] . ']';
					$__compilerTemp18 .= '
									<p><b class="iconic-label">' . $__templater->escape($__vars['fieldDefinition']['title']) . '</b></p>
									';
					if (!$__vars['choices']) {
						$__compilerTemp18 .= '
										' . $__templater->formTextBox(array(
							'name' => $__vars['fieldName'],
							'value' => $__vars['criteria']['thread_custom_fields'][$__vars['fieldId']],
						)) . '
										';
					} else {
						$__compilerTemp18 .= '
										';
						$__compilerTemp20 = array();
						if ($__templater->isTraversable($__vars['choices'])) {
							foreach ($__vars['choices'] AS $__vars['val'] => $__vars['choice']) {
								$__compilerTemp20[] = array(
									'value' => $__vars['val'],
									'label' => $__templater->escape($__vars['choice']),
									'_type' => 'option',
								);
							}
						}
						$__compilerTemp18 .= $__templater->formCheckBox(array(
							'name' => $__vars['fieldName'],
							'value' => $__vars['criteria']['thread_custom_fields'][$__vars['fieldId']],
							'listclass' => 'listColumns',
						), $__compilerTemp20) . '
									';
					}
					$__compilerTemp18 .= '
								';
				}
			}
			$__compilerTemp18 .= '
							';
		}
	}
	$__compilerTemp18 .= '
						';
	if (strlen(trim($__compilerTemp18)) > 0) {
		$__compilerTemp17 .= '
						' . $__compilerTemp18 . '
					';
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'position_criteria[thread_type][rule]',
		'value' => 'thread_type',
		'selected' => $__vars['criteria']['thread_type'],
		'label' => 'Thread type is' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'position_criteria[thread_type][data][type]',
		'value' => $__vars['criteria']['thread_type']['type'],
	), array(array(
		'value' => 'discussion',
		'label' => 'Discussion',
		'_type' => 'option',
	),
	array(
		'value' => 'poll',
		'label' => 'Poll',
		'_type' => 'option',
	),
	array(
		'value' => 'article',
		'label' => 'Article',
		'_type' => 'option',
	),
	array(
		'value' => 'question',
		'label' => 'Question',
		'_type' => 'option',
	),
	array(
		'value' => 'suggestion',
		'label' => 'Suggestion',
		'_type' => 'option',
	)))),
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_type_not][rule]',
		'value' => 'thread_type_not',
		'selected' => $__vars['criteria']['thread_type_not'],
		'label' => 'Thread type is NOT' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'position_criteria[thread_type_not][data][type]',
		'value' => $__vars['criteria']['thread_type_not']['type'],
	), array(array(
		'value' => 'discussion',
		'label' => 'Discussion',
		'_type' => 'option',
	),
	array(
		'value' => 'poll',
		'label' => 'Poll',
		'_type' => 'option',
	),
	array(
		'value' => 'article',
		'label' => 'Article',
		'_type' => 'option',
	),
	array(
		'value' => 'question',
		'label' => 'Question',
		'_type' => 'option',
	),
	array(
		'value' => 'suggestion',
		'label' => 'Suggestion',
		'_type' => 'option',
	)))),
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_prefix][rule]',
		'value' => 'thread_prefix',
		'selected' => $__vars['criteria']['thread_prefix'],
		'label' => 'Thread prefix is' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'position_criteria[thread_prefix][data][prefix_id]',
		'value' => $__vars['criteria']['thread_prefix']['prefix_id'],
		'multiple' => 'true',
	), $__compilerTemp7)),
		'afterhint' => 'For multiple selections, hold down Ctrl (Command for Macs) while clicking selections. ',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_prefix_not][rule]',
		'value' => 'thread_prefix_not',
		'selected' => $__vars['criteria']['thread_prefix_not'],
		'label' => 'Thread prefix is NOT' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'position_criteria[thread_prefix_not][data][prefix_id]',
		'value' => $__vars['criteria']['thread_prefix_not']['prefix_id'],
		'multiple' => 'true',
	), $__compilerTemp10)),
		'afterhint' => 'For multiple selections, hold down Ctrl (Command for Macs) while clicking selections. ',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_tag][rule]',
		'value' => 'thread_tag',
		'selected' => $__vars['criteria']['thread_tag'],
		'label' => 'Thread tag is' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[thread_tag][data][tag]',
		'value' => $__vars['criteria']['thread_tag']['tag'],
	))),
		'afterhint' => 'Separate multiple tags by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_tag_not][rule]',
		'value' => 'thread_tag_not',
		'selected' => $__vars['criteria']['thread_tag_not'],
		'label' => 'Thread tag is NOT' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[thread_tag_not][data][tag]',
		'value' => $__vars['criteria']['thread_tag_not']['tag'],
	))),
		'afterhint' => 'Separate multiple tags by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_title][rule]',
		'value' => 'thread_title',
		'selected' => $__vars['criteria']['thread_title'],
		'label' => 'Thread title contains' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[thread_title][data][title]',
		'value' => $__vars['criteria']['thread_title']['title'],
	))),
		'afterhint' => 'Separate multiple keywords by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_title_not][rule]',
		'value' => 'thread_title_not',
		'selected' => $__vars['criteria']['thread_title_not'],
		'label' => 'Thread title does NOT contains' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[thread_title_not][data][title]',
		'value' => $__vars['criteria']['thread_title_not']['title'],
	))),
		'afterhint' => 'Separate multiple keywords by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_author][rule]',
		'value' => 'thread_author',
		'selected' => $__vars['criteria']['thread_author'],
		'label' => 'Thread author is' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[thread_author][data][author]',
		'value' => $__vars['criteria']['thread_author']['author'],
		'data-xf-init' => 'auto-complete',
	))),
		'afterhint' => 'Separate multiple usernames by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_author_not][rule]',
		'value' => 'thread_author_not',
		'selected' => $__vars['criteria']['thread_author_not'],
		'label' => 'Thread author is NOT' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[thread_author_not][data][author]',
		'value' => $__vars['criteria']['thread_author_not']['author'],
		'data-xf-init' => 'auto-complete',
	))),
		'afterhint' => 'Separate multiple usernames by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_author_user_groups][rule]',
		'value' => 'thread_author_user_groups',
		'selected' => $__vars['criteria']['thread_author_user_groups'],
		'label' => 'Thread author is a member of any of the selected user groups' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'position_criteria[thread_author_user_groups][data][user_group_ids]',
		'size' => '4',
		'multiple' => 'true',
		'value' => $__vars['criteria']['thread_author_user_groups']['user_group_ids'],
	), $__compilerTemp13)),
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_author_not_user_groups][rule]',
		'value' => 'thread_author_not_user_groups',
		'selected' => $__vars['criteria']['thread_author_not_user_groups'],
		'label' => 'Thread author is NOT a member of any of the selected user groups' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'position_criteria[thread_author_not_user_groups][data][user_group_ids]',
		'size' => '4',
		'multiple' => 'true',
		'value' => $__vars['criteria']['thread_author_not_user_groups']['user_group_ids'],
	), $__compilerTemp15)),
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_id][rule]',
		'value' => 'thread_id',
		'selected' => $__vars['criteria']['thread_id'],
		'label' => 'Thread ID is' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[thread_id][data][id]',
		'value' => $__vars['criteria']['thread_id']['id'],
	))),
		'afterhint' => 'Separate multiple IDs by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_id_not][rule]',
		'value' => 'thread_id_not',
		'selected' => $__vars['criteria']['thread_id_not'],
		'label' => 'Thread ID is NOT' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[thread_id_not][data][id]',
		'value' => ($__vars['criteria']['thread_id_not']['id'] ?: $__vars['xf']['options']['siropuAdsManagerThreadIdNot']),
	))),
		'afterhint' => 'Separate multiple IDs by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[first_post][rule]',
		'value' => 'first_post',
		'selected' => $__vars['criteria']['first_post'],
		'label' => 'First posts contains' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[first_post][data][message]',
		'value' => $__vars['criteria']['first_post']['message'],
	))),
		'afterhint' => 'Separate multiple keywords by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[first_post_not][rule]',
		'value' => 'first_post_not',
		'selected' => $__vars['criteria']['first_post_not'],
		'label' => 'First post does NOT contains' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[first_post_not][data][message]',
		'value' => $__vars['criteria']['first_post_not']['message'],
	))),
		'afterhint' => 'Separate multiple keywords by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[last_post_older_than][rule]',
		'value' => 'last_post_older_than',
		'selected' => $__vars['criteria']['last_post_older_than'],
		'label' => 'Last post is older than X days' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formNumberBox(array(
		'name' => 'position_criteria[last_post_older_than][data][days]',
		'value' => $__vars['criteria']['last_post_older_than']['days'],
		'min' => '1',
	))),
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[last_post_not_older_than][rule]',
		'value' => 'last_post_not_older_than',
		'selected' => $__vars['criteria']['last_post_not_older_than'],
		'label' => 'Last post is NOT older than X days' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formNumberBox(array(
		'name' => 'position_criteria[last_post_not_older_than][data][days]',
		'value' => $__vars['criteria']['last_post_not_older_than']['days'],
		'min' => '1',
	))),
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_older_than][rule]',
		'value' => 'thread_older_than',
		'selected' => $__vars['criteria']['thread_older_than'],
		'label' => 'Thread is older than X days' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formNumberBox(array(
		'name' => 'position_criteria[thread_older_than][data][days]',
		'value' => $__vars['criteria']['thread_older_than']['days'],
		'min' => '1',
	))),
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_not_older_than][rule]',
		'value' => 'thread_not_older_than',
		'selected' => $__vars['criteria']['thread_not_older_than'],
		'label' => 'Thread is NOT older than X days' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formNumberBox(array(
		'name' => 'position_criteria[thread_not_older_than][data][days]',
		'value' => $__vars['criteria']['thread_not_older_than']['days'],
		'min' => '1',
	))),
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[is_closed][rule]',
		'value' => 'is_closed',
		'selected' => $__vars['criteria']['is_closed'],
		'label' => 'Thread is closed',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[is_not_closed][rule]',
		'value' => 'is_not_closed',
		'selected' => $__vars['criteria']['is_not_closed'],
		'label' => 'Thread is NOT closed',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[is_sticky][rule]',
		'value' => 'is_sticky',
		'selected' => $__vars['criteria']['is_sticky'],
		'label' => 'Thread is sticky',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[is_not_sticky][rule]',
		'value' => 'is_not_sticky',
		'selected' => $__vars['criteria']['is_not_sticky'],
		'label' => 'Thread is NOT sticky',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[author_ad_owner][rule]',
		'value' => 'author_ad_owner',
		'selected' => $__vars['criteria']['author_ad_owner'],
		'label' => 'Thread author is the AD owner',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[thread_custom_fields][rule]',
		'value' => 'thread_custom_fields',
		'selected' => $__vars['criteria']['thread_custom_fields'],
		'label' => 'Has custom fields' . $__vars['xf']['language']['ellipsis'],
		'data-hide' => 'true',
		'_dependent' => array('
					' . $__compilerTemp17 . '
				'),
		'_type' => 'option',
	)), array(
		'label' => 'Threads',
		'hint' => 'Available in thread view.',
	)) . '

		<hr class="formRowSep" />

		';
	$__compilerTemp21 = array();
	$__compilerTemp22 = $__templater->method($__vars['xf']['samAdmin'], 'getUserGroupTitlePairs', array());
	if ($__templater->isTraversable($__compilerTemp22)) {
		foreach ($__compilerTemp22 AS $__vars['userGroupId'] => $__vars['userGroupTitle']) {
			$__compilerTemp21[] = array(
				'value' => $__vars['userGroupId'],
				'label' => $__templater->escape($__vars['userGroupTitle']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp23 = array();
	$__compilerTemp24 = $__templater->method($__vars['xf']['samAdmin'], 'getUserGroupTitlePairs', array());
	if ($__templater->isTraversable($__compilerTemp24)) {
		foreach ($__compilerTemp24 AS $__vars['userGroupId'] => $__vars['userGroupTitle']) {
			$__compilerTemp23[] = array(
				'value' => $__vars['userGroupId'],
				'label' => $__templater->escape($__vars['userGroupTitle']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'position_criteria[post_author][rule]',
		'value' => 'post_author',
		'selected' => $__vars['criteria']['post_author'],
		'label' => 'Post author is' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[post_author][data][author]',
		'value' => $__vars['criteria']['post_author']['author'],
		'data-xf-init' => 'auto-complete',
	))),
		'afterhint' => 'Separate multiple usernames by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[post_author_not][rule]',
		'value' => 'post_author_not',
		'selected' => $__vars['criteria']['post_author_not'],
		'label' => 'Post author is NOT' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[post_author_not][data][author]',
		'value' => $__vars['criteria']['post_author_not']['author'],
		'data-xf-init' => 'auto-complete',
	))),
		'afterhint' => 'Separate multiple usernames by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[post_author_user_groups][rule]',
		'value' => 'post_author_user_groups',
		'selected' => $__vars['criteria']['post_author_user_groups'],
		'label' => 'Post author is a member of any of the selected user groups' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'position_criteria[post_author_user_groups][data][user_group_ids]',
		'size' => '4',
		'multiple' => 'true',
		'value' => $__vars['criteria']['post_author_user_groups']['user_group_ids'],
	), $__compilerTemp21)),
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[post_author_not_user_groups][rule]',
		'value' => 'post_author_not_user_groups',
		'selected' => $__vars['criteria']['post_author_not_user_groups'],
		'label' => 'Post author is NOT a member of any of the selected user groups' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formSelect(array(
		'name' => 'position_criteria[post_author_not_user_groups][data][user_group_ids]',
		'size' => '4',
		'multiple' => 'true',
		'value' => $__vars['criteria']['post_author_not_user_groups']['user_group_ids'],
	), $__compilerTemp23)),
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[post][rule]',
		'value' => 'post',
		'selected' => $__vars['criteria']['post'],
		'label' => 'Post contains' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[post][data][message]',
		'value' => $__vars['criteria']['post']['message'],
	))),
		'afterhint' => 'Separate multiple keywords by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[post_not][rule]',
		'value' => 'post_not',
		'selected' => $__vars['criteria']['post_not'],
		'label' => 'Post does NOT contains' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[post_not][data][message]',
		'value' => $__vars['criteria']['post_not']['message'],
	))),
		'afterhint' => 'Separate multiple keywords by comma.',
		'_type' => 'option',
	)), array(
		'label' => 'Posts',
		'hint' => 'Available in thread view, conversation view and member view for dynamic positions within the results.',
	)) . '

		';
	if ($__templater->func('is_addon_active', array('XFRM', ), false)) {
		$__finalCompiled .= '
			<hr class="formRowSep" />

			' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'position_criteria[resource_id][rule]',
			'value' => 'resource_id',
			'selected' => $__vars['criteria']['resource_id'],
			'label' => 'Resource ID is' . $__vars['xf']['language']['label_separator'],
			'_dependent' => array($__templater->formTextBox(array(
			'name' => 'position_criteria[resource_id][data][id]',
			'value' => $__vars['criteria']['resource_id']['id'],
		))),
			'afterhint' => 'Separate multiple IDs by comma.',
			'_type' => 'option',
		),
		array(
			'name' => 'position_criteria[resource_id_not][rule]',
			'value' => 'resource_id_not',
			'selected' => $__vars['criteria']['resource_id_not'],
			'label' => 'Resource ID is NOT' . $__vars['xf']['language']['label_separator'],
			'_dependent' => array($__templater->formTextBox(array(
			'name' => 'position_criteria[resource_id_not][data][id]',
			'value' => $__vars['criteria']['resource_id_not']['id'],
		))),
			'afterhint' => 'Separate multiple IDs by comma.',
			'_type' => 'option',
		)), array(
			'label' => 'Resources',
			'hint' => 'Available in resource view.',
		)) . '
		';
	}
	$__finalCompiled .= '

		<hr class="formRowSep" />

		' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'position_criteria[keyword][rule]',
		'value' => 'keyword',
		'selected' => $__vars['criteria']['keyword'],
		'label' => 'Keyword is' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[keyword][data][keyword]',
		'value' => $__vars['criteria']['keyword']['keyword'],
	))),
		'afterhint' => 'Separate multiple keywords by comma.',
		'_type' => 'option',
	),
	array(
		'name' => 'position_criteria[keyword_not][rule]',
		'value' => 'keyword_not',
		'selected' => $__vars['criteria']['keyword_not'],
		'label' => 'Keyword is NOT' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array($__templater->formTextBox(array(
		'name' => 'position_criteria[keyword_not][data][keyword]',
		'value' => $__vars['criteria']['keyword_not']['keyword'],
	))),
		'afterhint' => 'Separate multiple keywords by comma.',
		'_type' => 'option',
	)), array(
		'label' => 'Search results',
		'hint' => 'Available in search view.',
	)) . '

		<hr class="formRowSep" />

		';
	if ($__templater->func('is_addon_active', array('XenAddons/AMS', ), false)) {
		$__finalCompiled .= '
			' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'position_criteria[ams_article_id][rule]',
			'value' => 'ams_article_id',
			'selected' => $__vars['criteria']['ams_article_id'],
			'label' => 'Article ID is' . $__vars['xf']['language']['label_separator'],
			'_dependent' => array($__templater->formTextBox(array(
			'name' => 'position_criteria[ams_article_id][data][id]',
			'value' => $__vars['criteria']['ams_article_id']['id'],
		))),
			'afterhint' => 'Separate multiple IDs by comma.',
			'_type' => 'option',
		),
		array(
			'name' => 'position_criteria[ams_article_id_not][rule]',
			'value' => 'ams_article_id_not',
			'selected' => $__vars['criteria']['ams_article_id_not'],
			'label' => 'Article ID is NOT' . $__vars['xf']['language']['label_separator'],
			'_dependent' => array($__templater->formTextBox(array(
			'name' => 'position_criteria[ams_article_id_not][data][id]',
			'value' => $__vars['criteria']['ams_article_id_not']['id'],
		))),
			'afterhint' => 'Separate multiple IDs by comma.',
			'_type' => 'option',
		)), array(
			'label' => 'Article Management System',
			'hint' => 'Available in Bob\'s AMS article view',
		)) . '

			<hr class="formRowSep" />
		';
	}
	$__finalCompiled .= '

		';
	if ($__templater->func('is_addon_active', array('XenAddons/Showcase', ), false)) {
		$__finalCompiled .= '
			' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'position_criteria[showcase_id][rule]',
			'value' => 'showcase_id',
			'selected' => $__vars['criteria']['showcase_id'],
			'label' => 'Showcase ID is' . $__vars['xf']['language']['label_separator'],
			'_dependent' => array($__templater->formTextBox(array(
			'name' => 'position_criteria[showcase_id][data][id]',
			'value' => $__vars['criteria']['showcase_id']['id'],
		))),
			'afterhint' => 'Separate multiple IDs by comma.',
			'_type' => 'option',
		),
		array(
			'name' => 'position_criteria[showcase_id_not][rule]',
			'value' => 'showcase_id_not',
			'selected' => $__vars['criteria']['showcase_id_not'],
			'label' => 'Showcase ID is NOT' . $__vars['xf']['language']['label_separator'],
			'_dependent' => array($__templater->formTextBox(array(
			'name' => 'position_criteria[showcase_id_not][data][id]',
			'value' => $__vars['criteria']['showcase_id_not']['id'],
		))),
			'afterhint' => 'Separate multiple IDs by comma.',
			'_type' => 'option',
		)), array(
			'label' => 'Showcase',
			'hint' => 'Available in Bob\'s Showcase item view',
		)) . '

			<hr class="formRowSep" />
		';
	}
	$__finalCompiled .= '

		' . $__templater->formHiddenVal('position_criteria[minimum_results][rule]', 'minimum_results', array(
	)) . '
		' . $__templater->formNumberBoxRow(array(
		'name' => 'position_criteria[minimum_results][data][minimum]',
		'value' => $__vars['criteria']['minimum_results']['minimum'],
		'size' => '5',
		'min' => '1',
		'step' => '1',
	), array(
		'label' => 'Minimum results on page',
		'explain' => 'The minimum number of results on page in forum view, thread view, conversation view, member view, tag view, search results, in order for the ad to display.',
	)) . '

		' . $__templater->formHiddenVal('position_criteria[maximum_results][rule]', 'maximum_results', array(
	)) . '
		' . $__templater->formNumberBoxRow(array(
		'name' => 'position_criteria[maximum_results][data][maximum]',
		'value' => $__vars['criteria']['maximum_results']['maximum'],
		'size' => '5',
		'min' => '0',
		'step' => '1',
	), array(
		'label' => 'Maximum results on page',
		'explain' => 'The maximum number of results on page in forum view, thread view, conversation view, member view, tag view, search results, in order for the ad to display.',
	)) . '

		<hr class="formRowSep" />

		' . $__templater->formHiddenVal('position_criteria[page_number][rule]', 'page_number', array(
	)) . '
		' . $__templater->formNumberBoxRow(array(
		'name' => 'position_criteria[page_number][data][number]',
		'value' => $__vars['criteria']['page_number']['number'],
		'size' => '5',
		'min' => '0',
		'step' => '1',
	), array(
		'label' => 'Page number is',
		'explain' => 'This option allow you to display the ad only if the page number matches. Set to 0 to display on any page.',
	)) . '

		' . $__templater->formHiddenVal('position_criteria[page_number_not][rule]', 'page_number_not', array(
	)) . '
		' . $__templater->formNumberBoxRow(array(
		'name' => 'position_criteria[page_number_not][data][number]',
		'value' => $__vars['criteria']['page_number_not']['number'],
		'size' => '5',
		'min' => '0',
		'step' => '1',
	), array(
		'label' => 'Page number is NOT',
		'explain' => 'This option allow you to display the ad only if the page number does not match. Set to 0 to display on any page.',
	)) . '

		' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'position_criteria[is_last_page][rule]',
		'value' => 'is_last_page',
		'selected' => $__vars['criteria']['is_last_page'],
		'label' => 'Page is last page',
		'_type' => 'option',
	)), array(
		'explain' => 'This option allows you to display the ad only if the current page is the last page in a thread or a conversation.',
	)) . '
	</li>
';
	return $__finalCompiled;
}
),
'device_tabs' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<a class="tabs-tab" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('criteriaDevice', ), true) . '">' . 'Device criteria' . '</a>
';
	return $__finalCompiled;
}
),
'device_panes' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'criteria' => '!',
		'data' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<li role="tabpanel" id="' . $__templater->func('unique_id', array('criteriaDevice', ), true) . '">
		';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['data']['deviceBrandList']['tablet'])) {
		foreach ($__vars['data']['deviceBrandList']['tablet'] AS $__vars['brand']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['brand'],
				'label' => $__templater->escape($__vars['brand']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp2 = array();
	if ($__templater->isTraversable($__vars['data']['deviceBrandList']['mobile'])) {
		foreach ($__vars['data']['deviceBrandList']['mobile'] AS $__vars['brand']) {
			$__compilerTemp2[] = array(
				'value' => $__vars['brand'],
				'label' => $__templater->escape($__vars['brand']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'device_criteria[desktop][rule]',
		'value' => 'desktop',
		'selected' => $__vars['criteria']['desktop'],
		'label' => 'Desktop',
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[tablet][rule]',
		'value' => 'tablet',
		'selected' => $__vars['criteria']['tablet'],
		'label' => 'Tablet',
		'data-hide' => 'true',
		'_dependent' => array('
					' . $__templater->formSelect(array(
		'name' => 'device_criteria[tablet][data][brand]',
		'value' => $__templater->filter($__vars['criteria']['tablet']['brand'], array(array('raw', array()),), false),
		'multiple' => 'true',
		'size' => '10',
	), $__compilerTemp1) . '
				'),
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[mobile][rule]',
		'value' => 'mobile',
		'selected' => $__vars['criteria']['mobile'],
		'label' => 'Mobile phone',
		'data-hide' => 'true',
		'_dependent' => array('
					' . $__templater->formSelect(array(
		'name' => 'device_criteria[mobile][data][brand]',
		'value' => $__templater->filter($__vars['criteria']['mobile']['brand'], array(array('raw', array()),), false),
		'multiple' => 'true',
		'size' => '10',
	), $__compilerTemp2) . '
				'),
		'_type' => 'option',
	)), array(
		'label' => 'Device type',
		'hint' => 'Optional',
	)) . '

		<hr class="formRowSep" />

		' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'device_criteria[ios][rule]',
		'value' => 'ios',
		'selected' => $__vars['criteria']['ios'],
		'label' => 'iOS',
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[android][rule]',
		'value' => 'android',
		'selected' => $__vars['criteria']['android'],
		'label' => 'Android',
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[windows][rule]',
		'value' => 'windows',
		'selected' => $__vars['criteria']['windows'],
		'label' => 'Windows',
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[macos][rule]',
		'value' => 'macos',
		'selected' => $__vars['criteria']['macos'],
		'label' => 'macOS',
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[linux][rule]',
		'value' => 'linux',
		'selected' => $__vars['criteria']['linux'],
		'label' => 'Linux',
		'_type' => 'option',
	)), array(
		'label' => 'Device platform',
		'hint' => 'Optional',
	)) . '

		<hr class="formRowSep" />

		' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'device_criteria[chrome][rule]',
		'value' => 'chrome',
		'selected' => $__vars['criteria']['chrome'],
		'label' => 'Chrome',
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[firefox][rule]',
		'value' => 'firefox',
		'selected' => $__vars['criteria']['firefox'],
		'label' => 'Firefox',
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[safari][rule]',
		'value' => 'safari',
		'selected' => $__vars['criteria']['safari'],
		'label' => 'Safari',
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[opera][rule]',
		'value' => 'opera',
		'selected' => $__vars['criteria']['opera'],
		'label' => 'Opera',
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[edge][rule]',
		'value' => 'edge',
		'selected' => $__vars['criteria']['edge'],
		'label' => 'Microsoft Edge',
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[ie][rule]',
		'value' => 'ie',
		'selected' => $__vars['criteria']['ie'],
		'label' => 'Internet Explorer',
		'_type' => 'option',
	),
	array(
		'name' => 'device_criteria[vivaldi][rule]',
		'value' => 'vivaldi',
		'selected' => $__vars['criteria']['vivaldi'],
		'label' => 'Vivaldi',
		'_type' => 'option',
	)), array(
		'label' => 'Device browser',
		'hint' => 'Optional',
	)) . '
	</li>
';
	return $__finalCompiled;
}
),
'geo_tabs' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<a class="tabs-tab" role="tab" tabindex="0" aria-controls="' . $__templater->func('unique_id', array('criteriaGeo', ), true) . '">' . 'Geo criteria' . '</a>
';
	return $__finalCompiled;
}
),
'geo_panes' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'criteria' => '!',
		'data' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->includeJs(array(
		'src' => 'siropu/am/admin.js',
		'min' => '1',
	));
	$__finalCompiled .= '

	<li role="tabpanel" id="' . $__templater->func('unique_id', array('criteriaGeo', ), true) . '">
		';
	if ($__vars['xf']['samAdmin'] AND (!$__templater->method($__vars['xf']['samAdmin'], 'isGeoLite2CityDb', array()))) {
		$__finalCompiled .= '
			<div class="blockMessage blockMessage--important blockMessage--iconic" style="margin-bottom: 0;">
				' . 'To use Geo criteria, you need to <a href="https://dev.maxmind.com/geoip/geoip2/geolite2/">download</a> the Geo Lite 2 City database and upload the file <b>GeoLite2-City.mmdb</b> to <b>src/addons/Siropu/AdsManager/Vendor/MaxMind</b>. Please note that this feature can be resource intensive depending on how busy your board is.' . '
			</div>
		';
	}
	$__finalCompiled .= '

		';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['data']['countryList'])) {
		foreach ($__vars['data']['countryList'] AS $__vars['continent']) {
			$__compilerTemp1[] = array(
				'label' => $__vars['continent']['continent'],
				'_type' => 'optgroup',
				'options' => array(),
			);
			end($__compilerTemp1); $__compilerTemp2 = key($__compilerTemp1);
			if ($__templater->isTraversable($__vars['continent']['countries'])) {
				foreach ($__vars['continent']['countries'] AS $__vars['countryId'] => $__vars['countryName']) {
					$__compilerTemp1[$__compilerTemp2]['options'][] = array(
						'value' => $__vars['countryId'],
						'label' => $__templater->escape($__vars['countryName']),
						'_type' => 'option',
					);
				}
			}
		}
	}
	$__compilerTemp3 = array();
	if ($__templater->isTraversable($__vars['data']['countryList'])) {
		foreach ($__vars['data']['countryList'] AS $__vars['continent']) {
			$__compilerTemp3[] = array(
				'label' => $__vars['continent']['continent'],
				'_type' => 'optgroup',
				'options' => array(),
			);
			end($__compilerTemp3); $__compilerTemp4 = key($__compilerTemp3);
			if ($__templater->isTraversable($__vars['continent']['countries'])) {
				foreach ($__vars['continent']['countries'] AS $__vars['countryId'] => $__vars['countryName']) {
					$__compilerTemp3[$__compilerTemp4]['options'][] = array(
						'value' => $__vars['countryId'],
						'label' => $__templater->escape($__vars['countryName']),
						'_type' => 'option',
					);
				}
			}
		}
	}
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'geo_criteria[country][rule]',
		'value' => 'country',
		'selected' => $__vars['criteria']['country'],
		'label' => 'Country is' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array('
					' . $__templater->formSelect(array(
		'name' => 'geo_criteria[country][data][country]',
		'value' => $__templater->filter($__vars['criteria']['country']['country'], array(array('raw', array()),), false),
		'multiple' => 'true',
		'size' => '10',
		'class' => 'js-countryIs',
	), $__compilerTemp1) . '
				', $__templater->callMacro(null, 'continent_selection', array(
		'data' => $__vars['data'],
		'select' => '.js-countryIs',
	), $__vars)),
		'_type' => 'option',
	),
	array(
		'name' => 'geo_criteria[country_not][rule]',
		'value' => 'country_not',
		'selected' => $__vars['criteria']['country_not'],
		'label' => 'Country is NOT' . $__vars['xf']['language']['label_separator'],
		'_dependent' => array('
					' . $__templater->formSelect(array(
		'name' => 'geo_criteria[country_not][data][country]',
		'value' => $__templater->filter($__vars['criteria']['country_not']['country'], array(array('raw', array()),), false),
		'multiple' => 'true',
		'size' => '10',
		'class' => 'js-countryIsNot',
	), $__compilerTemp3) . '
				', $__templater->callMacro(null, 'continent_selection', array(
		'data' => $__vars['data'],
		'select' => '.js-countryIsNot',
	), $__vars)),
		'_type' => 'option',
	)), array(
		'label' => 'Countries',
		'hint' => '
				' . 'Optional' . '
				<p>' . 'This product includes GeoLite2 data created by MaxMind, available from <a href="http://www.maxmind.com" target="_blank">http://www.maxmind.com</a>.' . '</p>
			',
	)) . '
	</li>
';
	return $__finalCompiled;
}
),
'continent_selection' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'data' => '!',
		'select' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<ul class="listInline" style="color: #444;">
		<li><b>' . 'Quick selection' . $__vars['xf']['language']['label_separator'] . '</b></li>
		';
	if ($__templater->isTraversable($__vars['data']['countryList'])) {
		foreach ($__vars['data']['countryList'] AS $__vars['continent']) {
			$__finalCompiled .= '
			<li>
				<label for="' . $__templater->escape($__vars['continent']['continent']) . '">
					<input type="checkbox" id="' . $__templater->escape($__vars['continent']['continent']) . '" data-xf-click="siropu-ads-manager-continent-selection" data-select="' . $__templater->escape($__vars['select']) . '"> ' . $__templater->escape($__vars['continent']['continent']) . '
				</label>
			</li>
		';
		}
	}
	$__finalCompiled .= '
	</ul>
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

' . '

' . '

' . '

';
	return $__finalCompiled;
}
);