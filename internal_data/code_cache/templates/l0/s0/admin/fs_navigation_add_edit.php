<?php
// FROM HASH: b6e77c0c7c0f27ec22517fab4d6d2c5d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['navigation'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add navigation');
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit navigation' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['navigation']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = array();
	if ($__templater->isTraversable($__vars['forums'])) {
		foreach ($__vars['forums'] AS $__vars['forum']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['forum']['value'],
				'disabled' => $__vars['forum']['disabled'],
				'selected' => $__templater->func('in_array', array($__vars['forum']['value'], $__vars['navigation']['forum_ids'], ), false),
				'label' => $__templater->escape($__vars['forum']['label']),
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formTextBoxRow(array(
		'name' => 'navigation_id',
		'value' => $__vars['navigation']['navigation_id'],
		'readonly' => (!$__templater->method($__vars['navigation'], 'canEdit', array())),
		'maxlength' => $__templater->func('max_length', array($__vars['navigation'], 'navigation_id', ), false),
		'dir' => 'ltr',
	), array(
		'label' => 'Navigation ID',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => ($__templater->method($__vars['navigation'], 'exists', array()) ? $__vars['navigation']['MasterTitle']['phrase_text'] : ''),
		'readonly' => (!$__templater->method($__vars['navigation'], 'canEdit', array())),
	), array(
		'label' => 'Title',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'config[basic][link]',
		'value' => $__vars['navigation']['type_config']['link'],
		'code' => 'true',
	), array(
		'label' => 'Link',
	)) . '

			<hr class="formRowSep" />	

			<ul class="inputList">
				<li>

					' . $__templater->formSelectRow(array(
		'name' => 'forum_ids[]',
		'multiple' => 'multiple',
		'size' => '7',
		'required' => 'required',
	), $__compilerTemp1, array(
		'label' => 'Select Forums',
		'hint' => 'Required',
	)) . '

				</li>
			</ul>

			<hr class="formRowSep" />

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'enabled',
		'selected' => $__vars['navigation']['enabled'],
		'label' => 'Enabled',
		'_type' => 'option',
	)), array(
	)) . '

			' . $__templater->callMacro('display_order_macros', 'row', array(
		'value' => $__vars['navigation']['display_order'],
	), $__vars) . '

			' . $__templater->formHiddenVal('addon_id', 'FS/GenerateLink', array(
	)) . '
			' . $__templater->formHiddenVal('parent_navigation_id', '', array(
	)) . '
			' . $__templater->formHiddenVal('navigation_type_id', 'basic', array(
	)) . '
			' . $__templater->formHiddenVal('config[basic][display_condition]', '', array(
	)) . '
			' . $__templater->formHiddenVal('config[basic][extra_attr_names][]', '', array(
	)) . '
			' . $__templater->formHiddenVal('config[basic][extra_attr_values][]', '', array(
	)) . '

		</div>

		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('navigation/forums-save', $__vars['navigation'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);