<?php
// FROM HASH: cb74559c448bc3d1b796263016d76a0b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['option']['title']));
	$__finalCompiled .= '

' . $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . 'zoom_setup_explain:' . '
				<div><code>' . $__templater->escape($__vars['redirectUri']) . '</code></div>
			', array(
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'client_id',
		'value' => $__vars['xf']['options']['zoom_meeting_client_id'],
		'required' => 'required',
	), array(
		'label' => 'Client ID',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'client_secret',
		'value' => $__vars['xf']['options']['zoom_meeting_client_secret'],
		'required' => 'required',
	), array(
		'label' => 'Client secret',
	)) . '

			' . $__templater->formInfoRow('
				' . 'continuing_will_redirect_you_to_zoom_to_confirm_account_you_want_to' . '
			', array(
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'submit' => 'Continue',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('options/zoom-meeting-auth-setup', $__vars['option'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);