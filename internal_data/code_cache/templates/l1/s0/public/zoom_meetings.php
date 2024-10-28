<?php
// FROM HASH: 9f5f50abbfd1db17892623fb2e062e73
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
        data-href="' . $__templater->func('link', array('meetings/refine-search', null, $__vars['conditions'], ), true) . '"
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
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Zoom Meetings');
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

';
	$__templater->setPageParam('searchConstraints', array('Auctions' => array('search_type' => 'fs_auction_auctions', ), ));
	$__finalCompiled .= '

';
	$__templater->includeCss('general_zoom_meeting.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('zoom_meeting_list.less');
	$__finalCompiled .= '
<div class="block" data-type="zoom-meeting">
	
	<div class="block-container">
		' . $__templater->callMacro(null, 'search_menu', array(
		'conditions' => $__vars['conditions'],
	), $__vars) . '
		<!--Listing View--->
		<div class="block-body">
				';
	if (!$__templater->test($__vars['meetings'], 'empty', array())) {
		$__finalCompiled .= '
					
					<div class="structItemContainer">
						';
		if ($__templater->isTraversable($__vars['meetings'])) {
			foreach ($__vars['meetings'] AS $__vars['meeting']) {
				$__finalCompiled .= '
							' . $__templater->callMacro('zoom_meeting_listing_list_macros', 'listing', array(
					'meeting' => $__vars['meeting'],
				), $__vars) . '  ';
			}
		}
		$__finalCompiled .= '
						</div>
				
				';
	} else {
		$__finalCompiled .= '
						<div class="block-row"> ' . 'No Meeting Found.' . ' </div>
				';
	}
	$__finalCompiled .= '
			<div class="block-footer"> <span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['meetings'], $__vars['total'], ), true) . '</span
        >
      </div>
    </div>
  </div>

  <div class="block-outer block-outer--after">
    ' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'meetings',
		'params' => $__vars['filters'],
		'wrapperclass' => 'block-outer-main',
		'perPage' => $__vars['perPage'],
	))) . '
    ' . $__templater->func('show_ignored', array(array(
		'wrapperclass' => 'block-outer-opposite',
	))) . '
  </div>
</div>

';
	$__templater->setPageParam('sideNavTitle', 'Categories');
	$__finalCompiled .= '

';
	$__templater->modifySideNavHtml(null, '
  ' . $__templater->callMacro('zoom_meeting_category_list_macros', 'simple_list_block', array(
		'categoryTree' => $__vars['categoryTree'],
	), $__vars) . '
', 'replace');
	$__finalCompiled .= '

<!-- Filter Bar Macro Start -->

';
	return $__finalCompiled;
}
);