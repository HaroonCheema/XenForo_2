<?php
// FROM HASH: e494eb14027096b0c9f98acc313f06ca
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Authors');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add author', array(
		'href' => $__templater->func('link', array('ewr-porta/authors/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

<div class="block">
	<div class="block-outer">
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'authors',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		<h3 class="block-header">' . 'Authors' . '</h3>
		<div class="block-body">
			';
	$__compilerTemp1 = '';
	$__compilerTemp2 = true;
	if ($__templater->isTraversable($__vars['authors'])) {
		foreach ($__vars['authors'] AS $__vars['author']) {
			$__compilerTemp2 = false;
			$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
			), array(array(
				'hash' => $__vars['author']['user_id'],
				'href' => $__templater->func('link', array('ewr-porta/authors/edit', $__vars['author'], ), false),
				'label' => $__templater->escape($__vars['author']['author_name']),
				'_type' => 'main',
				'html' => '',
			),
			array(
				'href' => $__templater->func('link', array('ewr-porta/authors/edit', $__vars['author'], ), false),
				'_type' => 'cell',
				'html' => '
							<span class="dataList-hint">' . $__templater->escape($__vars['author']['author_status']) . '</span>
						',
			),
			array(
				'href' => $__templater->func('link', array('ewr-porta/authors/edit', $__vars['author'], ), false),
				'_type' => 'action',
				'html' => '
							' . $__templater->escape($__vars['author']['author_order']) . '
						',
			),
			array(
				'href' => $__templater->func('link', array('ewr-porta/authors/delete', $__vars['author'], ), false),
				'_type' => 'delete',
				'html' => '',
			))) . '
				';
		}
	}
	if ($__compilerTemp2) {
		$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
			'rowclass' => 'dataList-row--noHover dataList-row--note',
		), array(array(
			'class' => 'dataList-cell--noSearch',
			'_type' => 'cell',
			'html' => '
							' . 'No items to display' . '
						',
		))) . '
				';
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp1 . '
			', array(
	)) . '
		</div>
		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['total'], ), true) . '</span>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);