<?php
// FROM HASH: 1d7175a4c9ffbd7554f00538dd3f8bb2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Banned users');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['userBans'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="block-body">
				';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['userBans'])) {
			foreach ($__vars['userBans'] AS $__vars['userBan']) {
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['userBan']['User']['username']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['userBan']['BanUser']['username']),
				),
				array(
					'_type' => 'cell',
					'html' => ($__vars['userBan']['end_date'] ? $__templater->func('date', array($__vars['userBan']['end_date'], ), true) : 'Permanent'),
				),
				array(
					'_type' => 'cell',
					'html' => ($__templater->escape($__vars['userBan']['user_reason']) ?: 'N/A'),
				),
				array(
					'_type' => 'cell',
					'html' => ' <a href="' . $__templater->func('link', array('members/ban', $__vars['userBan']['User'], ), true) . '" data-xf-click="overlay">' . 'Edit ban' . '</a>',
				),
				array(
					'href' => $__templater->func('link', array('threads', $__vars['userBan']['Thread'], ), false),
					'ajex' => 'true',
					'data-xf-click' => 'overlay',
					'_type' => 'action',
					'html' => 'Appeal',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Username',
		),
		array(
			'_type' => 'cell',
			'html' => 'Banned by',
		),
		array(
			'_type' => 'cell',
			'html' => 'End date',
		),
		array(
			'_type' => 'cell',
			'html' => 'Reason',
		),
		array(
			'_type' => 'cell',
			'html' => '&nbsp;',
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
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['userBans'], $__vars['total'], ), true) . '</span>
			</div>
		</div>

		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'banned-users',
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	</div>
	';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There are no banned users.' . '</div>
';
	}
	return $__finalCompiled;
}
);