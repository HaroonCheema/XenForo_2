<?php
// FROM HASH: 13e0e064d4106e13aaf9428da41adc26
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<xen:require js="js/themehouse/keywordreplace/options_keyword_replace.js" />

<xen:controlunit label="' . $__templater->escape($__vars['preparedOption']['title']) . '" hint="' . $__templater->escape($__vars['preparedOption']['hint']) . '">
	<xen:explain>{xen:raw $preparedOption.explain}</xen:explain>
	<xen:html>
		<ul>
			<xen:foreach loop="$choices" key="$counter" value="$choice">
				<li>
					<input type="checkbox" name="' . $__templater->escape($__vars['fieldPrefix']) . '[' . $__templater->escape($__vars['preparedOption']['option_id']) . '][' . $__templater->escape($__vars['counter']) . '][live]" value="1" {xen:checked ' . $__templater->escape($__vars['choice']['live']) . '} />
					' . $__templater->formTextBox(array(
		'name' => $__vars['fieldPrefix'] . '[' . $__vars['preparedOption']['option_id'] . '][' . $__vars['counter'] . '][word]',
		'value' => $__vars['choice']['word'],
		'placeholder' => '{xen:phrase word_or_phrase}',
		'size' => '20',
	)) . '
					' . $__templater->formSelect(array(
		'name' => $__vars['fieldPrefix'] . '[' . $__vars['preparedOption']['option_id'] . '][' . $__vars['counter'] . '][replace_type]',
		'value' => $__vars['choice']['replace_type'],
		'inputclass' => 'value autoSize',
	), array(array(
		'value' => 'url',
		'label' => '{xen:phrase th_with_url_keyword_replace}',
		'_type' => 'option',
	),
	array(
		'value' => 'overlay',
		'label' => '{xen:phrase th_with_url_overlay_keyword_replace}',
		'_type' => 'option',
	),
	array(
		'value' => '',
		'label' => '{xen:phrase th_with_html_keyword_replace}',
		'_type' => 'option',
	))) . '
					' . $__templater->formTextBox(array(
		'name' => $__vars['fieldPrefix'] . '[' . $__vars['preparedOption']['option_id'] . '][' . $__vars['counter'] . '][limit]',
		'value' => $__vars['choice']['limit'],
		'placeholder' => '{xen:phrase limit}',
		'size' => '5',
	)) . '
					' . $__templater->formTextBox(array(
		'name' => $__vars['fieldPrefix'] . '[' . $__vars['preparedOption']['option_id'] . '][' . $__vars['counter'] . '][replace]',
		'value' => $__vars['choice']['replace'],
		'placeholder' => '{xen:phrase replacement}',
		'size' => '30',
	)) . '
				</li>
			</xen:foreach>

			<li class="KeywordReplaceOptionListener">
				<input type="checkbox" name="' . $__templater->escape($__vars['fieldPrefix']) . '[' . $__templater->escape($__vars['preparedOption']['option_id']) . '][' . $__templater->escape($__vars['nextCounter']) . '][live]" value="1" checked="checked" />
				<xen:textbox name="' . $__templater->escape($__vars['fieldPrefix']) . '[' . $__templater->escape($__vars['preparedOption']['option_id']) . '][' . $__templater->escape($__vars['nextCounter']) . '][word]" value="" placeholder="{xen:phrase word_or_phrase}" size="20" />
				<xen:select name="' . $__templater->escape($__vars['fieldPrefix']) . '[' . $__templater->escape($__vars['preparedOption']['option_id']) . '][' . $__templater->escape($__vars['nextCounter']) . '][replace_type]" value="" inputclass="value autoSize">
					<xen:option value="url">{xen:phrase th_with_url_keyword_replace}</xen:option>
					<xen:option value="overlay">{xen:phrase th_with_url_overlay_keyword_replace}</xen:option>
					<xen:option value="">{xen:phrase th_with_html_keyword_replace}</xen:option>
				</xen:select>
				<xen:textbox name="' . $__templater->escape($__vars['fieldPrefix']) . '[' . $__templater->escape($__vars['preparedOption']['option_id']) . '][' . $__templater->escape($__vars['nextCounter']) . '][limit]" value="" placeholder="{xen:phrase limit}" size="5" />
				<xen:textbox name="' . $__templater->escape($__vars['fieldPrefix']) . '[' . $__templater->escape($__vars['preparedOption']['option_id']) . '][' . $__templater->escape($__vars['nextCounter']) . '][replace]" value="" placeholder="{xen:phrase replacement}" size="30" />
			</li>
		</ul>

		<input type="hidden" name="' . $__templater->escape($__vars['listedFieldName']) . '" value="' . $__templater->escape($__vars['preparedOption']['option_id']) . '" />
		{xen:raw $editLink}
	</xen:html>
</xen:controlunit>';
	return $__finalCompiled;
}
);