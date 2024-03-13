<?php
// FROM HASH: 8c4a74f8caf990ac217509d601aff96b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Insert math');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'CMTV/Math/insertMathDialog.js',
		'addon' => 'CMTV/Math',
	));
	$__finalCompiled .= '

<form class="block" id="editor_math_form" data-xf-init="insert-math-form">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRadioRow(array(
		'name' => 'math_type',
	), array(array(
		'value' => 'block',
		'checked' => 'checked',
		'label' => 'Block',
		'_type' => 'option',
	),
	array(
		'value' => 'inline',
		'label' => 'Inline',
		'_type' => 'option',
	)), array(
		'label' => 'Type',
		'explain' => 'Inline math is smaller and should be used inside the plain text. Block math is bigger and should be used for big equations and formulas. It also creates line breaks before and after.',
	)) . '

			' . $__templater->formTextAreaRow(array(
		'name' => 'latex_input',
		'rows' => '2',
		'autosize' => 'true',
		'autofocus' => '1',
		'id' => 'latex_input',
	), array(
		'label' => 'LaTeX input',
		'explain' => '<a href="https://www.latex-tutorial.com/tutorials/amsmath/" target="_blank">How to write math using LaTeX?</a> • <a href="https://katex.org/docs/supported.html" target="_blank">List of supported functions</a>',
	)) . '			
		</div>

		' . $__templater->formSubmitRow(array(
		'submit' => 'Continue',
		'id' => 'editor_math_submit',
	), array(
	)) . '
	</div>
</form>';
	return $__finalCompiled;
}
);