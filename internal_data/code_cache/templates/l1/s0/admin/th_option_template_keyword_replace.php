<?php
// FROM HASH: 96a0beed8667915a8d496cbde92a150d
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
				'placeholder' => 'Word',
				'size' => '20',
			)) . '
				<span class="inputGroup-splitter"></span>
				' . $__templater->formTextBox(array(
				'name' => $__vars['inputName'] . '[' . $__vars['counter'] . '][replace]',
				'value' => $__vars['choice']['replace'],
				'placeholder' => 'Replacement',
				'size' => '20',
			)) . '
				' . $__templater->formTextBox(array(
				'name' => $__vars['inputName'] . '[' . $__vars['counter'] . '][limit]',
				'value' => $__vars['choice']['limit'],
				'placeholder' => 'limit',
				'size' => '5',
			)) . '

				' . $__templater->formSelect(array(
				'name' => $__vars['inputName'] . '[' . $__vars['counter'] . '][replace_type]',
				'value' => $__vars['choice']['replace_type'],
				'inputclass' => 'value autoSize',
			), array(array(
				'value' => 'url',
				'label' => 'Url',
				'_type' => 'option',
			),
			array(
				'value' => 'overlay',
				'label' => 'Overlay',
				'_type' => 'option',
			),
			array(
				'value' => '',
				'label' => 'Html',
				'_type' => 'option',
			))) . '

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
		'placeholder' => 'Word',
		'size' => '20',
	)) . '
			<span class="inputGroup-splitter"></span>
			' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[' . $__vars['nextCounter'] . '][replace]',
		'placeholder' => 'Replacement',
		'size' => '20',
	)) . '
			' . $__templater->formTextBox(array(
		'name' => $__vars['inputName'] . '[' . $__vars['nextCounter'] . '][limit]',
		'placeholder' => 'limit',
		'size' => '5',
	)) . '

			' . $__templater->formSelect(array(
		'name' => $__vars['inputName'] . '[' . $__vars['nextCounter'] . '][replace_type]',
		'value' => '',
		'inputclass' => 'value autoSize',
	), array(array(
		'value' => 'url',
		'label' => 'Url',
		'_type' => 'option',
	),
	array(
		'value' => 'overlay',
		'label' => 'Overlay',
		'_type' => 'option',
	),
	array(
		'value' => '',
		'label' => 'Html',
		'_type' => 'option',
	))) . '

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