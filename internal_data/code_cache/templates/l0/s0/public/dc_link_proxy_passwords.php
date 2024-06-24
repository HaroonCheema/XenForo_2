<?php
// FROM HASH: bc2a6d0e8e112294dccb2741d2807ab0
return array(
'macros' => array('copy_password' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'password' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<span class="js-passwordCopyTarget">' . $__templater->escape($__vars['password']) . '</span>
	' . $__templater->button('', array(
		'icon' => 'copy',
		'data-xf-init' => 'copy-to-clipboard',
		'data-copy-target' => '.js-passwordCopyTarget',
		'data-success' => 'password_copied_to_clipboard',
		'class' => 'button--link is-hidden',
	), '', array(
	)) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Link Proxy Active Passwords');
	$__finalCompiled .= '

';
	$__templater->setPageParam('template', 'DC_CUSTOM_PAGE_CONTAINER');
	$__finalCompiled .= '

<div class="block-container">
	';
	if (!$__templater->test($__vars['passwords'], 'empty', array())) {
		$__finalCompiled .= '
		<div class="block-body">
			';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['passwords'])) {
			foreach ($__vars['passwords'] AS $__vars['value']) {
				$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => ' ' . $__templater->escape($__vars['value']['auth_password']) . ' ',
				))) . '
				';
			}
		}
		$__finalCompiled .= $__templater->dataList('
				' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => ' ' . 'Password' . ' ',
		))) . '
				' . $__compilerTemp1 . '
			', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '

			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['passwords'], $__vars['total'], ), true) . '</span>
			</div>
		</div>
		';
	} else {
		$__finalCompiled .= '
		<div class="block-body block-row">' . 'No items have been created yet.' . '</div>
	';
	}
	$__finalCompiled .= '
</div>

';
	return $__finalCompiled;
}
);