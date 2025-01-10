<?php
// FROM HASH: 3978a387f81164956b8b5426210b7c6e
return array(
'macros' => array('tuning' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'bot' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<!-- TUNING: START -->
	' . $__templater->formSelectRow(array(
		'name' => 'general[chat_model]',
		'value' => $__templater->method($__vars['bot'], 'getSafest', array('general', 'chat_model', 'gpt-3.5-turbo', )),
	), array(array(
		'value' => 'gpt-3.5-turbo',
		'label' => 'gpt-3.5-turbo',
		'_type' => 'option',
	),
	array(
		'value' => 'gpt-4',
		'label' => 'gpt-4',
		'_type' => 'option',
	),
	array(
		'value' => 'gpt-4-32k',
		'label' => 'gpt-4-32k',
		'_type' => 'option',
	)), array(
		'label' => 'Chat model',
		'explain' => 'GPT 4 understands context better, and can process more information.<br>
GPT 3.5 is significantly faster and cheaper.<br>
More details about the difference in models can be found at <a href="https://platform.openai.com/docs/models/overview" target="_blank">this link</a>.',
	)) . '
	<!-- TUNING: END -->
';
	return $__finalCompiled;
}
),
'image_restrictions' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'bot' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<!-- IMAGE RESTRICTIONS: START -->
	' . $__templater->formNumberBoxRow(array(
		'name' => 'restrictions[max_images_per_message]',
		'value' => $__vars['bot']['restrictions']['max_images_per_message'],
		'min' => '1',
		'max' => '4',
	), array(
		'label' => 'Max images per message',
		'explain' => 'The number of generated images will be limited to the specified number even if the user has requested more images',
	)) . '

	' . $__templater->formSelectRow(array(
		'name' => 'restrictions[max_image_size]',
		'value' => $__vars['bot']['restrictions']['max_image_size'],
	), array(array(
		'value' => '256',
		'label' => '256x256',
		'_type' => 'option',
	),
	array(
		'value' => '512',
		'label' => '512x512',
		'_type' => 'option',
	),
	array(
		'value' => '1024',
		'label' => '1024x1024',
		'_type' => 'option',
	)), array(
		'label' => 'Max image size',
		'explain' => 'The size of the generated images will be limited to the specified value, even if the user requests larger images.',
	)) . '
	<!-- IMAGE RESTRICTIONS: END -->
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<li role="tabpanel" id="tuning">
	' . $__templater->callMacro(null, 'tuning', array(
		'bot' => $__vars['bot'],
	), $__vars) . '
</li>
<li role="tabpanel" id="image_restrictions">
	' . $__templater->callMacro(null, 'image_restrictions', array(
		'bot' => $__vars['bot'],
	), $__vars) . '
</li>
<li role="tabpanel" id="restrictions">
	' . $__templater->callMacro('bs_ai_bot.chat_gpt_tab_panes', 'restrictions', array(
		'bot' => $__vars['bot'],
		'userGroups' => $__vars['userGroups'],
		'nodeTree' => $__vars['nodeTree'],
	), $__vars) . '
</li>
<li role="tabpanel" id="triggers">
	' . $__templater->callMacro('bs_ai_bot.chat_gpt_tab_panes', 'triggers', array(
		'bot' => $__vars['bot'],
		'nodeTree' => $__vars['nodeTree'],
	), $__vars) . '
</li>

' . '

';
	return $__finalCompiled;
}
);