<?php
// FROM HASH: 841b1e4216e27e584620429b4cd37612
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('IP addresses logged for ' . $__templater->escape($__vars['user']['username']) . '');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['ips'])) {
		foreach ($__vars['ips'] AS $__vars['ip']) {
			$__compilerTemp1 .= '
					
					';
			$__vars['userCount'] = 'count($ip.users)';
			$__compilerTemp1 .= '
					
					';
			$__compilerTemp2 = '';
			if (!$__templater->test($__vars['ip']['users'], 'empty', array())) {
				$__compilerTemp2 .= '
								<ul class="listInline listInline--comma">
									';
				if ($__templater->isTraversable($__vars['ip']['users'])) {
					foreach ($__vars['ip']['users'] AS $__vars['user']) {
						$__compilerTemp2 .= '
										' . trim('
											<li>
												' . $__templater->func('username_link', array($__vars['user'], true, array(
							'href' => $__templater->func('link', array('members', $__vars['user'], ), false),
						))) . '
											</li>
										') . '
									';
					}
				}
				$__compilerTemp2 .= '
								</ul>
							';
			} else {
				$__compilerTemp2 .= '
								' . 'None' . '
							';
			}
			$__compilerTemp1 .= $__templater->dataRow(array(
				'rowclass' => 'dataList-row--noHover',
			), array(array(
				'href' => $__templater->func('link', array('misc/ip-info', null, array('ip' => $__templater->filter($__vars['ip']['ip'], array(array('ip', array()),), false), ), ), false),
				'target' => '_blank',
				'_type' => 'cell',
				'html' => $__templater->filter($__vars['ip']['ip'], array(array('ip', array()),), true),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->filter($__vars['ip']['total'], array(array('number', array()),), true),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->func('date_dynamic', array($__vars['ip']['first_date'], array(
			))),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->func('date_dynamic', array($__vars['ip']['last_date'], array(
			))),
			),
			array(
				'_type' => 'cell',
				'html' => '
							' . $__compilerTemp2 . '
						',
			))) . '
				';
		}
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => 'IP',
	),
	array(
		'_type' => 'cell',
		'html' => 'Total',
	),
	array(
		'_type' => 'cell',
		'html' => 'Earliest',
	),
	array(
		'_type' => 'cell',
		'html' => 'Latest',
	),
	array(
		'_type' => 'cell',
		'html' => '&nbsp;',
	))) . '
				' . $__compilerTemp1 . '
			', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);