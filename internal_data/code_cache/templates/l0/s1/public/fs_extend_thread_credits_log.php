<?php
// FROM HASH: b0fc4ecabb66e050c18628c17b6e59aa
return array(
'macros' => array('search_menu' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'conditions' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block-filterBar">
		<div class="filterBar">
			<a
			   class="filterBar-menuTrigger"
			   data-xf-click="menu"
			   role="button"
			   tabindex="0"
			   aria-expanded="false"
			   aria-haspopup="true"
			   >' . 'Filters' . '</a
				>
			<div
				 class="menu menu--wide"
				 data-menu="menu"
				 aria-hidden="true"
				 data-href="' . $__templater->func('link', array('thread-credits-log/refine-search', null, $__vars['conditions'], ), true) . '"
				 data-load-target=".js-filterMenuBody"
				 >
				<div class="menu-content">
					<h4 class="menu-header">' . 'Show only' . $__vars['xf']['language']['label_separator'] . '</h4>
					<div class="js-filterMenuBody">
						<div class="menu-row">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
					</div>
				</div>
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'record_table_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'data' => $__vars['data'],
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => ' ' . 'Thread title' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Purchase at' . ' ',
	),
	array(
		'_type' => 'cell',
		'html' => ' ' . 'Credit used' . ' ',
	))) . '
	';
	if ($__templater->isTraversable($__vars['data'])) {
		foreach ($__vars['data'] AS $__vars['val']) {
			$__finalCompiled .= '
		' . $__templater->dataRow(array(
			), array(array(
				'href' => $__templater->func('link', array('threads', $__vars['val']['Thread'], ), false),
				'_type' => 'cell',
				'html' => ' ' . $__templater->func('snippet', array($__vars['val']['Thread']['title'], 60, array('stripBbCode' => true, ), ), true) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' ' . $__templater->func('date_dynamic', array($__vars['val']['purchased_at'], array(
			))) . ' ',
			),
			array(
				'_type' => 'cell',
				'html' => ' 1 ',
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
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped(' ' . 'Thread Credit Logs' . ' ');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

<div class="block">

	<div class="block-outer">
		' . $__templater->callMacro('fs_extend_thread_filter_macro', 'quick_filter', array(
		'key' => 'thread-credits-log',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">

		' . $__templater->callMacro(null, 'search_menu', array(
		'conditions' => $__vars['conditions'],
	), $__vars) . '

		<div class="block-body">

			';
	$__compilerTemp1 = '';
	if (!$__templater->test($__vars['data'], 'empty', array())) {
		$__compilerTemp1 .= '

					' . $__templater->callMacro(null, 'record_table_list', array(
			'data' => $__vars['data'],
		), $__vars) . '
					';
	} else {
		$__compilerTemp1 .= '
					<div class="blockMessage">
						' . 'No items have been created yet.' . '
					</div>
				';
	}
	$__finalCompiled .= $__templater->dataList('
				' . $__compilerTemp1 . '
			', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
		</div>

		<div class="block-footer">
			<span class="block-footer-counter"
				  >' . $__templater->func('display_totals', array($__vars['totalReturn'], $__vars['total'], ), true) . '</span
				>
		</div>

	</div>
	<div class="block-outer block-outer--after">
		' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'thread-credits-log',
		'data' => $__vars['data'],
		'params' => $__vars['conditions'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
		' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite',
	))) . '
	</div>
</div>

' . '

';
	return $__finalCompiled;
}
);