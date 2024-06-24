<?php
// FROM HASH: 4f2ef1136ce8f7a589b1f9f839c2ab16
return array(
'macros' => array('table_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'data' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => ' ' . 'Password' . ' ',
	))) . '
	';
	if ($__templater->isTraversable($__vars['data'])) {
		foreach ($__vars['data'] AS $__vars['value']) {
			$__finalCompiled .= '
		' . $__templater->dataRow(array(
			), array(array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['value']['auth_password']) . ' ',
			))) . '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'copy_emmbed_code' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'link' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<code class="js-copyTarget">
		&lt;iframe src="' . $__templater->escape($__vars['link']) . '" style="border:none; width:100%; height:350px;" title="Proxy-link passwords page"&gt;&lt;/iframe&gt;
	</code>
	' . $__templater->button('', array(
		'icon' => 'copy',
		'data-xf-init' => 'copy-to-clipboard',
		'data-copy-target' => '.js-copyTarget',
		'data-success' => 'Code copied to clipboard',
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
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['data'], 'empty', array())) {
		$__compilerTemp1 .= '
			<div class="block-body">
				' . $__templater->dataList('

					' . $__templater->callMacro(null, 'table_list', array(
			'data' => $__vars['data'],
		), $__vars) . '

				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
				<div class="block-footer">
					<span class="block-footer-counter"
						  >' . $__templater->func('display_totals', array($__vars['totalReturn'], $__vars['total'], ), true) . '</span
						>
				</div>

			</div>
			';
	} else {
		$__compilerTemp1 .= '
			<div class="block-body block-row">' . 'No items have been created yet.' . '</div>

		';
	}
	$__finalCompiled .= $__templater->form('

	<div class="block-container">

		' . $__compilerTemp1 . '

	</div>

	<div class="block-body block-row"></div>

	<div class="block-container">
		<div class="block-body">
			<div class="blockMessage blockMessage--important blockMessage--iconic">
				' . 'To embed this page in WordPress or anywhere, click the Copy button to copy the following code and paste it on any web-page where you want to display it.' . '
				<div style="margin: 1em 0; text-align: center">
					' . $__templater->callMacro(null, 'copy_emmbed_code', array(
		'link' => $__vars['link'],
	), $__vars) . '
				</div>
			</div>
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array($__vars['prefix'] . '/toggle', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '
' . '

';
	return $__finalCompiled;
}
);