<?php
// FROM HASH: 49c5c11aeafb62e81aee4420e9cd76a9
return array(
'macros' => array('copy_key' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'url' => '!',
		'success' => '!',
		'targclass' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<code class="' . $__templater->escape($__vars['targclass']) . '" style="display:none;">' . $__templater->escape($__vars['url']) . '</code>
	' . $__templater->button('', array(
		'icon' => 'copy',
		'data-xf-init' => 'copy-to-clipboard',
		'data-copy-target' => '.' . $__vars['targclass'],
		'data-success' => $__vars['success'],
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('meeting_list');
	$__finalCompiled .= '

';
	if (!$__templater->func('count', array($__vars['meetings'], ), false)) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('add_meeting', array(
			'href' => $__templater->func('link', array('meeting/add', ), false),
			'icon' => 'user',
		), '', array(
		)) . '
	');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['meetings'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['meetings'])) {
			foreach ($__vars['meetings'] AS $__vars['meeting']) {
				$__compilerTemp1 .= '
						';
				$__compilerTemp2 = '';
				if ($__vars['meeting']['Thread']) {
					$__compilerTemp2 .= '
									<a href="' . $__templater->func('link_type', array('public', 'threads', $__vars['meeting']['Thread'], ), true) . '" target="_blank">' . $__templater->escape($__vars['meeting']['Thread']['title']) . '</a>
									';
				} else {
					$__compilerTemp2 .= '
									0
								';
				}
				$__compilerTemp1 .= $__templater->dataRow(array(
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['meeting']['topic']),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__templater->method($__vars['meeting'], 'getStartDate', array())),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__templater->method($__vars['meeting'], 'getStartTime', array())),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->escape($__vars['meeting']['duration']) . ' mints',
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->callMacro(null, 'copy_key', array(
					'url' => $__vars['meeting']['z_start_url'],
					'success' => 'start url successfully copy.',
					'targclass' => 'js-startUrl' . $__vars['meeting']['meetingId'],
				), $__vars),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->callMacro(null, 'copy_key', array(
					'url' => $__vars['meeting']['z_join_url'],
					'success' => 'Join url successfully copy.',
					'targclass' => 'js-joinUrl' . $__vars['meeting']['meetingId'],
				), $__vars),
				),
				array(
					'_type' => 'cell',
					'html' => '
								' . $__compilerTemp2 . '
							',
				),
				array(
					'href' => $__templater->func('link', array('meeting/edit', $__vars['meeting'], ), false),
					'_type' => 'action',
					'html' => 'Edit',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-outer">
			' . $__templater->callMacro('filter_macros', 'quick_filter', array(
			'key' => 'meetings',
			'class' => 'block-outer-opposite',
		), $__vars) . '
		</div>
		<div class="block-container">
			<div class="block-body">

				' . $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'zoom_topic',
		),
		array(
			'_type' => 'cell',
			'html' => 'Start date',
		),
		array(
			'_type' => 'cell',
			'html' => 'start_time',
		),
		array(
			'_type' => 'cell',
			'html' => 'duration',
		),
		array(
			'_type' => 'cell',
			'html' => 'start_url',
		),
		array(
			'_type' => 'cell',
			'html' => 'join_url',
		),
		array(
			'_type' => 'cell',
			'html' => 'disucssion',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		))) . '
					' . $__compilerTemp1 . '
				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['meetings'], $__vars['total'], ), true) . '</span>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('meeting/toggle', ), false),
			'class' => 'block',
			'ajax' => 'true',
		)) . '
	';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No results found.' . '</div>
';
	}
	$__finalCompiled .= '


' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'meeting',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '

';
	return $__finalCompiled;
}
);