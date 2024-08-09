<?php
// FROM HASH: 8f21e3f9d3c3c7ab758eb44aa8db34ca
return array(
'macros' => array('filter_bar' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'route' => '!',
		'form' => '!',
		'filterParams' => '!',
		'routeData' => null,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
    ';
	$__vars['fields'] = $__templater->method($__vars['form'], 'getPublicFilters', array());
	$__finalCompiled .= '
    ';
	$__vars['filters'] = $__templater->method($__vars['filterParams'], 'getArrayCopy', array());
	$__finalCompiled .= '
    ';
	if (!$__templater->test($__vars['fields'], 'empty', array())) {
		$__finalCompiled .= '
        <div class="block-filterBar">
            <div class="filterBar">
                ';
		$__compilerTemp1 = '';
		$__compilerTemp1 .= '
                            ';
		if ($__templater->isTraversable($__vars['fields'])) {
			foreach ($__vars['fields'] AS $__vars['fieldId'] => $__vars['field']) {
				$__compilerTemp1 .= '
                                ';
				if ($__vars['filters'][$__vars['fieldId']]) {
					$__compilerTemp1 .= '
                                    <li>
                                        <a href="' . $__templater->func('link', array($__vars['route'], $__vars['routeData'], $__templater->filter($__vars['filters'], array(array('replace', array($__vars['fieldId'], null, )),), false), ), true) . '"
                                           class="filterBar-filterToggle" data-xf-init="tooltip"
                                           title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
                                            <span class="filterBar-filterToggle-label">' . $__templater->escape($__templater->method($__vars['field'], 'getLabel', array())) . '</span>
                                            ' . $__templater->escape($__templater->method($__vars['form'], 'getFieldValue', array($__vars['fieldId'], $__vars['filters'], ))) . '</a>
                                    </li>
                                ';
				}
				$__compilerTemp1 .= '
                            ';
			}
		}
		$__compilerTemp1 .= '
                        ';
		if (strlen(trim($__compilerTemp1)) > 0) {
			$__finalCompiled .= '
                    <ul class="filterBar-filters">
                        ' . $__compilerTemp1 . '
                    </ul>
                ';
		}
		$__finalCompiled .= '

                <a class="filterBar-menuTrigger" data-xf-click="menu" role="button" tabindex="0" aria-expanded="false"
                   aria-haspopup="true">' . 'Filters' . '</a>
                <div class="menu" data-menu="menu" aria-hidden="true">
                    <div class="menu-content">
                        <h4 class="menu-header">' . 'Show only' . $__vars['xf']['language']['label_separator'] . '</h4>
                        ';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['fields'])) {
			foreach ($__vars['fields'] AS $__vars['id'] => $__vars['field']) {
				$__compilerTemp2 .= '
                                ';
				$__vars['field_name'] = $__templater->method($__vars['form'], 'getNamePrefix', array()) . '[' . $__vars['id'] . ']';
				$__compilerTemp2 .= '
                                ';
				$__vars['field_value'] = $__vars['filters'][$__templater->method($__vars['field'], 'getId', array())];
				$__compilerTemp2 .= '

                                <div class="menu-row menu-row--separated">
                                    <label for="ctrl_' . $__templater->escape($__templater->method($__vars['field'], 'getId', array())) . '">' . $__templater->escape($__templater->method($__vars['field'], 'getLabel', array())) . '</label>
                                    <div class="u-inputSpacer">
                                        ';
				if ($__templater->method($__vars['field'], 'getType', array()) === 'username') {
					$__compilerTemp2 .= '
                                            ' . $__templater->formTextBox(array(
						'name' => $__vars['field_name'],
						'value' => $__vars['field_value'],
						'ac' => 'single',
						'autocomplete' => 'off',
						'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
					)) . '
                                            ';
				} else if ($__templater->method($__vars['field'], 'getType', array()) === 'select') {
					$__compilerTemp2 .= '
                                            ';
					$__compilerTemp3 = array();
					$__compilerTemp4 = $__templater->method($__vars['form'], 'getFieldOptions', array($__vars['id'], ));
					if ($__templater->isTraversable($__compilerTemp4)) {
						foreach ($__compilerTemp4 AS $__vars['optionId'] => $__vars['optionValue']) {
							$__compilerTemp3[] = array(
								'value' => $__vars['optionId'],
								'label' => ($__templater->func('is_array', array($__vars['optionValue'], ), false) ? $__templater->escape($__vars['optionValue']['label']) : $__templater->escape($__vars['optionValue'])),
								'hint' => ($__templater->func('is_array', array($__vars['optionValue'], ), false) ? $__templater->escape($__vars['optionValue']['hint']) : ''),
								'data-hide' => ($__templater->func('is_array', array($__vars['optionValue'], ), false) ? $__vars['optionValue']['data-hide'] : false),
								'data-xf-init' => ($__templater->func('is_array', array($__vars['optionValue'], ), false) ? $__vars['optionValue']['data-xf-init'] : ''),
								'data-container' => ($__templater->func('is_array', array($__vars['optionValue'], ), false) ? $__vars['optionValue']['data-container'] : ''),
								'_type' => 'option',
							);
						}
					}
					$__compilerTemp2 .= $__templater->formSelect(array(
						'name' => $__vars['field_name'],
						'value' => $__vars['field_value'],
					), $__compilerTemp3) . '
                                            ';
				} else {
					$__compilerTemp2 .= '
                                            ' . $__templater->escape($__templater->method($__vars['field'], 'getType', array())) . ' is not implemented in al_core_filter_macros template.
                                        ';
				}
				$__compilerTemp2 .= '
                                    </div>
                                </div>
                            ';
			}
		}
		$__finalCompiled .= $__templater->form('
                            ' . $__compilerTemp2 . '
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
			'action' => $__templater->func('link', array($__vars['route'], $__vars['routeData'], ), false),
		)) . '
                    </div>
                </div>
            </div>
        </div>
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

	return $__finalCompiled;
}
);