<?php
// FROM HASH: 1c234c122b59c0bb062b829347094007
return array(
'macros' => array('item_list' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'page' => '!',
		'items' => '!',
		'listClass' => '!',
		'link' => '!',
		'hasMore' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	if ($__vars['page'] == 1) {
		$__finalCompiled .= '
		';
		$__templater->wrapTemplate('xa_sc_dialog_wrapper', $__vars);
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '

	';
	if (!$__templater->test($__vars['items'], 'empty', array())) {
		$__finalCompiled .= '
		<div class="' . $__templater->escape($__vars['listClass']) . ' scItemList scItemList--picker">
			';
		if ($__templater->isTraversable($__vars['items'])) {
			foreach ($__vars['items'] AS $__vars['item']) {
				$__finalCompiled .= '
				<div data-type="item" data-id="' . $__templater->escape($__vars['item']['item_id']) . '" class="scItemList-item">
					' . $__templater->callMacro(null, 'item_display', array(
					'item' => $__vars['item'],
				), $__vars) . '

					<div class="contentRow-minor contentRow-minor--hideLinks">
						<ul class="listInline listInline--bullet">
							<li>' . $__templater->func('username_link', array($__vars['item']['User'], false, array(
					'defaultname' => $__vars['item']['username'],
				))) . '</li>
							<li>' . $__templater->func('date_dynamic', array($__vars['item']['create_date'], array(
				))) . '</li>
							';
				if ($__vars['item']['comment_count']) {
					$__finalCompiled .= '<li>' . 'Comments' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->filter($__vars['item']['comment_count'], array(array('number', array()),), true) . '</li>';
				}
				$__finalCompiled .= '
							<li>' . 'Category' . $__vars['xf']['language']['label_separator'] . ' <a href="' . $__templater->func('link', array('showcase/categories', $__vars['item']['Category'], ), true) . '">' . $__templater->escape($__vars['item']['Category']['title']) . '</a></li>
						</ul>
					</div>
				</div>
			';
			}
		}
		$__finalCompiled .= '

			' . $__templater->callMacro(null, 'footer', array(
			'link' => $__vars['link'],
			'append' => '.' . $__vars['listClass'],
			'page' => $__vars['page'],
			'hasMore' => $__vars['hasMore'],
		), $__vars) . '
		</div>
	';
	} else {
		$__finalCompiled .= '
		<div class="blockMessage">' . 'No items have been added yet.' . '</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'item_display' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'item' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['id'] = $__templater->func('unique_id', array(), false);
	$__finalCompiled .= '
	<input type="checkbox" class="scItemList-checkbox js-scItemsPicker" id="' . $__templater->escape($__vars['id']) . '" value="1" />
	<label for="' . $__templater->escape($__vars['id']) . '">' . $__templater->escape($__vars['item']['title']) . '</label>
';
	return $__finalCompiled;
}
),
'footer' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'link' => '!',
		'append' => '!',
		'page' => '1',
		'hasMore' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['hasMore']) {
		$__finalCompiled .= '
		<div class="scItemList-footer js-paneLoadMore">
			' . $__templater->button('
				' . 'More' . $__vars['xf']['language']['ellipsis'] . '
			', array(
			'data-xf-click' => 'inserter',
			'data-inserter-href' => $__templater->func('link', array($__vars['link'], null, array('page' => $__vars['page'] + 1, ), ), false),
			'data-append' => $__vars['append'],
			'data-replace' => '.js-paneLoadMore',
			'data-animate-replace' => '0',
		), '', array(
		)) . '
		</div>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Embed items');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'xenaddons/showcase/editor.js',
		'min' => '1',
	));
	$__finalCompiled .= '
';
	$__templater->includeCss('xa_sc_editor_dialog.less');
	$__finalCompiled .= '

<form class="block" id="xa_sc_editor_dialog_form">
	<div class="block-container">
		<h2 class="block-minorTabHeader tabs scEmbedTabs hScroller"
			data-xf-init="tabs h-scroller"
			data-panes=".js-embedShowcasePanes"
			role="tablist">

			<span class="hScroller-scroll">
				<a class="tabs-tab scEmbedTabs-tab is-active js-yourScItemsTab" role="tab" id="yourScItems">
					<span class="scEmbedTabs-tabLabel">' . 'Your items' . '</span>
					<span class="badge badge--highlighted js-tabCounter">0</span>
				</a>
				<a class="tabs-tab scEmbedTabs-tab js-browseScItemsTab" role="tab" id="browseScItems">
					<span class="scEmbedTabs-tabLabel">' . 'Others items' . '</span>
					<span class="badge badge--highlighted js-tabCounter">0</span>
				</a>
			</span>
		</h2>

		<ul class="tabPanes js-embedShowcasePanes">
			<li data-href="' . $__templater->func('link', array('showcase/dialog/yours', ), true) . '" role="tabpanel" aria-labelledby="yourScItems" data-tab=".js-yourScItemsTab">
				<div class="blockMessage">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
			</li>

			<li data-href="' . $__templater->func('link', array('showcase/dialog-browse', ), true) . '" role="tabpanel" aria-labelledby="browseScItems" data-tab=".js-browseScItemsTab">
				<div class="blockMessage">' . 'Loading' . $__vars['xf']['language']['ellipsis'] . '</div>
			</li>
		</ul>
		' . $__templater->formHiddenVal('', '{}', array(
		'class' => 'js-embedValue',
	)) . '
		' . $__templater->formSubmitRow(array(
		'submit' => 'Continue',
		'sticky' => 'true',
		'id' => 'xa_sc_editor_dialog_showcase',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
</form>

' . '

' . '

';
	return $__finalCompiled;
}
);