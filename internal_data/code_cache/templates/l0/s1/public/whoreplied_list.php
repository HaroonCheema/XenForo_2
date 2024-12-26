<?php
// FROM HASH: 10fcf19fb670e19e73af1dabb4948f4a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']) . ' - ' . 'Members Who Replied this thread');
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '
';
	$__templater->pageParams['pageH1'] = $__templater->preEscaped('Members Who Replied this thread');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__templater->method($__vars['thread'], 'getBreadcrumbs', array()));
	$__finalCompiled .= '

<div class="blockMessage">
    <dl class="pairs pairs--inline">
        <dt>' . 'Thread' . '</dt>
        <dd><a href="' . $__templater->func('link', array('threads', $__vars['thread'], ), true) . '">' . $__templater->func('prefix', array('thread', $__vars['thread'], 'escaped', ), true) . $__templater->escape($__vars['thread']['title']) . '</a></dd>
    </dl>
</div>

';
	$__vars['paginationSetting'] = ($__vars['xf']['options']['svWhoRepliedPagination'] ?: 'ajax_filter');
	$__finalCompiled .= '
';
	$__vars['useDropdownSubmit'] = ($__templater->func('count', array($__vars['perPageChoices'], ), false) > 1);
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'sv/vendor/domurl/url.js',
		'addon' => 'SV/StandardLib',
		'min' => '1',
	));
	$__finalCompiled .= '
';
	if (($__vars['paginationSetting'] == 'standard') AND $__vars['useDropdownSubmit']) {
		$__finalCompiled .= '
    ';
		$__templater->includeJs(array(
			'src' => 'sv/lib/dropdownSubmit.js',
			'addon' => 'SV/StandardLib',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	} else if ($__vars['paginationSetting'] == 'ajax') {
		$__finalCompiled .= '
    ';
		$__templater->includeJs(array(
			'src' => 'sv/lib/ajaxPagination.js',
			'addon' => 'SV/StandardLib',
			'min' => '1',
		));
		$__finalCompiled .= '
';
	} else if ($__vars['paginationSetting'] == 'ajax_filter') {
		$__finalCompiled .= '
    ';
		$__templater->includeJs(array(
			'src' => 'xf/filter.js',
			'min' => '1',
		));
		$__finalCompiled .= '
    ';
		$__templater->includeJs(array(
			'src' => 'sv/lib/xf/filter.js',
			'addon' => 'SV/StandardLib',
			'min' => '1',
		));
		$__finalCompiled .= '

    <script class="js-extraPhrases" type="application/json">
        {
            "no_items_matched_your_filter": "' . $__templater->filter('No items matched your filter.', array(array('escape', array('js', )),), true) . '"
        }
    </script>
    ';
		$__templater->includeCss('sv_quick_filter.less');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if (($__vars['paginationSetting'] == 'standard') AND $__vars['useDropdownSubmit']) {
		$__compilerTemp1 .= '
        sv-dropdown-submit
    ';
	} else if ($__vars['paginationSetting'] == 'ajax') {
		$__compilerTemp1 .= '
        sv-ajax-pagination
    ';
	} else if ($__vars['paginationSetting'] == 'ajax_filter') {
		$__compilerTemp1 .= '
        sv-dynamic-filter
    ';
	}
	$__vars['xfInit'] = $__templater->preEscaped(trim('
    ' . $__compilerTemp1 . '
'));
	$__finalCompiled .= '

<div class="block ' . $__templater->escape($__vars['xfInit']) . '" data-xf-init="' . $__templater->escape($__vars['xfInit']) . '"
     data-key="who-replied"
     data-global-find="' . false . '"
     data-ajax="' . $__templater->func('link', array('threads/who-replied', $__vars['thread'], array('per_page' => $__vars['perPage'], ), ), true) . '"
     data-per-page-cookie-prefix="svWhoReplied_"
     data-content-wrapper=".block-body--whoRepliedBody"
     data-page-nav-wrapper=".whoreplied-pagenav">
    ';
	if (!$__templater->test($__vars['users'], 'empty', array())) {
		$__finalCompiled .= '
        <div class="block-outer">
            <div class="block-outer-main">
                <div class="whoreplied-pagenav whoreplied-pagenav--top" style="display:inline-block;">
                    ' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'threads/who-replied',
			'data' => $__vars['thread'],
			'params' => (($__vars['addParamsToPageNav'] ? $__vars['linkFilters'] : array()) + array('per_page' => $__vars['perPage'], )),
			'wrapperclass' => 'block-outer block-outer--after block-outer--page-nav-wrapper',
			'perPage' => $__vars['perPage'],
		))) . '
                </div>

                ';
		if ($__vars['useDropdownSubmit']) {
			$__finalCompiled .= '
                    <div class="block-outer" style="display:inline-block;">
                        <div class="inputGroup">
                            <span class="inputGroup-text">' . 'Users per page' . $__vars['xf']['language']['label_separator'] . '</span>
                            ';
			$__compilerTemp2 = array();
			if ($__templater->isTraversable($__vars['perPageChoices'])) {
				foreach ($__vars['perPageChoices'] AS $__vars['perPageChoice']) {
					$__compilerTemp2[] = array(
						'value' => $__vars['perPageChoice'],
						'label' => $__templater->escape($__vars['perPageChoice']),
						'_type' => 'option',
					);
				}
			}
			$__finalCompiled .= $__templater->formSelect(array(
				'name' => 'per_page',
				'value' => $__vars['perPage'],
				'class' => 'input--inline input--autoSize',
			), $__compilerTemp2) . '
                        </div>
                    </div>
                ';
		}
		$__finalCompiled .= '
            </div>

            ';
		if ($__vars['paginationSetting'] == 'ajax_filter') {
			$__finalCompiled .= '
                <div class="block-outer-opposite quickFilter u-jsOnly">
                    <div class="inputGroup inputGroup--inline inputGroup--joined">
                        <input type="text" class="input js-filterInput" value="' . $__templater->escape($__vars['filter']['text']) . '" placeholder="' . $__templater->filter('Filter' . $__vars['xf']['language']['ellipsis'], array(array('for_attr', array()),), true) . '" data-xf-key="' . $__templater->filter('f', array(array('for_attr', array()),), true) . '" />
                        <span class="inputGroup-text">
                            ' . $__templater->formCheckBox(array(
				'standalone' => 'true',
			), array(array(
				'class' => 'js-filterPrefix',
				'label' => 'Prefix',
				'checked' => $__vars['filter']['prefix'],
				'_type' => 'option',
			))) . '
                        </span>
                        <i class="inputGroup-text js-filterClear is-disabled" aria-hidden="true"></i>
                    </div>
                </div>
            ';
		}
		$__finalCompiled .= '
        </div>

        <div class="block-container">
            <div class="block-body userList block-body--whoRepliedBody">
                ';
		$__vars['canSearch'] = $__templater->method($__vars['xf']['visitor'], 'canSearch', array());
		$__finalCompiled .= '
                ';
		if ($__templater->isTraversable($__vars['users'])) {
			foreach ($__vars['users'] AS $__vars['userId'] => $__vars['user']) {
				$__finalCompiled .= '
                    <li class="block-row block-row--separated userList-row js-filterSearchable">
                        ';
				$__compilerTemp3 = '';
				if ($__vars['canSearch']) {
					$__compilerTemp3 .= '
                                    <a href="' . $__templater->func('link', array('search/search', '', array('c[users]' => $__vars['user']['username'], 'search_type' => 'post', 'c[thread]' => $__vars['thread']['thread_id'], 'order' => 'date', ), ), true) . '" target="_blank" title="' . $__templater->filter('See all posts from this user in this thread', array(array('for_attr', array()),), true) . '">
                                        ' . $__templater->filter($__vars['user']['ThreadUserPost'][$__vars['thread']['thread_id']]['post_count'], array(array('number', array()),), true) . '
                                    </a>
                                ';
				} else {
					$__compilerTemp3 .= '
                                    ' . $__templater->filter($__vars['user']['ThreadUserPost'][$__vars['thread']['thread_id']]['post_count'], array(array('number', array()),), true) . '
                                ';
				}
				$__vars['extraTemplate'] = $__templater->preEscaped('
                            <div class="whoreplied--postcount">
                                ' . $__compilerTemp3 . '
                            </div>
                        ');
				$__finalCompiled .= '
                        ' . $__templater->callMacro(null, 'member_list_macros::item', array(
					'user' => $__vars['user'],
					'extraData' => $__vars['extraTemplate'],
					'extraDataBig' => '1',
				), $__vars) . '
                    </li>
                ';
			}
		}
		$__finalCompiled .= '
            </div>
            <div class="block-footer block-footer--split">
                <span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['users'], $__vars['total'], ), true) . '</span>
            </div>
        </div>

        <div class="whoreplied-pagenav whoreplied-pagenav--bottom">
            ' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'link' => 'threads/who-replied',
			'data' => $__vars['thread'],
			'params' => (($__vars['addParamsToPageNav'] ? $__vars['linkFilters'] : array()) + array('per_page' => $__vars['perPage'], )),
			'wrapperclass' => 'block-outer block-outer--after block-outer--page-nav-wrapper',
			'perPage' => $__vars['perPage'],
		))) . '
        </div>
    ';
	} else {
		$__finalCompiled .= '
        <div class="blockMessage">' . 'No records matched.' . '</div>
    ';
	}
	$__finalCompiled .= '

    ' . $__templater->formHiddenVal('final_url', $__vars['finalUrl'], array(
	)) . '
</div>';
	return $__finalCompiled;
}
);