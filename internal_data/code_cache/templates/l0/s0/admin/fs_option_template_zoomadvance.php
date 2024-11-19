<?php
// FROM HASH: 8268f2110db813d55ad15efef3825e1d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('

	<div>' . 'built_zoom_auth_system' . '</div>
	<div class="u-inputSpacer">
		' . $__templater->button('
			' . 'Change' . '
		', array(
		'href' => $__templater->func('link', array('options/zoom-meeting-auth-setup', $__vars['option'], ), false),
		'data-xf-click' => 'overlay',
	), '', array(
	)) . '
	</div>
', array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);