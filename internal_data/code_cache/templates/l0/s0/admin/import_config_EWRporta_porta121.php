<?php
// FROM HASH: 68c5554aaf42f76d1dcae5d4c57601f0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<h3 class="block-formSectionHeader">' . 'Source database configuration' . '</h3>
';
	if (!$__vars['baseConfig']['db']['host']) {
		$__finalCompiled .= '
	' . $__templater->formTextBoxRow(array(
			'name' => 'config[db][host]',
			'value' => 'localhost',
			'placeholder' => '$config[\'db\'][\'host\']',
		), array(
			'label' => 'MySQL server',
		)) . '
	' . $__templater->formTextBoxRow(array(
			'name' => 'config[db][port]',
			'value' => '3306',
			'placeholder' => '$config[\'db\'][\'port\']',
		), array(
			'label' => 'MySQL port',
		)) . '
	' . $__templater->formTextBoxRow(array(
			'name' => 'config[db][username]',
			'placeholder' => '$config[\'db\'][\'username\']',
		), array(
			'label' => 'MySQL username',
		)) . '
	' . $__templater->formTextBoxRow(array(
			'name' => 'config[db][password]',
			'autocomplete' => 'off',
			'placeholder' => '$config[\'db\'][\'password\']',
		), array(
			'label' => 'MySQL password',
		)) . '
	' . $__templater->formTextBoxRow(array(
			'name' => 'config[db][dbname]',
			'placeholder' => '$config[\'db\'][\'dbname\']',
		), array(
			'label' => 'MySQL database name',
		)) . '
';
	} else {
		$__finalCompiled .= '
	' . $__templater->formRow($__templater->escape($__vars['fullConfig']['db']['host']) . ':' . $__templater->escape($__vars['fullConfig']['db']['dbname']), array(
			'label' => 'MySQL server',
		)) . '
';
	}
	return $__finalCompiled;
}
);