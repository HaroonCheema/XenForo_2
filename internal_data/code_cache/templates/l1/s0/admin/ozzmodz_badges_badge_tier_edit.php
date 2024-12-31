<?php
// FROM HASH: 671c7dc970d005646bb6e05c426d92b4
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['badgeTier'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add badge tier');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit badge tier' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['badgeTier']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__templater->includeCss('public:color_picker.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'xf/color_picker.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['badgeTier'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('ozzmodz-badges-tiers/add', $__vars['badgeTier'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">

			' . $__templater->formTextBoxRow(array(
		'name' => 'title',
		'value' => ($__templater->method($__vars['badgeTier'], 'getEntityId', array()) ? $__vars['badgeTier']['MasterTitle']['phrase_text'] : ''),
		'required' => 'required',
	), array(
		'label' => 'Title',
	)) . '
			
			' . $__templater->formRow('
				<div class="inputGroup inputGroup--joined inputGroup--color" data-xf-init="color-picker">
					' . $__templater->formTextBox(array(
		'name' => 'color',
		'value' => $__vars['badgeTier']['color'],
		'class' => 'input--cssProp',
		'dir' => 'ltr',
	)) . '
					<div class="inputGroup-text"><span class="colorPickerBox js-colorPickerTrigger"></span></div>
				</div>
			', array(
		'rowtype' => 'input',
		'label' => 'Color',
	)) . '
			
			' . $__templater->formCodeEditorRow(array(
		'name' => 'css',
		'value' => $__vars['badgeTier']['css'],
		'mode' => 'css',
		'data-line-wrapping' => 'true',
		'class' => 'codeEditor--autoSize',
	), array(
		'label' => 'Freeform CSS/LESS code',
		'explain' => 'Use !important modifier to override base properties',
	)) . '

			<hr class="formRowSep" />

			' . $__templater->formNumberBoxRow(array(
		'name' => 'display_order',
		'value' => $__vars['badgeTier']['display_order'],
		'type' => 'number',
		'min' => '0',
		'step' => '5',
	), array(
		'label' => 'Display order',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'save',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array('ozzmodz-badges-tiers/save', $__vars['badgeTier'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);