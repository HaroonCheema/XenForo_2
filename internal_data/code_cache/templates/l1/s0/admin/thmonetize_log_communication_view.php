<?php
// FROM HASH: 5ef738598378471b0da1d7ab3e978f9a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('thmonetize_communication_log_entry');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				<a href="' . $__templater->func('link', array('users/edit', $__vars['entry']['User'], ), true) . '">' . $__templater->escape($__vars['entry']['User']['username']) . '</a>
			', array(
		'label' => 'User',
	)) . '
			' . $__templater->formRow('
				' . $__templater->func('date_dynamic', array($__vars['entry']['log_date'], array(
	))) . '
			', array(
		'label' => 'Date',
	)) . '
			' . $__templater->formRow('
				<a href="' . $__templater->func('link', array('thmonetize-communications', $__vars['entry']['Communication'], ), true) . '">' . $__templater->escape($__vars['entry']['Communication']['title']) . '</a>
			', array(
		'label' => 'Communication',
	)) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);