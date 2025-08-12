<?php
// FROM HASH: 17518e28b66d2b5da13f5a133df8e9d5
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
		'html' => ' ' . 'Url' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Icon' . ' ',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '',
	))) . '
	';
	if ($__templater->isTraversable($__vars['data'])) {
		foreach ($__vars['data'] AS $__vars['value']) {
			$__finalCompiled .= '
		' . $__templater->dataRow(array(
			), array(array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->escape($__vars['value']['fs_icon_url']) . ' ',
			),
			array(
				'href' => ($__templater->method($__vars['value'], 'isImage', array()) ? $__templater->func('base_url', array($__templater->method($__vars['value'], 'getImgUrl', array()), ), false) : '#'),
				'target' => '_blank',
				'_type' => 'cell',
				'html' => ' 
				<img src="' . $__templater->func('base_url', array($__templater->method($__vars['value'], 'getImgUrl', array()), ), true) . '" alt="image" width="100" height="100"/>
			',
			),
			array(
				'name' => 'enabled[' . $__vars['value']['id'] . ']',
				'selected' => $__vars['value']['enabled'],
				'class' => 'dataList-cell--separated',
				'submit' => 'true',
				'tooltip' => '',
				'_type' => 'toggle',
				'html' => '',
			),
			array(
				'href' => $__templater->func('link', array('nav-icon/edit', $__vars['value'], ), false),
				'_type' => 'action',
				'html' => 'Edit',
			),
			array(
				'href' => $__templater->func('link', array('nav-icon/delete', $__vars['value'], ), false),
				'overlay' => 'true',
				'_type' => 'delete',
				'html' => '',
			))) . '
	';
		}
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('[FS] All icons');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add icon', array(
		'href' => $__templater->func('link', array('nav-icon/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
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
	<div class="block-outer">
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'nav-icon',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>

	<div class="block-container">

		' . $__compilerTemp1 . '

	</div>


	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'nav-icon',
		'wrapperclass' => 'block',
		'perPage' => $__vars['perPage'],
	))) . '
', array(
		'action' => $__templater->func('link', array('nav-icon/toggle', ), false),
		'class' => 'block',
		'ajax' => 'true',
	)) . '
';
	return $__finalCompiled;
}
);