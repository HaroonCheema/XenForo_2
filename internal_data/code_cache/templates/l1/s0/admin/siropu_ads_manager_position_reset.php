<?php
// FROM HASH: ae239ae11f9cf078cf18aa73e5ac7cbc
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Reset positions');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				<div class="blockMessage blockMessage--important blockMessage--iconic">' . 'This action will delete all the current positions and categories and restore the defaults.' . '</div>
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'reset',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/positions/reset', ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);