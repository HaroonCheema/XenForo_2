<?php
// FROM HASH: 326c37e29d0a1e14921ec86f72bfbff1
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
				' . 'You will need to navigate to Zoom <a href="https://marketplace.zoom.us/develop/applications/" target="_blank">App</a> and setup a new project with OAuth 2.0 credentials for a web application., creating an app with get the client id and client secret also set the redirect url.' . $__vars['xf']['language']['label_separator'] . '
				<div><code>' . $__templater->escape($__vars['redirectUri']) . '</code></div>
			', array(
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'client_id',
		'value' => $__vars['xf']['options']['zoom_client_id'],
		'required' => 'required',
	), array(
		'label' => 'Client ID',
	)) . '

			' . $__templater->formTextBoxRow(array(
		'name' => 'client_secret',
		'value' => $__vars['xf']['options']['zoom_client_secret'],
		'required' => 'required',
	), array(
		'label' => 'Client secret',
	)) . '

			' . $__templater->formInfoRow('
				' . 'Continuing will redirect you to Zoom to confirm the account you want to connect with.' . '
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
		'action' => $__templater->func('link', array('options/zoom-auth-setup', $__vars['option'], ), false),
		'class' => 'block',
	));
	return $__finalCompiled;
}
);