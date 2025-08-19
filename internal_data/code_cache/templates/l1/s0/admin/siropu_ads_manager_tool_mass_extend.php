<?php
// FROM HASH: 18070b27b72df173f078ae3795534397
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Mass extend end date');
	$__finalCompiled .= '

';
	$__compilerTemp1 = $__templater->mergeChoiceOptions(array(), $__vars['ads']);
	$__compilerTemp2 = $__templater->mergeChoiceOptions(array(), $__vars['packages']);
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formSelectRow(array(
		'name' => 'ads',
		'multiple' => 'true',
	), $__compilerTemp1, array(
		'label' => 'Ads',
	)) . '
			<hr class="formRowSep" />
			' . $__templater->formSelectRow(array(
		'name' => 'packages',
		'multiple' => 'true',
	), $__compilerTemp2, array(
		'label' => 'Packages',
	)) . '
			<hr class="formRowSep" />
			' . $__templater->formRow('
				<div class="inputGroup">
					' . $__templater->formNumberBox(array(
		'name' => 'extend_time',
		'min' => '0',
		'class' => 'input--inline',
	)) . '
					&nbsp;
					' . $__templater->formSelect(array(
		'name' => 'extend_length',
		'class' => 'input--inline',
	), array(array(
		'value' => 'hours',
		'label' => 'Hours',
		'_type' => 'option',
	),
	array(
		'value' => 'days',
		'label' => 'Days',
		'_type' => 'option',
	))) . '
				</div>
			', array(
		'label' => 'Length',
	)) . '
			' . $__templater->formNumberBoxRow(array(
		'name' => 'views',
		'min' => '0',
	), array(
		'label' => 'Views',
	)) . '
			' . $__templater->formNumberBoxRow(array(
		'name' => 'clicks',
		'min' => '0',
	), array(
		'label' => 'Clicks',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'submit' => 'Extend',
	), array(
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('ads-manager/tools/mass-extend', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);