<?php
// FROM HASH: 0fa1a453c2d5efd6bda2782f6a698d16
return array(
'macros' => array('menu' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'userBadge' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="contentRow-extra">
		
		';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
						';
	if ($__templater->method($__vars['userBadge'], 'canEdit', array())) {
		$__compilerTemp1 .= '
							<a href="' . $__templater->func('link', array('user-badges/edit', $__vars['userBadge'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">
								' . $__templater->fontAwesome('fa-pencil', array(
		)) . ' ' . 'Edit' . '
							</a>
						';
	}
	$__compilerTemp1 .= '
						';
	if ($__templater->method($__vars['userBadge'], 'canDelete', array())) {
		$__compilerTemp1 .= '
							<a href="' . $__templater->func('link', array('user-badges/delete', $__vars['userBadge'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">
								' . $__templater->fontAwesome('fa-undo', array(
		)) . ' ' . 'Take away badge' . '
							</a>
						';
	}
	$__compilerTemp1 .= '
					';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
			' . $__templater->button('
				' . $__templater->fontAwesome('fa-cog', array(
		)) . '
			', array(
			'class' => 'button--link menuTrigger',
			'data-xf-click' => 'menu',
			'aria-label' => 'More options',
			'aria-expanded' => 'false',
			'aria-haspopup' => 'true',
		), '', array(
		)) . '
			<div class="menu" data-menu="menu" aria-hidden="true">
				<div class="menu-content">
					' . $__compilerTemp1 . '
				</div>
			</div>
		';
	}
	$__finalCompiled .= '
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Badges awarded to ' . $__templater->escape($__vars['user']['username']) . '');
	$__finalCompiled .= '

';
	$__templater->setPageParam('head.' . 'noindex', $__templater->preEscaped('<meta name="robots" content="noindex" />'));
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped($__templater->escape($__vars['user']['username'])), $__templater->func('link', array('members', $__vars['user'], ), false), array(
	));
	$__finalCompiled .= '

';
	$__vars['footer'] = $__templater->preEscaped('
	<div class="block-footer block-footer--split">
		<span class="block-footer-counter">' . 'Total badges' . $__vars['xf']['language']['label_separator'] . ' ' . $__templater->escape($__vars['totalBadges']) . '</span>
		<span class="block-footer-controls">		
			' . $__templater->button('
				' . 'View all available badges' . '
			', array(
		'href' => $__templater->func('link', array('help', array('page_name' => 'ozzmodz_badges', ), ), false),
	), '', array(
	)) . '
		</span>
	</div>
');
	$__finalCompiled .= '

';
	if ($__templater->isTraversable($__vars['badgeCategories'])) {
		foreach ($__vars['badgeCategories'] AS $__vars['catId'] => $__vars['category']) {
			$__finalCompiled .= '
	';
			$__compilerTemp1 = '';
			if ($__templater->isTraversable($__vars['userBadges'][$__vars['catId']])) {
				foreach ($__vars['userBadges'][$__vars['catId']] AS $__vars['badgeId'] => $__vars['userBadge']) {
					$__compilerTemp1 .= '

			';
					$__compilerTemp2 = '';
					if ($__templater->method($__vars['userBadge'], 'canManageFeatured', array())) {
						$__compilerTemp2 .= '
					';
						if ($__vars['userBadge']['featured'] OR $__templater->method($__vars['userBadge'], 'canAddFeatured', array())) {
							$__compilerTemp2 .= '
						<a href="' . $__templater->func('link', array('user-badges/feature', $__vars['userBadge'], ), true) . '"
						   class="featureIcon ' . ($__vars['userBadge']['featured'] ? 'featureIcon--featured' : '') . '"
						   title="' . ($__vars['userBadge']['featured'] ? 'Unfeature badge' : 'Feature badge') . '">
							' . $__templater->fontAwesome('fa-bullhorn', array(
							)) . '
						</a>
					';
						}
						$__compilerTemp2 .= '
				';
					}
					$__vars['extraHeader'] = $__templater->preEscaped('
				' . $__compilerTemp2 . '
			');
					$__compilerTemp1 .= '
			
			';
					$__vars['extra'] = $__templater->preEscaped('
				' . $__templater->callMacro(null, 'menu', array(
						'userBadge' => $__vars['userBadge'],
					), $__vars) . '
			');
					$__compilerTemp1 .= '
			
			';
					$__vars['extraMinor'] = $__templater->preEscaped('
				' . $__templater->func('date_dynamic', array($__vars['userBadge']['award_date'], array(
					))) . '
			');
					$__compilerTemp1 .= '
			
			' . $__templater->callMacro('ozzmodz_badges_badge_macros', 'badge', array(
						'badge' => $__vars['userBadge']['Badge'],
						'reason' => $__vars['userBadge']['reason'],
						'extra' => $__vars['extra'],
						'extraHeader' => $__vars['extraHeader'],
						'extraMinor' => $__vars['extraMinor'],
						'stackedBadges' => ($__vars['xf']['options']['ozzmodz_badges_stackBadgesMemberTab'] ? $__vars['userBadge']['StackedUserBadges'] : array()),
					), $__vars) . '
		';
				}
			}
			$__vars['catContent'] = $__templater->preEscaped('
		' . $__compilerTemp1 . '
	');
			$__finalCompiled .= '

	';
			if ($__vars['totalCategories'] == 1) {
				$__finalCompiled .= '
		<div class="block">
			<div class="block-container">
				' . $__templater->escape($__vars['catContent']) . '
				' . $__templater->escape($__vars['footer']) . '
			</div>
		</div>
	';
			} else {
				$__finalCompiled .= '
		' . $__templater->callMacro('ozzmodz_badges_badge_macros', 'badge_category', array(
					'category' => $__vars['category'],
					'content' => $__vars['catContent'],
				), $__vars) . '
	';
			}
			$__finalCompiled .= '
';
		}
	}
	$__finalCompiled .= '

';
	if ($__vars['totalCategories'] != 1) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			' . $__templater->escape($__vars['footer']) . '
		</div>
	</div>
';
	}
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);