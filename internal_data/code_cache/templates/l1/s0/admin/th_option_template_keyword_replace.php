<?php
// FROM HASH: 7dbf4b46b761e3a8c58e6dec8d51e468
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['choices'])) {
		foreach ($__vars['choices'] AS $__vars['counter'] => $__vars['choice']) {
			$__compilerTemp1 .= '
			<li class="inputGroup">
				' . $__templater->formCheckBox(array(
			), array(array(
				'name' => $__vars['inputName'] . '[' . $__vars['counter'] . '][live]',
				'value' => '1',
				'checked' => ($__vars['choice']['live'] ? 'checked' : ''),
				'_type' => 'option',
			))) . '
				' . $__templater->formTextBox(array(
				'name' => $__vars['inputName'] . '[' . $__vars['counter'] . '][word]',
				'value' => $__vars['choice']['word'],
				'placeholder' => 'Word or phrase',
				'size' => '20',
			)) . '
				<span class="inputGroup-splitter"></span>
				' . $__templater->formTextBox(array(
				'name' => $__vars['inputName'] . '[' . $__vars['counter'] . '][replace]',
				'value' => $__vars['choice']['replace'],
				'placeholder' => 'Replacement (optional)',
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
			' . $__templater->formCheckBox(array(
	), array(array(
		'name' => $__vars['inputName'] . '[' . $__vars['nextCounter'] . '][live]',
		'value' => '1',
		'checked' => 'checked',
		'_type' => 'option',
	))) . '
			' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[' . $__vars['nextCounter'] . '][word]',
		'placeholder' => 'Word or phrase',
		'size' => '20',
	)) . '
			<span class="inputGroup-splitter"></span>
			' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[' . $__vars['nextCounter'] . '][replace]',
		'placeholder' => 'Replacement (optional)',
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
		'rowclass' => $__vars['rowClass'],
	));
	return $__finalCompiled;
}
);