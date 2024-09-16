<?php
// FROM HASH: 0e19657ae76fce2d763e15ad4fc8b3c0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']) . ' - ' . 'Edit Thread Rating');
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->callMacro('BRATR_rating_macros', 'rating', array(
		'currentRating' => $__vars['rating']['rating'],
	), $__vars) . '

			' . $__templater->formEditorRow(array(
		'name' => 'message',
		'data-min-height' => '100',
		'value' => $__vars['rating']['message'],
	), array(
		'label' => 'Message',
		'hint' => ($__templater->method($__vars['thread'], 'isMessageRequired', array()) ? 'Required' : ''),
		'explain' => 'Explain why you\'re giving this rating. Reviews which are not constructive may be removed without notice.',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Submit rating',
		'icon' => 'rate',
	), array(
	)) . '
	</div>
	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array('bratr-ratings/edit', $__vars['rating'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);