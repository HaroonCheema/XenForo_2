<?php
// FROM HASH: 2f7bfa74afffc823c7b0b2bdd67f38e4
return array(
'macros' => array('featured_badges' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'location' => '!',
		'user' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if (!$__templater->test($__vars['user'], 'empty', array())) {
		$__finalCompiled .= '
		';
		if ($__templater->func('property', array('ozzmodz_badges_tiers_show', ), false)) {
			$__finalCompiled .= '
			';
			$__compilerTemp1 = '';
			$__compilerTemp1 .= '
						';
			$__compilerTemp2 = $__templater->method($__vars['user'], 'getCachedBadgeTiers', array());
			if ($__templater->isTraversable($__compilerTemp2)) {
				foreach ($__compilerTemp2 AS $__vars['userTier']) {
					$__compilerTemp1 .= '
							' . $__templater->callMacro(null, 'tier_label', array(
						'user' => $__vars['user'],
						'count' => $__vars['userTier']['count'],
						'tier' => $__vars['userTier']['Tier'],
					), $__vars) . '
						';
				}
			}
			$__compilerTemp1 .= '
					';
			if (strlen(trim($__compilerTemp1)) > 0) {
				$__finalCompiled .= '
				<div class="ozzmodzBadges-tiers ozzmodzBadges-tiers--' . $__templater->escape($__vars['location']) . '">
					' . $__compilerTemp1 . '
				</div>
			';
			}
			$__finalCompiled .= '
		';
		}
		$__finalCompiled .= '
		';
		$__compilerTemp3 = '';
		$__compilerTemp3 .= '
					';
		if ($__vars['user']['cached_featured_badges']) {
			$__compilerTemp3 .= '
						';
			if ($__templater->isTraversable($__vars['user']['cached_featured_badges'])) {
				foreach ($__vars['user']['cached_featured_badges'] AS $__vars['userBadge']) {
					if (!$__templater->test($__vars['userBadge']['Badge'], 'empty', array())) {
						$__compilerTemp3 .= '
							' . $__templater->callMacro(null, 'badge', array(
							'user' => $__vars['user'],
							'userBadge' => $__vars['userBadge'],
							'location' => $__vars['location'],
						), $__vars) . '
						';
					}
				}
			}
			$__compilerTemp3 .= '
					';
		} else {
			$__compilerTemp3 .= '
						';
			if ($__templater->isTraversable($__vars['user']['cached_badges'])) {
				foreach ($__vars['user']['cached_badges'] AS $__vars['userBadge']) {
					if (!$__templater->test($__vars['userBadge']['Badge'], 'empty', array())) {
						$__compilerTemp3 .= '
							' . $__templater->callMacro(null, 'badge', array(
							'user' => $__vars['user'],
							'userBadge' => $__vars['userBadge'],
							'location' => $__vars['location'],
						), $__vars) . '
						';
					}
				}
			}
			$__compilerTemp3 .= '
					';
		}
		$__compilerTemp3 .= '
				';
		if (strlen(trim($__compilerTemp3)) > 0) {
			$__finalCompiled .= '
			<div class="featuredBadges featuredBadges--' . $__templater->escape($__vars['location']) . '">
				' . $__compilerTemp3 . '
			</div>
		';
		}
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'tier_label' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
		'count' => '!',
		'tier' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<em class="ozzmodzBadges-tierLabel ozzmodzBadges-tierLabel--' . $__templater->escape($__vars['tier']['badge_tier_id']) . '" data-xf-init="tooltip"
		title="' . ($__vars['tier']['title_phrase'] ? $__templater->filter($__templater->func('phrase_dynamic', array($__vars['tier']['title_phrase'], ), false), array(array('for_attr', array()),), true) : '') . '">
		' . $__templater->escape($__vars['count']) . '
	</em>
';
	return $__finalCompiled;
}
),
'badge' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
		'userBadge' => '!',
		'location' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['badge'] = $__vars['userBadge']['Badge'];
	$__finalCompiled .= '
	
	';
	$__compilerTemp1 = '';
	if ($__vars['userBadge']['reason']) {
		$__compilerTemp1 .= '
				<br />
				';
		if ($__vars['xf']['options']['ozzmodz_badges_allowAwardReasonHtml']) {
			$__compilerTemp1 .= '
					' . $__templater->filter($__vars['userBadge']['reason'], array(array('raw', array()),array('strip_tags', array($__templater->filter($__vars['xf']['options']['ozzmodz_badges_allowedTooltipTags'], array(array('split', array('nl', )),), false), )),), true) . '
				';
		} else {
			$__compilerTemp1 .= '
					' . $__templater->filter($__templater->func('structured_text', array($__vars['userBadge']['reason'], ), false), array(array('strip_tags', array($__templater->filter($__vars['xf']['options']['ozzmodz_badges_allowedTooltipTags'], array(array('split', array('nl', )),), false), )),), true) . '
				';
		}
		$__compilerTemp1 .= '
			';
	}
	$__vars['tooltipHtml'] = $__templater->preEscaped('
		<span class="tooltip-element">
			<b>' . ($__vars['badge']['title_phrase'] ? $__templater->func('phrase_dynamic', array($__vars['badge']['title_phrase'], ), true) : '') . '</b>
			' . $__compilerTemp1 . '
		</span>
	');
	$__finalCompiled .= '
	
	';
	$__vars['featuredBadgeClasses'] = 'featuredBadge' . ($__vars['userBadge']['badge_id'] ? (' featuredBadge--' . $__vars['userBadge']['badge_id']) : '') . ($__vars['badge']['class'] ? (' ' . $__vars['badge']['class']) : '');
	$__finalCompiled .= '

	';
	if ($__vars['badge']['badge_link']) {
		$__finalCompiled .= '
		';
		$__vars['badgeLink'] = $__vars['badge']['badge_link'];
		$__finalCompiled .= '
		';
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['badge']['badge_link_attributes'])) {
			foreach ($__vars['badge']['badge_link_attributes'] AS $__vars['name'] => $__vars['value']) {
				$__compilerTemp2 .= '
				' . $__templater->escape($__vars['name']) . '="' . $__templater->escape($__vars['value']) . '" 
			';
			}
		}
		$__vars['badgeLinkAttributes'] = $__templater->preEscaped(trim('
			' . $__compilerTemp2 . '
		'));
		$__finalCompiled .= '
	';
	} else if ($__vars['user'] AND $__templater->method($__vars['user'], 'canViewBadgesTab', array())) {
		$__finalCompiled .= '
		';
		$__vars['badgeLink'] = $__templater->func('link', array('members', $__vars['user'], ), false) . '#badges';
		$__finalCompiled .= '
	';
	}
	$__finalCompiled .= '
	
	';
	if (!$__templater->test($__vars['badgeLink'], 'empty', array())) {
		$__finalCompiled .= '
		<a href="' . $__templater->escape($__vars['badgeLink']) . '" 
		   class="' . $__templater->escape($__vars['featuredBadgeClasses']) . '"
		   ' . $__templater->filter($__vars['badgeLinkAttributes'], array(array('raw', array()),), true) . '
		   data-xf-init="element-tooltip" 
		   data-element="| .tooltip-element">
			' . $__templater->callMacro('ozzmodz_badges_badge_macros', 'badge_icon', array(
			'badge' => $__vars['badge'],
			'context' => 'featured-' . $__vars['location'],
			'stackedCount' => (($__templater->func('property', array('ozzmodz_badges_show_stacked_counter', ), false) AND $__vars['userBadge']['stacked_count']) ? ($__vars['userBadge']['stacked_count'] + 1) : 0),
		), $__vars) . '
			' . $__templater->filter($__vars['tooltipHtml'], array(array('raw', array()),), true) . '
		</a>
	';
	} else {
		$__finalCompiled .= '
		<span class="' . $__templater->escape($__vars['featuredBadgeClasses']) . '"
			  data-xf-init="element-tooltip" 
			  data-element="| .tooltip-element">
			' . $__templater->callMacro('ozzmodz_badges_badge_macros', 'badge_icon', array(
			'badge' => $__vars['badge'],
			'context' => 'featured-' . $__vars['location'],
			'stackedCount' => ($__templater->func('property', array('ozzmodz_badges_show_stacked_counter', ), false) AND ($__vars['userBadge']['stacked_count'] ? ($__vars['userBadge']['stacked_count'] + 1) : 0)),
		), $__vars) . '
			' . $__templater->filter($__vars['tooltipHtml'], array(array('raw', array()),), true) . '
		</span>
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
	$__finalCompiled .= '

' . '

';
	return $__finalCompiled;
}
);