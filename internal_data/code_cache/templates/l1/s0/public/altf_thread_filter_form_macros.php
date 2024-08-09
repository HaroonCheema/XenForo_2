<?php
// FROM HASH: a66c27a5ec2eff48bc8b8c69c59c102f
return array(
'macros' => array('select2_setup' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ' . '
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
	return $__finalCompiled;
}
),
'field_form_setup' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ' . '
    ';
	$__templater->includeCss('altf_filter_setup.less');
	$__finalCompiled .= '
    ';
	$__templater->includeCss('altf_thread_field.less');
	$__finalCompiled .= '
    ';
	$__templater->includeJs(array(
		'src' => 'AL/FilterFramework/filter_reload.js',
		'min' => '0',
	));
	$__finalCompiled .= '
    ';
	$__templater->includeJs(array(
		'src' => 'AL/FilterFramework/column_fix.js',
		'min' => '0',
	));
	$__finalCompiled .= '
    ';
	if ($__vars['xf']['options']['altf_filterable_lists']) {
		$__finalCompiled .= '
        ' . $__templater->callMacro(null, 'select2_setup', array(), $__vars) . '
    ';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'field_form' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'fields' => '!',
		'set' => '!',
		'reloadTarget' => '',
		'namePrefix' => 'thread_fields',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	$__templater->includeCss('altf_thread_field.less');
	$__finalCompiled .= '
    ';
	$__templater->includeCss('altf_select2.less');
	$__finalCompiled .= '
    ';
	$__templater->includeJs(array(
		'src' => 'AL/FilterFramework/filter_reload.js',
		'min' => '0',
	));
	$__finalCompiled .= '
    <div data-xf-init="filterFormContainer filter-form-column-fix" data-reload-target="' . $__templater->escape($__vars['reloadTarget']) . '"
         data-auto-reload="' . $__templater->escape($__vars['xf']['options']['altf_auto_reload']) . '"
         data-total-count-indicator="' . $__templater->escape($__vars['xf']['options']['altf_total_count_indicator']) . '"
         data-filterable-lists="' . $__templater->escape($__vars['xf']['options']['altf_filterable_lists']) . '"
         data-filterable-list-api="' . $__templater->func('link', array('forums/load-selection-options', ), true) . '"
    ></div>
    ';
	if ($__vars['xf']['options']['altf_keyword_search'] !== 'disabled') {
		$__finalCompiled .= '
        <div class="menu-row menu-row--separated menu-row--keywords">
            <label for="ctrl_started_by">' . 'Keywords' . $__vars['xf']['language']['label_separator'] . '</label>
            <div class="u-inputSpacer">
                ' . $__templater->formTextBox(array(
			'name' => 'thread_fields[__keywords]',
			'value' => $__vars['set']['__keywords'],
		)) . '
            </div>
        </div>
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__vars['xf']['options']['altf_tag_search'] !== 'disabled') {
		$__finalCompiled .= '
        <div class="menu-row menu-row--separated">
            <label for="ctrl_started_by">' . 'Tags' . $__vars['xf']['language']['label_separator'] . '</label>
            <div class="u-inputSpacer">
                ' . $__templater->formTokenInput(array(
			'name' => 'thread_fields[__tags]',
			'value' => $__vars['set']['__tags'],
			'href' => $__templater->func('link', array('misc/tag-auto-complete', ), false),
			'min-length' => $__vars['xf']['options']['tagLength']['min'],
			'max-length' => $__vars['xf']['options']['tagLength']['max'],
			'max-tokens' => $__vars['xf']['options']['maxContentTags'],
		)) . '
            </div>
        </div>
    ';
	}
	$__finalCompiled .= '
    ';
	if ($__templater->isTraversable($__vars['fields'])) {
		foreach ($__vars['fields'] AS $__vars['fieldId'] => $__vars['fieldDefinition']) {
			$__finalCompiled .= '
        <div class="menu-row menu-row--separated customFieldContainer customFieldContainer--id-' . $__templater->escape($__vars['fieldDefinition']['field_id']) . ' customFieldContainer--' . $__templater->escape($__vars['fieldDefinition']['field_type']) . ' ' . $__templater->escape($__templater->method($__templater->method($__vars['fieldDefinition'], 'getFacetData', array()), 'getContainerClass', array($__vars['fieldDefinition'], ))) . ' threadFieldContainer filterTemplate--' . $__templater->escape($__vars['fieldDefinition']['FieldData']['filter_template']) . ' ' . ($__vars['xf']['options']['altf_filterable_lists'] ? 'customFieldContainer--hasFilterableList' : '') . '">
            ' . $__templater->escape($__vars['fieldDefinition']['title']) . ':
            <div class="inputGroup u-inputSpacer">
                ' . $__templater->callMacro('altf_thread_field_form_element', 'filter_element', array(
				'set' => $__vars['set'],
				'definition' => $__vars['fieldDefinition'],
				'editMode' => '1',
				'namePrefix' => $__vars['namePrefix'],
			), $__vars) . '
            </div>

            ';
			if ($__templater->func('in_array', array($__vars['fieldDefinition']['FieldData']['filter_template'], array('multiselect', 'checkbox', ), ), false) AND $__templater->func('in_array', array($__vars['fieldDefinition']['field_type'], array('checkbox', 'multiselect', ), ), false)) {
				$__finalCompiled .= '
                ';
				$__templater->includeJs(array(
					'src' => 'AL/FilterFramework/multiple_choice_configure.js',
				));
				$__finalCompiled .= '
                <div class="u-inputSpacer multipleChoiceConfigureContainer" data-xf-init="multipleChoiceConfigure">
                    ' . $__templater->formSelect(array(
					'name' => $__vars['namePrefix'] . '[__config][' . $__vars['fieldDefinition']['field_id'] . '][match_type]',
					'value' => ($__vars['set']['__config'][$__vars['fieldDefinition']['field_id']]['match_type'] ? $__vars['set']['__config'][$__vars['fieldDefinition']['field_id']]['match_type'] : $__vars['fieldDefinition']['FieldData']['default_match_type']),
				), array(array(
					'value' => 'OR',
					'label' => 'Match any option',
					'_type' => 'option',
				),
				array(
					'value' => 'AND',
					'label' => 'Match all options',
					'_type' => 'option',
				))) . '
                </div>
            ';
			}
			$__finalCompiled .= '
        </div>
    ';
		}
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

';
	return $__finalCompiled;
}
);