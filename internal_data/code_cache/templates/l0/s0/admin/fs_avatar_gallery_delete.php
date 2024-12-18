<?php
// FROM HASH: 3042d2fdfec99857fd47434d30a9d07f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
				<strong></strong>
				<img src="' . $__templater->escape($__templater->method($__vars['avatar'], 'getAvatarImgUrl', array())) . '" alt="avatar image" width="200" height="200"/>
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ag/delete', $__vars['avatar'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);