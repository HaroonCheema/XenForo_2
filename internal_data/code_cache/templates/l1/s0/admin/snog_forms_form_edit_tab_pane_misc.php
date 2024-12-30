<?php
// FROM HASH: 1cff97e304b82e80382a552bd50baf7f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-body">
	
	' . '
	
	' . '
	' . $__templater->formEditorRow(array(
		'name' => 'aboveapp',
		'value' => $__vars['form']['aboveapp'],
	), array(
		'rowtype' => 'fullWidth',
		'label' => '<b>' . 'Show above form' . '</b>',
		'explain' => 'What you enter here will be shown above the questions for the form.',
	)) . '
	
	<hr class="formRowSep" />
	
	' . '
	' . $__templater->formEditorRow(array(
		'name' => 'belowapp',
		'value' => $__vars['form']['belowapp'],
	), array(
		'rowtype' => 'fullWidth',
		'label' => '<b>' . 'Show below form' . '</b>',
		'explain' => 'What you enter here will be shown below the questions for the form.',
	)) . '
	
	<hr class="formRowSep" />
	
	' . '
	' . $__templater->formRow('
		<div class="inputGroup inputGroup--joined inputGroup--colorMedium" data-xf-init="color-picker" data-allow-palette="true">
			' . $__templater->formTextBox(array(
		'name' => 'qcolor',
		'value' => $__vars['form']['qcolor'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'qcolor', ), false),
	)) . '
			<div class="inputGroup-text"><span class="colorPickerBox js-colorPickerTrigger"></span></div>
		</div>
	', array(
		'label' => 'Report question color',
		'explain' => 'This will change the question color in report posts and PCs in all styles. Leave blank to use the default text color for your styles.',
		'rowclass' => 'formRow--input ' . $__vars['rowClass'],
	)) . '
	
	' . '
	' . $__templater->formRow('
		<div class="inputGroup inputGroup--joined inputGroup--colorMedium" data-xf-init="color-picker" data-allow-palette="true">
			' . $__templater->formTextBox(array(
		'name' => 'acolor',
		'value' => $__vars['form']['acolor'],
		'maxlength' => $__templater->func('max_length', array($__vars['form'], 'acolor', ), false),
	)) . '
			<div class="inputGroup-text"><span class="colorPickerBox js-colorPickerTrigger"></span></div>
		</div>
	', array(
		'label' => 'Report answer color',
		'explain' => 'This will change the answer color in report posts and PCs in all styles. Leave blank to use the default text color for your styles.<br /><br /><span style="color:red;">WARNING:</span> If you include a BB Code in your question report formatting, these color settings may appear in the questions or answers. If you are including codes such as the CODE BB Code in your question report format, DO NOT use these color options. Format the colors in your question report format instead.',
		'rowclass' => 'formRow--input ' . $__vars['rowClass'],
	)) . '
	
	' . '
</div>';
	return $__finalCompiled;
}
);