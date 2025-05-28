<?php
// FROM HASH: b8c0a5da4e2d920e1161ba57c0e8129f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<hr class="formRowSep" />

' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[currentPageLink]',
		'selected' => $__vars['options']['currentPageLink'],
		'label' => 'Enable current page referral link',
		'_type' => 'option',
	)), array(
		'explain' => 'This option allows you to display the referral link of the current page viewed.',
	));
	return $__finalCompiled;
}
);