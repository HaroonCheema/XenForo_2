<?php
// FROM HASH: 2aaed7b7f6427ed29694928823eb6413
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = array(array(
		'value' => '0',
		'selected' => true,
		'label' => $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close'],
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['categories'])) {
		foreach ($__vars['categories'] AS $__vars['cat']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['cat']['category_id'],
				'label' => $__templater->escape($__vars['cat']['title']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="menu-row">
    ' . 'Meeting Owner' . $__vars['xf']['language']['label_separator'] . '
    <div class="u-inputSpacer">
      	' . $__templater->formTextBox(array(
		'name' => 'username',
		'value' => $__vars['conditions']['username'],
		'ac' => 'single',
	)) . '
    </div>
  </div>
	
	<div class="menu-row menu-row--separated">
			' . 'Status' . $__vars['xf']['language']['label_separator'] . '
			<div class="u-inputSpacer">
				' . $__templater->formSelect(array(
		'name' => 'status',
		'value' => $__vars['conditions']['status'],
	), array(array(
		'value' => '0',
		'selected' => true,
		'label' => 'All',
		'_type' => 'option',
	),
	array(
		'value' => '1',
		'label' => 'Live',
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'label' => 'Waiting',
		'_type' => 'option',
	),
	array(
		'value' => '3',
		'label' => 'Closed',
		'_type' => 'option',
	))) . '
			</div>
		</div>
	
	<div class="menu-row menu-row--separated">
			' . 'Categories' . $__vars['xf']['language']['label_separator'] . '
			<div class="u-inputSpacer">
				' . $__templater->formSelect(array(
		'name' => 'category_id',
		'value' => $__vars['conditions']['category_id'],
	), $__compilerTemp1) . '
			</div>
		</div>
	
	
	
	  <div class="menu-footer">
    <span class="menu-footer-controls">
      ' . $__templater->button('Filter', array(
		'type' => 'submit',
		'class' => 'button--primary',
	), '', array(
	)) . '
    </span>
  </div>

  ' . $__templater->formHiddenVal('search', '1', array(
	)) . '
', array(
		'action' => $__templater->func('link', array('meetings', ), false),
	));
	return $__finalCompiled;
}
);