<?php
// FROM HASH: 72970393ec9fc4d00e32646ebaf83123
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Members awarded with this badge');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'metaNoindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

';
	$__templater->breadcrumbs($__vars['breadcrumbs']);
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		';
	if (!$__templater->test($__vars['userBadges'], 'empty', array())) {
		$__finalCompiled .= '
			<ol class="block-body">
				';
		if ($__templater->isTraversable($__vars['userBadges'])) {
			foreach ($__vars['userBadges'] AS $__vars['userBadge']) {
				$__finalCompiled .= '
					<li class="block-row block-row--separated">
						';
				$__vars['user'] = $__vars['userBadge']['User'];
				$__finalCompiled .= '

						<div class="contentRow">
							<div class="contentRow-figure">
								' . $__templater->func('avatar', array($__vars['user'], 's', false, array(
					'notooltip' => 'true',
				))) . '
							</div>

							<div class="contentRow-main">
								<div class="contentRow-extra">
									' . $__templater->func('date_dynamic', array($__vars['userBadge']['award_date'], array(
				))) . '
								</div>

								<h3 class="contentRow-header">' . $__templater->func('username_link', array($__vars['user'], true, array(
					'notooltip' => 'true',
				))) . '</h3>

								<div class="contentRow-snippet" title="' . 'Award reason' . '">
									';
				if ($__vars['xf']['options']['ozzmodz_badges_allowAwardReasonHtml']) {
					$__finalCompiled .= '
										' . $__templater->filter($__vars['userBadge']['reason'], array(array('raw', array()),), true) . '
									';
				} else {
					$__finalCompiled .= '
										' . $__templater->escape($__vars['userBadge']['reason']) . '
									';
				}
				$__finalCompiled .= '
								</div>
							</div>
						</div>
					</li>
				';
			}
		}
		$__finalCompiled .= '
			</ol>
		';
	} else {
		$__finalCompiled .= '
			<div class="block-body block-row">' . 'No results found.' . '</div>
		';
	}
	$__finalCompiled .= '
	</div>

	' . $__templater->func('page_nav', array(array(
		'page' => $__vars['page'],
		'total' => $__vars['total'],
		'link' => 'ozzmodz-badges/awarded-list',
		'data' => $__vars['badge'],
		'wrapperclass' => 'block-outer block-outer--after',
		'perPage' => $__vars['perPage'],
	))) . '
</div>';
	return $__finalCompiled;
}
);