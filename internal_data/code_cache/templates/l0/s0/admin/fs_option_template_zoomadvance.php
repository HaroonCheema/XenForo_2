<?php
// FROM HASH: abca765b6aeeb7d64fb860c0624b5e44
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('

	<div>' . 'Zoom Auth Credentials' . '</div>
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