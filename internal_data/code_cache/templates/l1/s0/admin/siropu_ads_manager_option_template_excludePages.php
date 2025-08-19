<?php
// FROM HASH: 35344f69a942395801a7022fda71be32
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['choices'])) {
		foreach ($__vars['choices'] AS $__vars['choice']) {
			$__compilerTemp1 .= '
			<li style="margin-bottom: 5px;">
				' . $__templater->formTextBox(array(
				'name' => $__vars['inputName'] . '[]',
				'value' => $__vars['choice'],
				'placeholder' => 'Template name',
				'size' => '100',
			)) . '
			</li>
		';
		}
	}
	$__finalCompiled .= $__templater->formRow('

	<ul class="listPlain">
		' . $__compilerTemp1 . '

		<li style="margin-bottom: 5px;" data-xf-init="field-adder" data-increment-format="' . $__templater->escape($__vars['inputName']) . '">
			' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[]',
		'placeholder' => 'Template name',
		'size' => '100',
	)) . '
		</li>
	</ul>

	<div class="formRow-explain">
		' . $__templater->escape($__vars['explainHtml']) . '
		<br>
		<a href="' . $__templater->func('link', array('ads-manager/help/content-template-list', ), true) . '" data-xf-click="overlay">' . 'View content template list' . '</a>
	</div>
', array(
		'rowtype' => 'input',
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	));
	return $__finalCompiled;
}
);