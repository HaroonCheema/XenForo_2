<?php
// FROM HASH: 2f3ae4fe222fdbf1d2f16b5abb07c9ef
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
'end' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	
	return $__finalCompiled;
}),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeJs(array(
		'src' => 'vendor/select2/select2.full.min.js',
	));
	$__finalCompiled .= '
';
	$__templater->inlineJs('
	$(document).ready(function() {
	$(\'.js-example-basic-single\').select2({
	containerCssClass: "input" 
	});
	});
');
	$__finalCompiled .= '

';
	$__templater->includeCss('select2.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('altf_select2.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'prod' => 'xf/token_input-compiled.js',
		'dev' => 'vendor/select2/select2.full.min.js, xf/token_input.js',
	));
	$__finalCompiled .= '

';
	$__templater->inlineJs('
	jQuery.extend(XF.phrases, {
	s2_error_loading: "' . $__templater->filter('The results could not be loaded.', array(array('escape', array('js', )),), false) . '",
	s2_input_too_long: "' . $__templater->filter('Please delete {count} character(s).', array(array('escape', array('js', )),), false) . '",
	s2_input_too_short: "' . $__templater->filter('Please enter {count} or more characters.', array(array('escape', array('js', )),), false) . '",
	s2_loading_more: "' . $__templater->filter('Loading more results...', array(array('escape', array('js', )),), false) . '",
	s2_maximum_selected: "' . $__templater->filter('You can only select {count} item(s).', array(array('escape', array('js', )),), false) . '",
	s2_no_results: "' . $__templater->filter('No results found.', array(array('escape', array('js', )),), false) . '",
	s2_searching: "' . $__templater->filter('Searching...', array(array('escape', array('js', )),), false) . '"
	});
');
	$__finalCompiled .= '
';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['forums'])) {
		foreach ($__vars['forums'] AS $__vars['nodeId'] => $__vars['node']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['nodeId'],
				'label' => $__templater->escape($__vars['node']['title']),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp2 = '';
	if ($__vars['filters']['no_date_limit']) {
		$__compilerTemp2 .= '
				';
		$__vars['lastDays'] = '';
		$__compilerTemp2 .= '
				';
	} else {
		$__compilerTemp2 .= '
				';
		$__vars['lastDays'] = ($__vars['filters']['last_days'] ?: $__vars['forum']['list_date_limit_days']);
		$__compilerTemp2 .= '
			';
	}
	$__compilerTemp3 = array();
	if ($__templater->isTraversable($__vars['sortOptions'])) {
		foreach ($__vars['sortOptions'] AS $__vars['sortKey'] => $__vars['null']) {
			$__compilerTemp3[] = array(
				'value' => $__vars['sortKey'],
				'label' => $__templater->func('phrase_dynamic', array('forum_sort.' . $__vars['sortKey'], ), true),
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp4 = array();
	$__compilerTemp5 = $__vars['prefixGroup1'];
	if ($__templater->isTraversable($__compilerTemp5)) {
		foreach ($__compilerTemp5 AS $__vars['prefixId'] => $__vars['prefix']) {
			$__compilerTemp4[] = array(
				'value' => $__vars['prefixId'],
				'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
				'data-prefix-class' => $__vars['prefix']['css_class'],
				'data-has-help' => $__vars['prefix']['has_usage_help'],
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp6 = array();
	$__compilerTemp7 = $__vars['prefixGroup2'];
	if ($__templater->isTraversable($__compilerTemp7)) {
		foreach ($__compilerTemp7 AS $__vars['prefixId'] => $__vars['prefix']) {
			$__compilerTemp6[] = array(
				'value' => $__vars['prefixId'],
				'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
				'data-prefix-class' => $__vars['prefix']['css_class'],
				'data-has-help' => $__vars['prefix']['has_usage_help'],
				'_type' => 'option',
			);
		}
	}
	$__compilerTemp8 = array();
	$__compilerTemp9 = $__vars['prefixGroup3'];
	if ($__templater->isTraversable($__compilerTemp9)) {
		foreach ($__compilerTemp9 AS $__vars['prefixId'] => $__vars['prefix']) {
			$__compilerTemp8[] = array(
				'value' => $__vars['prefixId'],
				'label' => $__templater->func('prefix_title', array('thread', $__vars['prefixId'], ), true),
				'data-prefix-class' => $__vars['prefix']['css_class'],
				'data-has-help' => $__vars['prefix']['has_usage_help'],
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	' . $__templater->renderExtension('start', $__vars, $__extensions) . '


	<div class="menu-row menu-row--separated">
		' . 'Nodes' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formSelect(array(
		'name' => 'thread_fields[node_ids]',
		'value' => ($__vars['conditions']['thread_fields']['node_ids'] ?: array()),
		'multiple' => true,
		'class' => 'input js-example-basic-single',
		'title' => 'Nodes',
	), $__compilerTemp1) . '
		</div>
	</div>

	' . '

	' . $__templater->renderExtension('before_started_by', $__vars, $__extensions) . '

	' . '

	' . $__templater->renderExtension('before_date_limit', $__vars, $__extensions) . '

	' . '
	<div class="menu-row menu-row--separated">
		<label for="ctrl_last_updated">' . 'Last updated' . $__vars['xf']['language']['label_separator'] . '</label>
		<div class="u-inputSpacer">
			' . $__compilerTemp2 . '
			' . $__templater->formSelect(array(
		'name' => 'last_days',
		'value' => $__vars['conditions']['last_days'],
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



	' . '
	<div class="menu-row menu-row--separated">
		' . 'Sort by' . $__vars['xf']['language']['label_separator'] . '
		<div class="inputGroup u-inputSpacer">
			<span class="u-srOnly" id="ctrl_sort_by">' . 'Sort order' . '</span>
			' . $__templater->formSelect(array(
		'name' => 'order',
		'value' => ($__vars['conditions']['order'] ?: $__vars['forum']['default_sort_order']),
		'aria-labelledby' => 'ctrl_sort_by',
	), $__compilerTemp3) . '
			<span class="inputGroup-splitter"></span>
			<span class="u-srOnly" id="ctrl_sort_direction">' . 'Sort direction' . '</span>
			' . $__templater->formSelect(array(
		'name' => 'direction',
		'value' => ($__vars['conditions']['direction'] ?: $__vars['forum']['default_sort_direction']),
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

	<div class="menu-row menu-row--separated">
		<label for="ctrl_started_by">' . 'Keywords' . $__vars['xf']['language']['label_separator'] . '</label>
		<div class="u-inputSpacer">
			' . $__templater->formTextBox(array(
		'name' => 'keywords',
		'value' => $__vars['conditions']['keywords'],
	)) . '
		</div>
	</div>

	<div class="menu-row menu-row--separated">
		<label for="ctrl_started_by">' . 'Tags' . $__vars['xf']['language']['label_separator'] . '</label>
		<div class="u-inputSpacer">
			' . $__templater->formTokenInput(array(
		'name' => 'tags',
		'value' => $__vars['conditions']['tags'],
		'href' => $__templater->func('link', array('misc/tag-auto-complete', ), false),
		'min-length' => $__vars['xf']['options']['tagLength']['min'],
		'max-length' => $__vars['xf']['options']['tagLength']['max'],
		'max-tokens' => $__vars['xf']['options']['maxContentTags'],
	)) . '
		</div>
	</div>


	<div class="menu-row menu-row--separated">
		<label for="ctrl_started_by">' . 'Exclude Tags' . $__vars['xf']['language']['label_separator'] . '</label>
		<div class="u-inputSpacer">
			' . $__templater->formTokenInput(array(
		'name' => 'extags',
		'value' => $__vars['conditions']['extags'],
		'href' => $__templater->func('link', array('misc/tag-auto-complete', ), false),
		'min-length' => $__vars['xf']['options']['tagLength']['min'],
		'max-length' => $__vars['xf']['options']['tagLength']['max'],
		'max-tokens' => $__vars['xf']['options']['maxContentTags'],
	)) . '
			
			' . '
		</div>
	</div>






	<div class="menu-row menu-row--separated">
		' . 'Prefix' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formSelect(array(
		'name' => 'prefix_ids1',
		'value' => ($__vars['conditions']['prefix_ids1'] ?: array()),
		'multiple' => true,
		'class' => 'input js-example-basic-single',
		'title' => 'Prefix',
	), $__compilerTemp4) . '
		</div>
	</div>

	<div class="menu-row menu-row--separated">
		' . 'Prefix' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formSelect(array(
		'name' => 'prefix_ids2',
		'value' => ($__vars['conditions']['prefix_ids2'] ?: array()),
		'multiple' => true,
		'class' => 'input js-example-basic-single',
		'title' => 'Prefix',
	), $__compilerTemp6) . '
		</div>
	</div>
	<div class="menu-row menu-row--separated">
		' . 'Prefix' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formSelect(array(
		'name' => 'prefix_ids3',
		'value' => ($__vars['conditions']['prefix_ids3'] ?: array()),
		'multiple' => true,
		'class' => 'input js-example-basic-single',
		'title' => 'Prefix',
	), $__compilerTemp8) . '
		</div>
	</div>



	' . $__templater->renderExtension('end', $__vars, $__extensions) . '

	<div class="menu-footer">
		<span class="menu-footer-controls">
			' . $__templater->button('Filter', array(
		'type' => 'submit',
		'class' => 'button--primary',
	), '', array(
	)) . '
		</span>
	</div>
	' . $__templater->formHiddenVal('apply', '1', array(
	)) . '
', array(
		'action' => $__templater->func('link', array('latest-contents', $__vars['forum'], ), false),
	));
	return $__finalCompiled;
}
);