<?php
// FROM HASH: cb14f04785b49bf8c7054a874220777d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formTextBoxRow(array(
		'name' => 'options[consumer_key]',
		'value' => $__vars['options']['consumer_key'],
	), array(
		'label' => 'Consumer key',
		'hint' => 'Required',
		'explain' => 'Consumer key of your application.
<br/>
You can create it in the Tumblr settings <a href="https://www.tumblr.com/settings/apps" target="_blank">page</a>.',
	)) . '

' . $__templater->formTextBoxRow(array(
		'name' => 'options[consumer_secret]',
		'value' => $__vars['options']['consumer_secret'],
	), array(
		'label' => 'Consumer secret',
		'hint' => 'Required',
		'explain' => 'Consumer secret of your Tumblr application.',
	));
	return $__finalCompiled;
}
);