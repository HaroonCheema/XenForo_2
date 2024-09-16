<?php
// FROM HASH: 51ed1bb971250ad0457b5e3ca2812c1c
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']) . ' - ' . 'Delete Thread Rating');
	$__finalCompiled .= '
';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']) . ' - ' . 'Delete Thread Rating');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				' . $__templater->func('avatar', array($__vars['user'], 's', false, array(
		'notooltip' => 'true',
		'defaultname' => '$user.username',
	))) . '
				' . $__templater->func('username_link', array($__vars['user'], true, array(
		'notooltip' => 'true',
	))) . '
				' . $__templater->callMacro('BRATR_rating_macros', 'stars', array(
		'rating' => $__vars['rating']['rating'],
	), $__vars) . '
			', array(
		'rowtype' => 'noLabel',
	)) . '
			' . $__templater->callMacro('helper_action', 'delete_type', array(
		'canHardDelete' => $__templater->method($__vars['rating'], 'canDelete', array('hard', )),
	), $__vars) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
		'sticky' => 'true',
	), array(
	)) . '
	</div>
	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array('bratr-ratings/delete', $__vars['rating'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);