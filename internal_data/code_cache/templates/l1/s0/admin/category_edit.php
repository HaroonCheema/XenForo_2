<?php
// FROM HASH: c5ab1c441bc31b25fc7ab78e57ff8df1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['category'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add category');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit category' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['node']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['category'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('categories/delete', $__vars['node'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (!$__templater->method($__vars['category'], 'isInsert', array())) {
		$__compilerTemp1 .= '
	';
		if ($__templater->method($__vars['node'], 'getStateIcon', array())) {
			$__compilerTemp1 .= '
		' . $__templater->formRow('
			<img src="' . $__templater->func('base_url', array($__templater->method($__vars['node'], 'getStateIcon', array()), ), true) . '" style="width: 250px; height: 250px;"/>
			<br/>
			' . $__templater->button('', array(
				'href' => $__templater->func('link', array('categories/delete-icon', $__vars['node'], ), false),
				'icon' => 'delete',
				'overlay' => 'true',
			), '', array(
			)) . '
		', array(
				'label' => 'State icon',
			)) . '
	';
		}
		$__compilerTemp1 .= '
';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->callMacro('node_edit_macros', 'title', array(
		'node' => $__vars['node'],
	), $__vars) . '
			' . $__templater->callMacro('node_edit_macros', 'description', array(
		'node' => $__vars['node'],
	), $__vars) . '


' . $__templater->formUploadRow(array(
		'name' => 'stateIcon',
		'accept' => '.gif,.jpeg,.jpg,.jpe,.png',
	), array(
		'label' => 'Upload state icon',
		'explain' => 'It is recommended that you use an image that is at least ' . $__templater->escape($__vars['xf']['options']['fs_state_icon_dimenstions']['width']) . 'x' . $__templater->escape($__vars['xf']['options']['fs_state_icon_dimenstions']['height']) . ' pixels.',
	)) . '

' . $__compilerTemp1 . '
			' . $__templater->callMacro('node_edit_macros', 'position', array(
		'node' => $__vars['node'],
		'nodeTree' => $__vars['nodeTree'],
	), $__vars) . '
			' . $__templater->callMacro('node_edit_macros', 'navigation', array(
		'node' => $__vars['node'],
		'navChoices' => $__vars['navChoices'],
	), $__vars) . '
' . $__templater->callMacro('xgt_styles_kategori_ikonlari', 'xgtStylesKategorikon', array(
		'forum' => $__vars['forum'],
		'node' => $__vars['node'],
	), $__vars) . '

			' . $__templater->callMacro('node_edit_macros', 'style', array(
		'node' => $__vars['node'],
		'styleTree' => $__vars['styleTree'],
	), $__vars) . '
' . $__templater->includeTemplate('altf_filter_location', $__vars) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('categories/save', $__vars['node'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);