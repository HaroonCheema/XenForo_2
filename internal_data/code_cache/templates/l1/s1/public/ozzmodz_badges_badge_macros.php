<?php
// FROM HASH: 256dc68075c66fa53adf5c9df42285ec
return array(
'macros' => array('badge_category' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'category' => '!',
		'content' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="badge-category badge-category--' . $__templater->escape($__vars['category']['badge_category_id']) . ' ' . $__templater->escape($__vars['category']['class']) . ' block">
		<div class="block-container">
			<div class="block-header">
				';
	if ($__vars['category']['icon_type']) {
		$__finalCompiled .= '
					' . $__templater->callMacro(null, 'category_icon', array(
			'category' => $__vars['category'],
		), $__vars) . '
				';
	}
	$__finalCompiled .= '
				
				';
	if ($__vars['category']['badge_category_id'] != 0) {
		$__finalCompiled .= '
					' . $__templater->escape($__vars['category']['title']) . '
				';
	} else {
		$__finalCompiled .= '
					' . 'Uncategorized' . '
				';
	}
	$__finalCompiled .= '
			</div>
			
			<div class="block-body">
				' . $__templater->escape($__vars['content']) . '
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'category_icon' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'category' => '!',
		'context' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['category']['icon_type'] == 'fa') {
		$__finalCompiled .= '
		' . $__templater->fontAwesome($__templater->escape($__vars['category']['fa_icon']), array(
			'class' => 'category-icon category-icon--fa',
		)) . '
	';
	} else if ($__vars['category']['icon_type'] == 'mdi') {
		$__finalCompiled .= '
		<i class="mdi ' . $__templater->escape($__vars['category']['mdi_icon']) . ' category-icon category-icon--mdi"></i>
	';
	} else if ($__vars['category']['icon_type'] == 'asset') {
		$__finalCompiled .= '
		';
		if (($__vars['category']['image_url_2x'] OR $__vars['category']['image_url_3x']) OR $__vars['category']['image_url_4x']) {
			$__finalCompiled .= '
			';
			$__vars['srcSets'] = array(0 => $__templater->func('base_url', array($__vars['category']['image_url'], ), false) . ' 1x', );
			$__finalCompiled .= '

			';
			if ($__vars['category']['image_url_2x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(1 => $__templater->func('base_url', array($__vars['category']['image_url_2x'], ), false) . ' 2x', ));
			}
			$__finalCompiled .= '
			';
			if ($__vars['category']['image_url_3x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(2 => $__templater->func('base_url', array($__vars['category']['image_url_3x'], ), false) . ' 3x', ));
			}
			$__finalCompiled .= '
			';
			if ($__vars['category']['image_url_4x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(3 => $__templater->func('base_url', array($__vars['category']['image_url_4x'], ), false) . ' 4x', ));
			}
			$__finalCompiled .= '

			<img srcset="' . $__templater->filter($__vars['srcSets'], array(array('join', array(', ', )),), true) . '" loading="lazy" src="' . $__templater->func('base_url', array($__vars['category']['image_url'], ), true) . '">
		';
		} else {
			$__finalCompiled .= '
			<img class="category-icon category-icon--img" loading="lazy"  src="' . $__templater->func('base_url', array($__vars['category']['image_url'], ), true) . '" />
		';
		}
		$__finalCompiled .= '
	';
	} else {
		$__finalCompiled .= '
		';
		if (($__vars['category']['image_url_2x'] OR $__vars['category']['image_url_3x']) OR $__vars['category']['image_url_4x']) {
			$__finalCompiled .= '
			';
			$__vars['srcSets'] = array(0 => $__vars['category']['image_url'] . ' 1x', );
			$__finalCompiled .= '

			';
			if ($__vars['category']['image_url_2x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(1 => $__vars['category']['image_url_2x'] . ' 2x', ));
			}
			$__finalCompiled .= '
			';
			if ($__vars['category']['image_url_3x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(2 => $__vars['category']['image_url_3x'] . ' 3x', ));
			}
			$__finalCompiled .= '
			';
			if ($__vars['category']['image_url_4x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(3 => $__vars['category']['image_url_4x'] . ' 4x', ));
			}
			$__finalCompiled .= '
			
			<img srcset="' . $__templater->filter($__vars['srcSets'], array(array('join', array(', ', )),), true) . '" loading="lazy" src="' . $__templater->escape($__vars['category']['image_url']) . '">
		';
		} else {
			$__finalCompiled .= '
			<img class="category-icon category-icon--img" loading="lazy" src="' . $__templater->escape($__vars['category']['image_url']) . '"  />
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
'badge' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'badge' => '!',
		'iconStyles' => '',
		'reason' => false,
		'counter' => false,
		'extra' => '',
		'extraHeader' => '',
		'extraMinor' => '',
		'stackedBadges' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<div class="badgeItem badgeItem--' . $__templater->escape($__vars['badge']['badge_id']) . ' ' . $__templater->escape($__vars['badge']['class']) . ' block-row block-row--separated ' . ($__vars['badge']['badge_tier_id'] ? ('ozzmodzBadges-tier--' . $__templater->escape($__vars['badge']['badge_tier_id'])) : '') . '">
		<div class="contentRow">
			<div class="contentRow-figure">
				<div class="contentRow-figureIcon">
					' . $__templater->callMacro(null, 'badge_icon', array(
		'badge' => $__vars['badge'],
		'iconStyles' => $__vars['iconStyles'],
	), $__vars) . '
				</div>
			</div>
			
			<div class="contentRow-main">
				';
	if ($__vars['extra']) {
		$__finalCompiled .= '
					<div class="contentRow-extra">
						' . $__templater->filter($__vars['extra'], array(array('raw', array()),), true) . '
					</div>
				';
	}
	$__finalCompiled .= '
				
				<h3 class="contentRow-header">
					<span class="title">' . $__templater->escape($__vars['badge']['title']) . '</span>
					
					';
	if ($__vars['extraHeader']) {
		$__finalCompiled .= '
						' . $__templater->escape($__vars['extraHeader']) . '
					';
	}
	$__finalCompiled .= '
				</h3>

				<div class="contentRow-lesser">
					' . $__templater->escape($__vars['badge']['description']) . '
				</div>

				<div class="badge-extra contentRow-spaced contentRow-minor">
					';
	if ($__vars['counter']) {
		$__finalCompiled .= '
						';
		if ($__templater->method($__vars['xf']['visitor'], 'canViewAwardedBadgesList', array())) {
			$__finalCompiled .= '
							<a href="' . $__templater->func('link', array('ozzmodz-badges/awarded-list', $__vars['badge'], ), true) . '" class="extra-item badge-awarded" title="' . 'Awarded users' . '">
								' . $__templater->fontAwesome('fa-users', array(
			)) . ' ' . $__templater->escape($__vars['badge']['awarded_number']) . '
							</a>
						';
		} else {
			$__finalCompiled .= '
							' . $__templater->fontAwesome('fa-users', array(
			)) . ' ' . $__templater->escape($__vars['badge']['awarded_number']) . '
						';
		}
		$__finalCompiled .= '
					';
	}
	$__finalCompiled .= '
					
					';
	if ($__vars['reason']) {
		$__finalCompiled .= '
						<div class="extra-item reason" title="' . 'Award reason' . '">
							' . $__templater->fontAwesome('fa-info-circle', array(
		)) . '
							';
		if ($__vars['xf']['options']['ozzmodz_badges_allowAwardReasonHtml']) {
			$__finalCompiled .= '
								' . $__templater->filter($__vars['reason'], array(array('raw', array()),), true) . '
							';
		} else {
			$__finalCompiled .= '
								' . $__templater->func('structured_text', array($__vars['reason'], ), true) . '
							';
		}
		$__finalCompiled .= '
						</div>
					';
	}
	$__finalCompiled .= '
					
					';
	if ($__vars['extraMinor']) {
		$__finalCompiled .= '
						' . $__templater->escape($__vars['extraMinor']) . '
					';
	}
	$__finalCompiled .= '
				</div>
				
				
				';
	if ($__vars['stackedBadges']) {
		$__finalCompiled .= '
					<div class="contentRow-lesser contentRow-badgeStack">
						<ul class="listInline listInline--block">
							';
		if ($__templater->isTraversable($__vars['stackedBadges'])) {
			foreach ($__vars['stackedBadges'] AS $__vars['stackedBadge']) {
				$__finalCompiled .= '
								<li>
									<div class="badge-stacked">
										' . $__templater->callMacro(null, 'badge_icon', array(
					'badge' => $__vars['stackedBadge']['Badge'],
					'tooltip' => $__vars['stackedBadge']['Badge']['title'],
				), $__vars) . '

										';
				if ($__vars['stackedBadge']['featured']) {
					$__finalCompiled .= '
											<a href="' . $__templater->func('link', array('user-badges/feature', $__vars['stackedBadge'], ), true) . '"
											   class="featureIcon featureIcon--featured featureIcon--stacked"
											   title="' . 'Unfeature badge' . '">
												' . $__templater->fontAwesome('fad fa-bullhorn', array(
					)) . '
											</a>
										';
				}
				$__finalCompiled .= '
									</div>

								</li>
							';
			}
		}
		$__finalCompiled .= '
						</ul>
					</div>
				';
	}
	$__finalCompiled .= '
				
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'badge_icon' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'badge' => '!',
		'iconStyles' => '',
		'context' => '',
		'tooltip' => '',
		'stackedCount' => '0',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['class'] = 'badgeIcon badgeIcon--' . $__vars['badge']['badge_id'] . ' badgeIcon--' . $__vars['badge']['icon_type'] . ($__vars['context'] ? (' badgeIcon-context--' . $__vars['context']) : '');
	$__finalCompiled .= '
	
	';
	$__vars['label'] = $__templater->preEscaped('
		<span class="label">
			' . $__templater->filter($__vars['stackedCount'], array(array('number_short', array()),), true) . '
		</span>
	');
	$__finalCompiled .= '
	
	';
	$__compilerTemp1 = '';
	if ($__vars['badge']['icon_type'] == 'fa') {
		$__compilerTemp1 .= '
			' . $__templater->fontAwesome($__templater->escape($__vars['badge']['fa_icon']), array(
			'class' => $__vars['class'],
			'style' => $__vars['iconStyles'],
		)) . '
		';
	} else if ($__vars['badge']['icon_type'] == 'mdi') {
		$__compilerTemp1 .= '
			<i class="mdi ' . $__templater->escape($__vars['badge']['mdi_icon']) . ' ' . $__templater->escape($__vars['class']) . '" style="' . $__templater->escape($__vars['iconStyles']) . '"></i>
		';
	} else if ($__vars['badge']['icon_type'] == 'html') {
		$__compilerTemp1 .= '
			<div class="' . $__templater->escape($__vars['class']) . '" style="' . $__templater->escape($__vars['iconStyles']) . '">' . $__templater->filter($__vars['badge']['html_icon'], array(array('raw', array()),), true) . '</div>
		';
	} else if ($__vars['badge']['icon_type'] == 'asset') {
		$__compilerTemp1 .= '
			';
		if (($__vars['badge']['image_url_2x'] OR $__vars['badge']['image_url_3x']) OR $__vars['badge']['image_url_4x']) {
			$__compilerTemp1 .= '
				';
			$__vars['srcSets'] = array(0 => $__templater->func('base_url', array($__vars['badge']['image_url'], ), false) . ' 1x', );
			$__compilerTemp1 .= '

				';
			if ($__vars['badge']['image_url_2x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(1 => $__templater->func('base_url', array($__vars['badge']['image_url_2x'], ), false) . ' 2x', ));
			}
			$__compilerTemp1 .= '
				';
			if ($__vars['badge']['image_url_3x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(2 => $__templater->func('base_url', array($__vars['badge']['image_url_3x'], ), false) . ' 3x', ));
			}
			$__compilerTemp1 .= '
				';
			if ($__vars['badge']['image_url_4x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(3 => $__templater->func('base_url', array($__vars['badge']['image_url_4x'], ), false) . ' 4x', ));
			}
			$__compilerTemp1 .= '

				<img class="' . $__templater->escape($__vars['class']) . '" loading="lazy" srcset="' . $__templater->filter($__vars['srcSets'], array(array('join', array(', ', )),), true) . '"
					 alt="' . $__templater->escape($__vars['badge']['alt_description']) . '"
					 src="' . $__templater->func('base_url', array($__vars['badge']['image_url'], ), true) . '">
			';
		} else {
			$__compilerTemp1 .= '
				<img class="' . $__templater->escape($__vars['class']) . '" loading="lazy" src="' . $__templater->func('base_url', array($__vars['badge']['image_url'], ), true) . '">
			';
		}
		$__compilerTemp1 .= '
		';
	} else {
		$__compilerTemp1 .= '
			';
		if (($__vars['badge']['image_url_2x'] OR $__vars['badge']['image_url_3x']) OR $__vars['badge']['image_url_4x']) {
			$__compilerTemp1 .= '
				';
			$__vars['srcSets'] = array(0 => $__vars['badge']['image_url'] . ' 1x', );
			$__compilerTemp1 .= '

				';
			if ($__vars['badge']['image_url_2x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(1 => $__vars['badge']['image_url_2x'] . ' 2x', ));
			}
			$__compilerTemp1 .= '
				';
			if ($__vars['badge']['image_url_3x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(2 => $__vars['badge']['image_url_3x'] . ' 3x', ));
			}
			$__compilerTemp1 .= '
				';
			if ($__vars['badge']['image_url_4x']) {
				$__vars['srcSets'] = ($__vars['srcSets'] + array(3 => $__vars['badge']['image_url_4x'] . ' 4x', ));
			}
			$__compilerTemp1 .= '

				<img class="' . $__templater->escape($__vars['class']) . '" loading="lazy" srcset="' . $__templater->filter($__vars['srcSets'], array(array('join', array(', ', )),), true) . '"
					alt="' . $__templater->escape($__vars['badge']['alt_description']) . '"
					src="' . $__templater->escape($__vars['badge']['image_url']) . '">
			';
		} else {
			$__compilerTemp1 .= '
				<img class="' . $__templater->escape($__vars['class']) . '" loading="lazy" src="' . $__templater->escape($__vars['badge']['image_url']) . '">
			';
		}
		$__compilerTemp1 .= '
		';
	}
	$__compilerTemp2 = '';
	if ($__vars['stackedCount']) {
		$__compilerTemp2 .= $__templater->escape($__vars['label']);
	}
	$__vars['template'] = $__templater->preEscaped('
		' . $__compilerTemp1 . '
		
		' . $__compilerTemp2 . '
	');
	$__finalCompiled .= '
	
	';
	if (!$__templater->test($__vars['tooltip'], 'empty', array())) {
		$__finalCompiled .= '
		<span data-xf-init="tooltip" title="' . $__templater->escape($__vars['tooltip']) . '">' . $__templater->filter($__vars['template'], array(array('raw', array()),), true) . '</span>
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->filter($__vars['template'], array(array('raw', array()),), true) . '
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

' . '

';
	return $__finalCompiled;
}
);