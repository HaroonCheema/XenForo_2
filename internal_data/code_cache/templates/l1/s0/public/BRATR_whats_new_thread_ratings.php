<?php
// FROM HASH: bcccbde4818c8e5c0f25ac34d92986e8
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('New Thread Ratings');
	$__templater->pageParams['pageNumber'] = $__vars['page'];
	$__finalCompiled .= '

';
	$__compilerTemp1 = $__vars;
	$__compilerTemp1['pageSelected'] = $__templater->preEscaped('bratr-new-ratings');
	$__templater->wrapTemplate('whats_new_wrapper', $__compilerTemp1);
	$__finalCompiled .= '

<div class="block" data-type="profile_post">
	<div class="block-container">
		';
	if ($__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
			<div class="block-filterBar">
				<div class="filterBar">
					';
		$__compilerTemp2 = '';
		$__compilerTemp2 .= '
								' . '
								';
		if ($__vars['findNew']['filters']['followed']) {
			$__compilerTemp2 .= '
									<li><a href="' . $__templater->func('link', array('whats-new/thread-ratings', $__vars['findNew'], array('remove' => 'followed', ), ), true) . '"
										class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
										<span class="filterBar-filterToggle-label">' . 'Show only' . '</span>
										' . 'Followed members' . '</a></li>
								';
		}
		$__compilerTemp2 .= '
								' . '
							';
		if (strlen(trim($__compilerTemp2)) > 0) {
			$__finalCompiled .= '
						<ul class="filterBar-filters">
							' . $__compilerTemp2 . '
						</ul>
					';
		}
		$__finalCompiled .= '

					<a class="filterBar-menuTrigger" data-xf-click="menu" role="button" tabindex="0" aria-expanded="false" aria-haspopup="true">' . 'Filters' . '</a>
					<div class="menu" data-menu="menu" aria-hidden="true">
						<div class="menu-content">
							<h4 class="menu-header">' . 'Show only' . $__vars['xf']['language']['label_separator'] . '</h4>
							' . $__templater->form('
								<div class="menu-row">
									' . $__templater->formCheckBox(array(
		), array(array(
			'name' => 'followed',
			'selected' => $__vars['findNew']['filters']['followed'],
			'label' => 'Members you follow',
			'_type' => 'option',
		))) . '
								</div>

								' . $__templater->callMacro('filter_macros', 'find_new_filter_footer', array(), $__vars) . '
							', array(
			'action' => $__templater->func('link', array('whats-new/thread-ratings', ), false),
		)) . '
						</div>
					</div>
				</div>
			</div>
		';
	}
	$__finalCompiled .= '

		';
	if ($__vars['findNew']['result_count']) {
		$__finalCompiled .= '
			' . $__templater->callMacro('BRATR_rating_macros', 'review_list', array(
			'reviews' => $__vars['ratings'],
		), $__vars) . '
		';
	} else {
		$__finalCompiled .= '
			<div class="block-row">' . 'No results found.' . '</div>
		';
	}
	$__finalCompiled .= '
	</div>

	';
	if ($__vars['findNew']['result_count']) {
		$__finalCompiled .= '
		' . $__templater->func('show_ignored', array(array(
			'wrapperclass' => 'block-outer-opposite block-outer block-outer--after',
		))) . '
		' . $__templater->func('page_nav', array(array(
			'page' => $__vars['page'],
			'total' => $__vars['findNew']['result_count'],
			'link' => 'whats-new/thread-ratings',
			'data' => $__vars['findNew'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	';
	}
	$__finalCompiled .= '
</div>';
	return $__finalCompiled;
}
);