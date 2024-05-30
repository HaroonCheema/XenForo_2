<?php
// FROM HASH: 8775b28dc3091f40b14d335af847fc57
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['node'], 'isInsert', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add link forum');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit link forum' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['node']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['node'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('', array(
			'href' => $__templater->func('link', array('link-forums/delete', $__vars['node'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['xf']['visitor'], 'canEditIcon', array())) {
		$__compilerTemp1 .= '
	' . $__templater->formUploadRow(array(
			'name' => 'upload',
			'accept' => '.gif,.jpeg,.jpg,.jpe,.png',
		), array(
			'label' => 'Icon',
			'explain' => 'It is recommended that you use an image that is at least ' . $__templater->escape($__vars['xf']['options']['Fs_NodeIcon_nodeDimensions']['width']) . 'x' . $__templater->escape($__vars['xf']['options']['Fs_NodeIcon_nodeDimensions']['height']) . ' pixels.',
		)) . '
';
	}
	$__compilerTemp2 = '';
	if (!$__templater->method($__vars['node'], 'isInsert', array())) {
		$__compilerTemp2 .= '
	';
		if ($__templater->method($__vars['node'], 'getIcon', array())) {
			$__compilerTemp2 .= '
		' . $__templater->formRow('
			<img src="' . $__templater->func('base_url', array($__templater->method($__vars['node'], 'getIcon', array()), ), true) . '" />
			<br/>
			' . $__templater->button('', array(
				'href' => $__templater->func('link', array('forums/delete-icon', $__vars['node'], ), false),
				'icon' => 'delete',
				'overlay' => 'true',
			), '', array(
			)) . '
		', array(
				'label' => 'Custom node icon',
			)) . '
	';
		} else {
			$__compilerTemp2 .= '
		' . $__templater->formRow('
			' . 'No icon' . '
		', array(
				'label' => 'Custom node icon',
			)) . '
	';
		}
		$__compilerTemp2 .= '
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

' . $__compilerTemp1 . '

' . $__compilerTemp2 . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'link_url',
		'value' => $__vars['link']['link_url'],
	), array(
		'label' => 'Link URL',
		'explain' => 'Users will be redirected to this URL when they click on this link forum.',
	)) . '

			' . $__templater->callMacro('node_edit_macros', 'position', array(
		'node' => $__vars['node'],
		'nodeTree' => $__vars['nodeTree'],
	), $__vars) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('link-forums/save', $__vars['node'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);