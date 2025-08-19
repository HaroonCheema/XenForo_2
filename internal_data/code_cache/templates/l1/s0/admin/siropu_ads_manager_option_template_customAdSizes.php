<?php
// FROM HASH: 10fb67987e44bd58d3030acb0b11d3dd
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['choices'])) {
		foreach ($__vars['choices'] AS $__vars['counter'] => $__vars['choice']) {
			$__compilerTemp1 .= '
			<li class="inputGroup">
				' . $__templater->formTextBox(array(
				'name' => $__vars['inputName'] . '[' . $__vars['counter'] . '][width]',
				'value' => $__vars['choice']['width'],
				'placeholder' => 'Width',
				'size' => '20',
			)) . '
				<span class="inputGroup-splitter"></span>
				' . $__templater->formTextBox(array(
				'name' => $__vars['inputName'] . '[' . $__vars['counter'] . '][height]',
				'value' => $__vars['choice']['height'],
				'placeholder' => 'Height',
				'size' => '20',
			)) . '
			</li>
		';
		}
	}
	$__finalCompiled .= $__templater->formRow('

	<ul class="listPlain inputGroup-container">
		' . $__compilerTemp1 . '

		<li class="inputGroup" data-xf-init="field-adder" data-increment-format="' . $__templater->escape($__vars['inputName']) . '[{counter}]">
			' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[' . $__vars['nextCounter'] . '][width]',
		'placeholder' => 'Width',
		'size' => '20',
	)) . '
			<span class="inputGroup-splitter"></span>
			' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[' . $__vars['nextCounter'] . '][height]',
		'placeholder' => 'Height',
		'size' => '20',
	)) . '
		</li>
	</ul>
', array(
		'rowtype' => 'input',
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	));
	return $__finalCompiled;
}
);