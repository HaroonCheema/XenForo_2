<?php
// FROM HASH: 584b90a2b2103797f4cb240941af039e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => $__vars['inputName'] . '[enabled]',
		'label' => 'Enabled',
		'value' => '1',
		'selected' => $__vars['option']['option_value']['enabled'],
		'data-hide' => 'true',
		'hint' => 'Use a more compact version that takes up less space',
		'_dependent' => array('
            <div class="inputGroup">
                <span class="inputGroup-text">
                    ' . 'Size' . $__vars['xf']['language']['label_separator'] . '
                </span>
                <span class="inputGroup" dir="ltr">
                    ' . $__templater->formSelect(array(
		'name' => $__vars['inputName'] . '[size]',
		'class' => 'input--inline input--autoSize',
		'value' => $__vars['option']['option_value']['size'],
	), array(array(
		'value' => '1',
		'label' => 'Small',
		'_type' => 'option',
	),
	array(
		'value' => '2',
		'label' => 'Smaller',
		'_type' => 'option',
	),
	array(
		'value' => '3',
		'label' => 'Smallest',
		'_type' => 'option',
	))) . '
                </span>
            </div>
        '),
		'_type' => 'option',
	)), array(
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	));
	return $__finalCompiled;
}
);