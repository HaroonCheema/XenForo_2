<?php
// FROM HASH: d666ebe6e4bac2925bb3f32118525870
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('

	<div>' . 'Zoom Auth' . '</div>
	<div class="u-inputSpacer">
		' . $__templater->button('
			' . 'Change' . '
		', array(
		'href' => $__templater->func('link', array('options/zoom-auth-setup', $__vars['option'], ), false),
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