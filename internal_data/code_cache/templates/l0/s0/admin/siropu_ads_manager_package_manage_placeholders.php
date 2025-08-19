<?php
// FROM HASH: 0bfd993ce0e425d2a3b0b8d1d8375d65
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Manage placeholders');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['packages'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = array();
		$__compilerTemp1[] = array(
			'label' => 'Without placeholders',
			'_type' => 'optgroup',
			'options' => array(),
		);
		end($__compilerTemp1); $__compilerTemp2 = key($__compilerTemp1);
		if ($__templater->isTraversable($__vars['packages'])) {
			foreach ($__vars['packages'] AS $__vars['package']) {
				if (($__vars['package']['placeholder_id'] == 0)) {
					$__compilerTemp1[$__compilerTemp2]['options'][] = array(
						'value' => $__vars['package']['package_id'],
						'label' => $__templater->escape($__vars['package']['title']) . ' (' . $__templater->func('sam_type_phrase', array($__vars['package']['type'], ), true) . ')',
						'_type' => 'option',
					);
				}
			}
		}
		$__compilerTemp1[] = array(
			'label' => 'With placeholders',
			'_type' => 'optgroup',
			'options' => array(),
		);
		end($__compilerTemp1); $__compilerTemp3 = key($__compilerTemp1);
		if ($__templater->isTraversable($__vars['packages'])) {
			foreach ($__vars['packages'] AS $__vars['package']) {
				if (($__vars['package']['placeholder_id'] > 0)) {
					$__compilerTemp1[$__compilerTemp3]['options'][] = array(
						'value' => $__vars['package']['package_id'],
						'label' => $__templater->escape($__vars['package']['title']) . ' (' . $__templater->func('sam_type_phrase', array($__vars['package']['type'], ), true) . ')',
						'_type' => 'option',
					);
				}
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->formInfoRow('
					' . 'Placeholders are special ads used for displaying an "advertise here" message on empty package positions, in order to attract advertisers.' . '
				', array(
			'rowtype' => 'confirm',
		)) . '
				' . $__templater->formSelectRow(array(
			'name' => 'packages[]',
			'value' => $__vars['packageIds'],
			'size' => '15',
			'multiple' => 'true',
		), $__compilerTemp1, array(
			'label' => 'Packages',
			'explain' => 'For multiple selections, hold down Ctrl (Command for Macs) while clicking selections. ',
		)) . '

				' . $__templater->formCheckBoxRow(array(
		), array(array(
			'name' => 'use_as_backup',
			'value' => '1',
			'label' => 'Use placeholder as backup ad (Can be edited from ad list)',
			'_type' => 'option',
		)), array(
		)) . '

				' . $__templater->formRadioRow(array(
			'name' => 'action',
			'value' => 'enable',
		), array(array(
			'value' => 'enable',
			'label' => 'Enable placeholders',
			'_type' => 'option',
		),
		array(
			'value' => 'disable',
			'label' => 'Disable placeholders',
			'_type' => 'option',
		)), array(
		)) . '
			</div>
			' . $__templater->formSubmitRow(array(
			'icon' => 'save',
		), array(
		)) . '
		</div>
	', array(
			'action' => $__templater->func('link', array('ads-manager/packages/manage-placeholders', ), false),
			'class' => 'block',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'siropu_ads_manager_enable_placeholders_no_packages' . '</div>
';
	}
	return $__finalCompiled;
}
);