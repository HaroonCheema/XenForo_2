<?php
// FROM HASH: 93db5c8fd74a85cfa9626cc9a38dd291
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['package'], 'hasPlaceholder', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Disable placeholder');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Enable placeholder');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__templater->method($__vars['package'], 'hasPlaceholder', array())) {
		$__compilerTemp1 .= '
					' . 'Please confirm that you want to disable the placeholder.' . '
				';
	} else {
		$__compilerTemp1 .= '
					<p>' . 'Please confirm that you want to enable the placeholder.' . '</p>

					' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'name' => 'use_as_backup',
			'value' => '1',
			'label' => 'Use placeholder as backup ad (Can be edited from ad list)',
			'_type' => 'option',
		))) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				' . $__compilerTemp1 . '
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'confirm',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array('ads-manager/packages/manage-placeholder', $__vars['package'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);