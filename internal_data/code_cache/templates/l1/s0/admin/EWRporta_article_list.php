<?php
// FROM HASH: 386ab19583ba5598aa45286d00b30230
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Articles');
	$__finalCompiled .= '

<div class="block">
	<div class="block-outer">
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'articles',
		'ajax' => $__templater->func('link', array('ewr-porta/articles', ), false),
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		<h3 class="block-header">' . 'Articles' . '</h3>
		
		<div class="block-body">
			';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['articles'])) {
		foreach ($__vars['articles'] AS $__vars['article']) {
			$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
			), array(array(
				'href' => $__templater->func('link', array('ewr-porta/articles/edit', $__vars['article'], ), false),
				'hash' => $__vars['article']['thread_id'],
				'label' => $__templater->escape($__vars['article']['Thread']['title']),
				'hint' => $__templater->escape($__vars['article']['article_title']),
				'dir' => 'auto',
				'_type' => 'main',
				'html' => '',
			),
			array(
				'href' => $__templater->func('link', array('ewr-porta/articles/edit', $__vars['article'], ), false),
				'_type' => 'action',
				'html' => '
								' . $__templater->func('date_dynamic', array($__vars['article']['article_date'], array(
			))) . '
						',
			),
			array(
				'href' => $__templater->func('link', array('ewr-porta/articles/delete', $__vars['article'], ), false),
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
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['articles'], $__vars['total'], ), true) . '</span>
		</div>
	</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'ewr-porta/articles',
		'wrapperclass' => 'js-filterHide block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>';
	return $__finalCompiled;
}
);