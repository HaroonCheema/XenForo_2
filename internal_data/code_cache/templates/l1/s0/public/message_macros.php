<?php
// FROM HASH: cf3fd758908ea405440f9fdcdba84271
return array(
'macros' => array('user_info' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
		'fallbackName' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	<section itemscope itemtype="https://schema.org/Person" class="message-user">
		<div class="message-avatar ' . (($__vars['xf']['options']['showMessageOnlineStatus'] AND ($__vars['user'] AND $__templater->method($__vars['user'], 'isOnline', array()))) ? 'message-avatar--online' : '') . '">
			<div class="message-avatar-wrapper">
				' . $__templater->func('avatar', array($__vars['user'], 'm', false, array(
		'defaultname' => $__vars['fallbackName'],
		'itemprop' => 'image',
	))) . '
				';
	if ($__vars['xf']['options']['showMessageOnlineStatus'] AND ($__vars['user'] AND $__templater->method($__vars['user'], 'isOnline', array()))) {
		$__finalCompiled .= '
					<span class="message-avatar-online" tabindex="0" data-xf-init="tooltip" data-trigger="auto" title="' . $__templater->filter('Online now', array(array('for_attr', array()),), true) . '"></span>
				';
	}
	$__finalCompiled .= '
			</div>
		</div>
		<div class="message-userDetails">
			<h4 class="message-name">' . $__templater->func('username_link', array($__vars['user'], true, array(
		'defaultname' => $__vars['fallbackName'],
		'itemprop' => 'name',
	))) . '</h4>
			' . $__templater->func('user_title', array($__vars['user'], true, array(
		'tag' => 'h5',
		'class' => 'message-userTitle',
		'itemprop' => 'jobTitle',
	))) . '
			' . $__templater->func('user_banners', array($__vars['user'], array(
		'tag' => 'div',
		'class' => 'message-userBanner',
		'itemprop' => 'jobTitle',
	))) . '

			';
	if ($__templater->func('property', array('ozzmodz_badges_show_in_message', ), false)) {
		$__finalCompiled .= '
				';
		$__templater->includeCss('ozzmodz_badges_featured_badges.less');
		$__finalCompiled .= '

				' . $__templater->callMacro('ozzmodz_badges_featured_badges_macros', 'featured_badges', array(
			'location' => 'message',
			'user' => $__vars['user'],
		), $__vars) . '
			';
	}
	$__finalCompiled .= '

';
	if ($__templater->func('property', array('af_pr_gift_postbit', ), false) AND $__templater->method($__vars['xf']['visitor'], 'canGiftUserUpgrade', array($__vars['user'], ))) {
		$__finalCompiled .= '
	' . $__templater->button('<i class="fa fa-gift" aria-hidden="true"></i> ' . 'Gift Upgrade', array(
			'class' => 'button--smaller button--fullWidth button--icon u-hideMedium',
			'href' => $__templater->func('link', array('purchase/gift-upgrade', null, array('userId' => $__vars['user']['user_id'], ), ), false),
			'overlay' => 'true',
		), '', array(
		)) . '
';
	}
	$__finalCompiled .= '
		</div>
		';
	if ($__vars['user']['user_id']) {
		$__finalCompiled .= '
			';
		if ($__templater->func('count', array($__vars['user']['team_ids'], ), false)) {
			$__finalCompiled .= '
	';
			if ($__templater->isTraversable($__vars['user']['team_ids'])) {
				foreach ($__vars['user']['team_ids'] AS $__vars['id']) {
					$__finalCompiled .= '
		';
					$__vars['urlImg'] = $__templater->method($__vars['user'], 'getImageUrl', array($__vars['id'], ));
					$__finalCompiled .= '
		';
					if ($__vars['urlImg']) {
						$__finalCompiled .= '
			<img src="' . $__templater->func('base_url', array($__vars['urlImg'], ), true) . '" alt="Batch Image" class="bbImage fsTeamImageMob" loading="lazy" style="width: ' . $__templater->escape($__vars['xf']['options']['fs_team_mobile_dimensions']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_team_mobile_dimensions']['height']) . 'px;" />
		';
					}
					$__finalCompiled .= '
	';
				}
			}
			$__finalCompiled .= '
';
		}
		$__finalCompiled .= '

<style>
	@media (min-width: 650px) {
		.fsTeamImageMob {
			display: none;
		}
	}
</style>

';
		$__vars['extras'] = $__templater->func('property', array('messageUserElements', ), false);
		$__finalCompiled .= '
			';
		$__compilerTemp1 = '';
		$__compilerTemp1 .= '
					';
		if ($__vars['extras']['register_date']) {
			$__compilerTemp1 .= '
						<dl class="pairs pairs--justified">
							<dt>' . 'Joined' . '</dt>
							<dd>' . $__templater->func('date', array($__vars['user']['register_date'], ), true) . '</dd>
						</dl>
					';
		}
		$__compilerTemp1 .= '
					';
		if ($__vars['extras']['message_count']) {
			$__compilerTemp1 .= '
						<dl class="pairs pairs--justified">
							<dt>' . 'Messages' . '</dt>
							<dd>' . $__templater->filter($__vars['user']['message_count'], array(array('number', array()),), true) . '</dd>
						</dl>
					';
		}
		$__compilerTemp1 .= '
					';
		if ($__vars['extras']['solutions'] AND $__vars['user']['question_solution_count']) {
			$__compilerTemp1 .= '
						<dl class="pairs pairs--justified">
							<dt>' . 'Solutions' . '</dt>
							<dd>' . $__templater->filter($__vars['user']['question_solution_count'], array(array('number', array()),), true) . '</dd>
						</dl>
					';
		}
		$__compilerTemp1 .= '
					';
		if ($__vars['extras']['reaction_score']) {
			$__compilerTemp1 .= '
						<dl class="pairs pairs--justified">
							<dt>' . 'Reaction score' . '</dt>
							<dd>' . $__templater->filter($__vars['user']['reaction_score'], array(array('number', array()),), true) . '</dd>
						</dl>
					';
		}
		$__compilerTemp1 .= '
					';
		if ($__vars['extras']['trophy_points'] AND $__vars['xf']['options']['enableTrophies']) {
			$__compilerTemp1 .= '
						<dl class="pairs pairs--justified">
							<dt>' . 'Points' . '</dt>
							<dd>' . $__templater->filter($__vars['user']['trophy_points'], array(array('number', array()),), true) . '</dd>
						</dl>
					';
		}
		$__compilerTemp1 .= '
					';
		if ($__vars['extras']['age'] AND $__vars['user']['Profile']['age']) {
			$__compilerTemp1 .= '
						<dl class="pairs pairs--justified">
							<dt>' . 'Age' . '</dt>
							<dd>' . $__templater->escape($__vars['user']['Profile']['age']) . '</dd>
						</dl>
					';
		}
		$__compilerTemp1 .= '
					';
		if ($__vars['extras']['location'] AND $__vars['user']['Profile']['location']) {
			$__compilerTemp1 .= '
						<dl class="pairs pairs--justified">
							<dt>' . 'Location' . '</dt>
							<dd>
								';
			if ($__vars['xf']['options']['geoLocationUrl']) {
				$__compilerTemp1 .= '
									<a href="' . $__templater->func('link', array('misc/location-info', '', array('location' => $__vars['user']['Profile']['location'], ), ), true) . '" rel="nofollow noreferrer" target="_blank" class="u-concealed">' . $__templater->escape($__vars['user']['Profile']['location']) . '</a>
								';
			} else {
				$__compilerTemp1 .= '
									' . $__templater->escape($__vars['user']['Profile']['location']) . '
								';
			}
			$__compilerTemp1 .= '
							</dd>
						</dl>
					';
		}
		$__compilerTemp1 .= '
					';
		if ($__vars['extras']['website'] AND $__vars['user']['Profile']['website']) {
			$__compilerTemp1 .= '
						<dl class="pairs pairs--justified">
							<dt>' . 'Website' . '</dt>
							<dd><a href="' . $__templater->escape($__vars['user']['Profile']['website']) . '" rel="nofollow" target="_blank">' . $__templater->filter($__vars['user']['Profile']['website'], array(array('url', array('host', 'Visit site', )),), true) . '</a></dd>
						</dl>
					';
		}
		$__compilerTemp1 .= '
					' . $__templater->includeTemplate('dbtech_credits_postbit', $__vars) . '
	' . $__templater->includeTemplate('fs_last_credits_date_postbit', $__vars) . '
	';
		if ($__vars['extras']['custom_fields']) {
			$__compilerTemp1 .= '
						' . $__templater->callMacro('custom_fields_macros', 'custom_fields_values', array(
				'type' => 'users',
				'group' => 'personal',
				'set' => $__vars['user']['Profile']['custom_fields'],
				'additionalFilters' => array('message', ),
				'valueClass' => 'pairs pairs--justified',
			), $__vars) . '
						';
			if ($__templater->method($__vars['user'], 'canViewIdentities', array())) {
				$__compilerTemp1 .= '
							' . $__templater->callMacro('custom_fields_macros', 'custom_fields_view', array(
					'type' => 'users',
					'group' => 'contact',
					'set' => $__vars['user']['Profile']['custom_fields'],
					'additionalFilters' => array('message', ),
					'valueClass' => 'pairs pairs--justified',
				), $__vars) . '
						';
			}
			$__compilerTemp1 .= '
					';
		}
		$__compilerTemp1 .= '
				';
		if (strlen(trim($__compilerTemp1)) > 0) {
			$__finalCompiled .= '
				<div class="message-userExtras">
				' . $__compilerTemp1 . '
				</div>
			';
		}
		$__finalCompiled .= '
		';
	}
	$__finalCompiled .= '
		<span class="message-userArrow"></span>
	</section>
';
	return $__finalCompiled;
}
),
'user_info_simple' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
		'fallbackName' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<header itemscope itemtype="https://schema.org/Person" class="message-user">
		<meta itemprop="name" content="' . ($__templater->escape($__vars['user']['username']) ?: $__templater->escape($__vars['fallbackName'])) . '">
		<div class="message-avatar">
			<div class="message-avatar-wrapper">
				' . $__templater->func('avatar', array($__vars['user'], 's', false, array(
		'defaultname' => $__vars['fallbackName'],
		'itemprop' => 'image',
	))) . '
			</div>
		</div>
		<span class="message-userArrow"></span>
	</header>
';
	return $__finalCompiled;
}
),
'attachments' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'attachments' => '!',
		'message' => '!',
		'canView' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
					';
	if ($__templater->isTraversable($__vars['attachments'])) {
		foreach ($__vars['attachments'] AS $__vars['attachment']) {
			if (!$__templater->method($__vars['message'], 'isAttachmentEmbedded', array($__vars['attachment'], ))) {
				$__compilerTemp1 .= '
						' . $__templater->callMacro('attachment_macros', 'attachment_list_item', array(
					'attachment' => $__vars['attachment'],
					'canView' => $__vars['canView'],
				), $__vars) . '
					';
			}
		}
	}
	$__compilerTemp1 .= '
				';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		';
		$__templater->includeCss('attachments.less');
		$__finalCompiled .= '
		<section class="message-attachments">
			<h4 class="block-textHeader">' . 'Attachments' . '</h4>
			<ul class="attachmentList">
				' . $__compilerTemp1 . '
			</ul>
		</section>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'signature' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	if ($__vars['xf']['visitor']['Option']['content_show_signature'] AND $__vars['user']['Profile']['signature']) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		$__compilerTemp1 .= '
				' . $__templater->func('bb_code', array($__vars['user']['Profile']['signature'], 'user:signature', $__vars['user'], ), true) . '
			';
		if (strlen(trim($__compilerTemp1)) > 0) {
			$__finalCompiled .= '
			<aside class="message-signature">
			' . $__compilerTemp1 . '
			</aside>
		';
		}
		$__finalCompiled .= '
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