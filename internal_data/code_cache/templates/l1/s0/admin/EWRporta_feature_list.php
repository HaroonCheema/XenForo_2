<?php
// FROM HASH: a8a3ea47620d230b741953a97fcdfd67
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Features');
	$__finalCompiled .= '

<div class="block">
	<div class="block-outer">
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'features',
		'ajax' => $__templater->func('link', array('ewr-porta/features', ), false),
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		<h3 class="block-header">' . 'Features' . '</h3>
		
		<div class="block-body">
			';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['features'])) {
		foreach ($__vars['features'] AS $__vars['feature']) {
			$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
			), array(array(
				'hash' => $__vars['feature']['thread_id'],
				'href' => $__templater->func('link', array('ewr-porta/features/edit', $__vars['feature'], ), false),
				'label' => $__templater->escape($__vars['feature']['Thread']['title']),
				'hint' => $__templater->escape($__vars['feature']['feature_title']),
				'dir' => 'auto',
				'_type' => 'main',
				'html' => '',
			),
			array(
				'href' => $__templater->func('link', array('ewr-porta/features/edit', $__vars['feature'], ), false),
				'_type' => 'action',
				'html' => '
							' . $__templater->func('date_dynamic', array($__vars['feature']['feature_date'], array(
			))) . '
						',
			),
			array(
				'href' => $__templater->func('link', array('ewr-porta/features/delete', $__vars['feature'], ), false),
				'tooltip' => 'Delete',
				'_type' => 'delete',
				'html' => '',
			))) . '
				';
		}
	}
	$__compilerTemp2 = '';
	if ($__vars['filter'] AND ($__vars['total'] > $__vars['perPage'])) {
		$__compilerTemp2 .= '
					' . $__templater->dataRow(array(
			'rowclass' => 'dataList-row--note dataList-row--noHover js-filterForceShow',
		), array(array(
			'colspan' => '2',
			'_type' => 'cell',
			'html' => 'There are more records matching your filter. Please be more specific.',
		))) . '
				';
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp1 . '
				' . $__compilerTemp2 . '
			', array(
	)) . '
		</div>
		
		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['features'], $__vars['total'], ), true) . '</span>
		</div>
	</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'ewr-porta/features',
		'wrapperclass' => 'js-filterHide block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>';
	return $__finalCompiled;
}
);