<?php
// FROM HASH: d72657682cdf2decc4f635025acba2b5
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('[FS] Zoom Meeting');
	$__finalCompiled .= '

';
	if ($__templater->test($__vars['meeting'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
		' . $__templater->button('Add Meeting', array(
			'href' => $__templater->func('link', array('zoom-meeting/add', ), false),
			'icon' => 'user',
		), '', array(
		)) . '
	');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['meeting'], 'empty', array())) {
		$__finalCompiled .= '
	' . $__templater->form('
		<div class="block-container">
			<div class="block-body">

				' . $__templater->dataList('
					' . $__templater->dataRow(array(
			'rowtype' => 'header',
		), array(array(
			'_type' => 'cell',
			'html' => 'Topic',
		),
		array(
			'_type' => 'cell',
			'html' => 'Start date',
		),
		array(
			'_type' => 'cell',
			'html' => 'Start Time',
		),
		array(
			'_type' => 'cell',
			'html' => 'Duration',
		),
		array(
			'class' => 'dataList-cell--min',
			'_type' => 'cell',
			'html' => '&nbsp;',
		))) . '

					' . $__templater->dataRow(array(
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
			'href' => $__templater->func('link', array('zoom-meeting/edit', $__vars['meeting'], ), false),
			'_type' => 'action',
			'html' => 'Edit',
		))) . '

				', array(
			'data-xf-init' => 'responsive-data-list',
		)) . '
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('zoom-meeting/toggle', ), false),
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

';
	return $__finalCompiled;
}
);