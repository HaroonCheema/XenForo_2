<?php
// FROM HASH: 79a7aabb697c9a293781bd491cdd39dc
return array(
'extensions' => array('start' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'before_started_by' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'before_date_limit' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'before_type' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'before_sort' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
},
'end' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__vars['xf']['options']['altf_multi_prefix_search'] !== 'disabled') {
		$__compilerTemp1 .= '
	';
		if (!$__templater->test($__vars['prefixes'], 'empty', array())) {
			$__compilerTemp1 .= '
		<div class="menu-row menu-row--separated">
			' . 'Prefixes' . $__vars['xf']['language']['label_separator'] . '
			<div class="u-inputSpacer">
				' . $__templater->callMacro('prefix_macros', 'select', array(
				'prefixes' => $__vars['prefixes'],
				'type' => 'thread',
				'selected' => ($__vars['filterSet']['__prefix_ids'] ?: array()),
				'multiple' => true,
				'name' => 'thread_fields[__prefix_ids]',
				'noneLabel' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
			), $__vars) . '
			</div>
		</div>
	';
		}
		$__compilerTemp1 .= '
	';
	} else {
		$__compilerTemp1 .= '
		
';
		if ($__vars['xf']['options']['altf_custom_field_location'] == 'above_prefixes') {
			$__compilerTemp1 .= '
    ' . $__templater->includeTemplate('altf_thread_filter_popup_form', $__vars) . '
';
		}
		$__compilerTemp1 .= '
	';
	}
	$__compilerTemp2 = '';
	if ($__vars['xf']['options']['altf_additional_filters_location'] == 'above_prefixes') {
		$__compilerTemp2 .= '
    ' . $__templater->includeTemplate('altf_additional_filter_elements', $__vars) . '
';
	}
	$__compilerTemp3 = '';
	if (!$__vars['xf']['options']['altf_disable_default_filter_field']['prefix']) {
		$__compilerTemp3 .= '
    
	';
		if (!$__templater->test($__vars['prefixes'], 'empty', array())) {
			$__compilerTemp3 .= '
		<div class="menu-row menu-row--separated">
			' . 'Prefix' . $__vars['xf']['language']['label_separator'] . '
			<div class="u-inputSpacer">
				' . $__templater->callMacro('prefix_macros', 'select', array(
				'prefixes' => $__vars['prefixes'],
				'type' => 'thread',
				'selected' => ($__vars['filters']['prefix_id'] ? $__vars['filters']['prefix_id'] : 0),
				'name' => 'prefix_id',
				'noneLabel' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
			), $__vars) . '
			</div>
		</div>
	';
		}
		$__compilerTemp3 .= '

	' . $__templater->renderExtension('before_started_by', $__vars, $__extensions) . '

	
';
	}
	$__compilerTemp4 = '';
	if ($__vars['xf']['options']['altf_custom_field_location'] == 'above_started_by') {
		$__compilerTemp4 .= '
    ' . $__templater->includeTemplate('altf_thread_filter_popup_form', $__vars) . '
';
	}
	$__compilerTemp5 = '';
	if ($__vars['xf']['options']['altf_additional_filters_location'] == 'above_started_by') {
		$__compilerTemp5 .= '
    ' . $__templater->includeTemplate('altf_additional_filter_elements', $__vars) . '
';
	}
	$__compilerTemp6 = '';
	if (!$__vars['xf']['options']['altf_disable_default_filter_field']['startedBy']) {
		$__compilerTemp6 .= '
    
	<div class="menu-row menu-row--separated">
		<label for="ctrl_started_by">' . 'Started by' . $__vars['xf']['language']['label_separator'] . '</label>
		<div class="u-inputSpacer">
			' . $__templater->formTextBox(array(
			'name' => 'starter',
			'value' => ($__vars['starterFilter'] ? $__vars['starterFilter']['username'] : ''),
			'ac' => 'single',
			'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
			'id' => 'ctrl_started_by',
		)) . '
		</div>
	</div>

	' . $__templater->renderExtension('before_date_limit', $__vars, $__extensions) . '

	
';
	}
	$__compilerTemp7 = '';
	if ($__vars['xf']['options']['altf_custom_field_location'] == 'above_last_updated') {
		$__compilerTemp7 .= '
    ' . $__templater->includeTemplate('altf_thread_filter_popup_form', $__vars) . '
';
	}
	$__compilerTemp8 = '';
	if ($__vars['xf']['options']['altf_additional_filters_location'] == 'above_last_updated') {
		$__compilerTemp8 .= '
    ' . $__templater->includeTemplate('altf_additional_filter_elements', $__vars) . '
';
	}
	$__compilerTemp9 = '';
	if (!$__vars['xf']['options']['altf_disable_default_filter_field']['lastedUpdated']) {
		$__compilerTemp9 .= '
    
	<div class="menu-row menu-row--separated">
		<label for="ctrl_last_updated">' . 'Last updated' . $__vars['xf']['language']['label_separator'] . '</label>
		<div class="u-inputSpacer">
			';
		if ($__vars['filters']['no_date_limit']) {
			$__compilerTemp9 .= '
				';
			$__vars['lastDays'] = '';
			$__compilerTemp9 .= '
			';
		} else {
			$__compilerTemp9 .= '
				';
			$__vars['lastDays'] = ($__vars['filters']['last_days'] ?: $__vars['forum']['list_date_limit_days']);
			$__compilerTemp9 .= '
			';
		}
		$__compilerTemp9 .= '
			' . $__templater->formSelect(array(
			'name' => 'last_days',
			'value' => $__vars['lastDays'],
			'id' => 'ctrl_last_updated',
		), array(array(
			'value' => '-1',
			'label' => 'Any time',
			'_type' => 'option',
		),
		array(
			'value' => '7',
			'label' => '' . '7' . ' days',
			'_type' => 'option',
		),
		array(
			'value' => '14',
			'label' => '' . '14' . ' days',
			'_type' => 'option',
		),
		array(
			'value' => '30',
			'label' => '' . '30' . ' days',
			'_type' => 'option',
		),
		array(
			'value' => '60',
			'label' => '' . '2' . ' months',
			'_type' => 'option',
		),
		array(
			'value' => '90',
			'label' => '' . '3' . ' months',
			'_type' => 'option',
		),
		array(
			'value' => '182',
			'label' => '' . '6' . ' months',
			'_type' => 'option',
		),
		array(
			'value' => '365',
			'label' => '1 year',
			'_type' => 'option',
		))) . '
		</div>
	</div>

	' . $__templater->renderExtension('before_type', $__vars, $__extensions) . '

	
';
	}
	$__compilerTemp10 = '';
	if (!$__vars['xf']['options']['altf_disable_default_filter_field']['threadType']) {
		$__compilerTemp10 .= '
    
	';
		if ($__templater->func('count', array($__vars['allowedThreadTypes'], ), false) > 1) {
			$__compilerTemp10 .= '
		<div class="menu-row menu-row-separated">
			<label for="ctrl_thread_type">' . 'Thread type' . $__vars['xf']['language']['label_separator'] . '</label>
			<div class="u-inputSpacer">
				';
			$__compilerTemp11 = array(array(
				'value' => '',
				'label' => $__vars['xf']['language']['parenthesis_open'] . 'Any' . $__vars['xf']['language']['parenthesis_close'],
				'_type' => 'option',
			));
			if ($__templater->isTraversable($__vars['allowedThreadTypes'])) {
				foreach ($__vars['allowedThreadTypes'] AS $__vars['threadTypeId'] => $__vars['threadType']) {
					$__compilerTemp11[] = array(
						'value' => $__vars['threadTypeId'],
						'label' => $__templater->escape($__templater->method($__vars['threadType'], 'getTypeTitle', array())),
						'_type' => 'option',
					);
				}
			}
			$__compilerTemp10 .= $__templater->formSelect(array(
				'name' => 'thread_type',
				'value' => $__vars['filters']['thread_type'],
				'id' => 'ctrl_thread_type',
			), $__compilerTemp11) . '
			</div>
		</div>
	';
		}
		$__compilerTemp10 .= '

	' . $__templater->renderExtension('before_sort', $__vars, $__extensions) . '

	
';
	}
	$__compilerTemp12 = '';
	if ($__vars['xf']['options']['altf_custom_field_location'] == 'above_sort_by') {
		$__compilerTemp12 .= '
    ' . $__templater->includeTemplate('altf_thread_filter_popup_form', $__vars) . '
';
	}
	$__compilerTemp13 = '';
	if ($__vars['xf']['options']['altf_additional_filters_location'] == 'above_sort_by') {
		$__compilerTemp13 .= '
    ' . $__templater->includeTemplate('altf_additional_filter_elements', $__vars) . '
';
	}
	$__compilerTemp14 = '';
	if (!$__vars['xf']['options']['altf_disable_default_filter_field']['sortBy']) {
		$__compilerTemp14 .= '
    
	<div class="menu-row menu-row--separated">
		' . 'Sort by' . $__vars['xf']['language']['label_separator'] . '
		<div class="inputGroup u-inputSpacer">
			<span class="u-srOnly" id="ctrl_sort_by">' . 'Sort order' . '</span>
			';
		$__compilerTemp15 = array();
		if ($__templater->isTraversable($__vars['sortOptions'])) {
			foreach ($__vars['sortOptions'] AS $__vars['sortKey'] => $__vars['null']) {
				$__compilerTemp15[] = array(
					'value' => $__vars['sortKey'],
					'label' => $__templater->func('phrase_dynamic', array('forum_sort.' . $__vars['sortKey'], ), true),
					'_type' => 'option',
				);
			}
		}
		$__compilerTemp15[] = array(
			'value' => 'rating',
			'label' => 'Rating',
			'_type' => 'option',
		);
		if ($__templater->isTraversable($__vars['sortableFields'])) {
			foreach ($__vars['sortableFields'] AS $__vars['fieldId'] => $__vars['field']) {
				$__compilerTemp15[] = array(
					'value' => $__vars['filter_name'] . '_' . $__vars['fieldId'],
					'label' => $__templater->escape($__vars['field']['title']),
					'_type' => 'option',
				);
			}
		}
		$__compilerTemp14 .= $__templater->formSelect(array(
			'name' => 'order',
			'value' => ($__vars['filters']['order'] ?: $__vars['forum']['default_sort_order']),
			'aria-labelledby' => 'ctrl_sort_by',
		), $__compilerTemp15) . '
			<span class="inputGroup-splitter"></span>
			<span class="u-srOnly" id="ctrl_sort_direction">' . 'Sort direction' . '</span>
			' . $__templater->formSelect(array(
			'name' => 'direction',
			'value' => ($__vars['filters']['direction'] ?: $__vars['forum']['default_sort_direction']),
			'aria-labelledby' => 'ctrl_sort_direction',
		), array(array(
			'value' => 'desc',
			'label' => 'Descending',
			'_type' => 'option',
		),
		array(
			'value' => 'asc',
			'label' => 'Ascending',
			'_type' => 'option',
		))) . '
		</div>
	</div>

	' . $__templater->renderExtension('end', $__vars, $__extensions) . '

	
';
	}
	$__compilerTemp16 = '';
	if ($__vars['xf']['options']['altf_additional_filters_location'] == 'below_sort_by') {
		$__compilerTemp16 .= '
    ' . $__templater->includeTemplate('altf_additional_filter_elements', $__vars) . '
';
	}
	$__compilerTemp17 = '';
	if ($__vars['xf']['options']['altf_custom_field_location'] == 'below_sort_by') {
		$__compilerTemp17 .= '
    ' . $__templater->includeTemplate('altf_thread_filter_popup_form', $__vars) . '
';
	}
	$__compilerTemp18 = '';
	if ($__vars['xf']['options']['altf_total_count_indicator']) {
		$__compilerTemp18 .= '
		' . $__templater->includeTemplate('altf_total_count_indicator', $__vars) . '
	';
	}
	$__finalCompiled .= $__templater->form('
	' . $__templater->renderExtension('start', $__vars, $__extensions) . '

	' . '
	' . $__compilerTemp1 . '
' . $__compilerTemp2 . '
' . $__compilerTemp3 . '
' . '
' . $__compilerTemp4 . '
' . $__compilerTemp5 . '
' . $__compilerTemp6 . '
' . '
' . $__compilerTemp7 . '
' . $__compilerTemp8 . '
' . $__compilerTemp9 . '
' . '
' . $__compilerTemp10 . '
' . '
' . $__compilerTemp12 . '
' . $__compilerTemp13 . '
' . $__compilerTemp14 . '
' . $__compilerTemp16 . '
' . $__compilerTemp17 . '
<div class="menu-row menu-row--separated">
	' . $__compilerTemp18 . '
</div>
<div class="menu-footer">
' . $__templater->includeTemplate('altf_clear_button', $__vars) . '
</div>
	' . $__templater->formHiddenVal('apply', '1', array(
	)) . '
', array(
		'action' => $__templater->func('link', array('forums/filters', $__vars['forum'], ), false),
	));
	return $__finalCompiled;
}
);