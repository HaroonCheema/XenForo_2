<?php
// FROM HASH: 1e2e7bb3926bc1dc1b631900227983ba
return array(
'macros' => array('moderator_menu_actions' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
		'context' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . '
	';
	if ($__templater->method($__vars['xf']['visitor'], 'canCleanSpam', array()) AND $__templater->method($__vars['user'], 'isPossibleSpammer', array())) {
		$__finalCompiled .= '
		<a href="' . $__templater->func('link', array('spam-cleaner', $__vars['user'], array('no_redirect' => 1, ), ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Spam' . '</a>
	';
	}
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['user'], 'canWarn', array())) {
		$__finalCompiled .= '
		<a href="' . $__templater->func('link', array('members/warn', $__vars['user'], ), true) . '" class="menu-linkRow">' . 'Warn' . '</a>
	';
	}
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewWarnings', array()) AND ($__vars['user']['warning_count'] AND ($__vars['context'] == 'tooltip'))) {
		$__finalCompiled .= '
		<a href="' . ($__templater->method($__vars['user'], 'canViewFullProfile', array()) ? ($__templater->func('link', array('members', $__vars['user'], ), true) . '#warnings') : $__templater->func('link', array('members/warnings', $__vars['user'], ), true)) . '" class="menu-linkRow">' . 'View warnings (' . $__templater->filter($__vars['user']['warning_count'], array(array('number', array()),), true) . ')' . '</a>
	';
	}
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewIps', array())) {
		$__finalCompiled .= '
		<a href="' . $__templater->func('link', array('members/user-ips', $__vars['user'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'IP addresses' . '</a>
		<a href="' . $__templater->func('link', array('members/shared-ips', $__vars['user'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Shared IPs' . '</a>
	';
	}
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['user'], 'canBan', array())) {
		$__finalCompiled .= '
		<a href="' . $__templater->func('link', array('members/ban', $__vars['user'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">
			';
		if ($__vars['user']['is_banned']) {
			$__finalCompiled .= '
				' . 'Edit ban' . '
			';
		} else {
			$__finalCompiled .= '
				' . 'Ban member' . '
			';
		}
		$__finalCompiled .= '
		</a>
	';
	}
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['user'], 'canEdit', array())) {
		$__finalCompiled .= '
		<a href="' . $__templater->func('link', array('members/edit', $__vars['user'], ), true) . '" class="menu-linkRow">' . 'Edit' . '</a>
	';
	}
	$__finalCompiled .= '
	' . $__templater->includeTemplate('ozzmodz_badges_moderator_actions', $__vars) . '

' . '
';
	return $__finalCompiled;
}
),
'member_stat_pairs' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
		'context' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . '
	' . '
	<dl class="pairs pairs--rows pairs--rows--centered fauxBlockLink">
		<dt>' . 'Messages' . '</dt>
		<dd>
			<a href="' . $__templater->func('link', array('search/member', null, array('user_id' => $__vars['user']['user_id'], ), ), true) . '" class="fauxBlockLink-linkRow u-concealed">
				' . $__templater->filter($__vars['user']['message_count'], array(array('number', array()),), true) . '
			</a>
		</dd>
	</dl>
	';
	if ($__vars['user']['question_solution_count']) {
		$__finalCompiled .= '
		' . '
		<dl class="pairs pairs--rows pairs--rows--centered fauxBlockLink">
			<dt>' . 'Solutions' . '</dt>
			<dd>
				' . $__templater->filter($__vars['user']['question_solution_count'], array(array('number', array()),), true) . '
			</dd>
		</dl>
	';
	}
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewMedia', array())) {
		$__finalCompiled .= '
	';
		if ($__vars['user']['xfmg_media_count']) {
			$__finalCompiled .= '
		<dl class="pairs pairs--rows pairs--rows--centered menu-fauxLinkRow">
			<dt>' . 'Media' . '</dt>
			<dd>
				<a href="' . $__templater->func('link', array('media/users', $__vars['user'], ), true) . '" class="menu-fauxLinkRow-linkRow u-concealed">
					' . $__templater->filter($__vars['user']['xfmg_media_count'], array(array('number', array()),), true) . '
				</a>
			</dd>
		</dl>
	';
		}
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '
';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewResources', array()) AND $__vars['user']['xfrm_resource_count']) {
		$__finalCompiled .= '
	<dl class="pairs pairs--rows pairs--rows--centered menu-fauxLinkRow">
		<dt>' . 'Resources' . '</dt>
		<dd>
			<a href="' . $__templater->func('link', array('resources/authors', $__vars['user'], ), true) . '" class="menu-fauxLinkRow-linkRow u-concealed">
				' . $__templater->filter($__vars['user']['xfrm_resource_count'], array(array('number', array()),), true) . '
			</a>
		</dd>
	</dl>
';
	}
	$__finalCompiled .= '
' . '
	';
	if ($__templater->method($__vars['xf']['visitor'], 'hasOption', array('hasDbEcommerce', )) AND ($__templater->method($__vars['xf']['visitor'], 'canViewDbtechEcommerceProducts', array()) AND $__vars['user']['dbtech_ecommerce_product_count'])) {
		$__finalCompiled .= '
	<dl class="pairs pairs--rows pairs--rows--centered menu-fauxLinkRow">
		<dt>' . 'Products' . '</dt>
		<dd>
			<a href="' . $__templater->func('link', array('dbtech-ecommerce/authors', $__vars['user'], ), true) . '" class="menu-fauxLinkRow-linkRow u-concealed">
				' . $__templater->filter($__vars['user']['dbtech_ecommerce_product_count'], array(array('number', array()),), true) . '
			</a>
		</dd>
	</dl>
';
	}
	$__finalCompiled .= '
	<dl class="pairs pairs--rows pairs--rows--centered">
		<dt>' . 'Special Credits' . '</dt>
		<dd>
			' . $__templater->filter($__vars['user']['special_credit'], array(array('number', array()),), true) . '
		</dd>
	</dl>
' . '
	<dl class="pairs pairs--rows pairs--rows--centered">
		<dt title="' . $__templater->filter('Reaction score', array(array('for_attr', array()),), true) . '">' . 'Reaction score' . '</dt>
		<dd>
			' . $__templater->filter($__vars['user']['reaction_score'], array(array('number', array()),), true) . '
		</dd>
	</dl>
	' . '
	';
	if ($__vars['user']['ozzmodz_badges_badge_count']) {
		$__finalCompiled .= '
		<dl class="pairs pairs--rows pairs--rows--centered fauxBlockLink">
			<dt>' . 'Badges' . '</dt>
			<dd>
				<a href="' . $__templater->func('link', array('members/badges', $__vars['user'], ), true) . '" data-xf-click="overlay" class="fauxBlockLink-linkRow u-concealed">
					' . $__templater->filter($__vars['user']['ozzmodz_badges_badge_count'], array(array('number', array()),), true) . '
				</a>
				
			</dd>
		</dl>
	';
	}
	$__finalCompiled .= '
	' . '
	';
	if ($__vars['xf']['options']['enableTrophies']) {
		$__finalCompiled .= '
		<dl class="pairs pairs--rows pairs--rows--centered fauxBlockLink">
			<dt title="' . $__templater->filter('Trophy points', array(array('for_attr', array()),), true) . '">' . 'Points' . '</dt>
			<dd>
				<a href="' . $__templater->func('link', array('members/trophies', $__vars['user'], ), true) . '" data-xf-click="overlay" class="fauxBlockLink-linkRow u-concealed">
					' . $__templater->filter($__vars['user']['trophy_points'], array(array('number', array()),), true) . '
				</a>
			</dd>
		</dl>
	';
	}
	$__finalCompiled .= '
	' . $__templater->callMacro('BRATR_rating_macros', 'receive_rating_count', array(
		'user' => $__vars['user'],
	), $__vars) . '
' . $__templater->includeTemplate('dbtech_credits_member_stats', $__vars) . '
	';
	if ($__vars['xf']['options']['siropuReferralSystemDisplayReferralCount'] AND $__vars['user']['siropu_rs_referral_count']) {
		$__finalCompiled .= '
	<dl class="pairs pairs--rows pairs--rows--centered menu-fauxLinkRow">
		<dt>' . 'Referrals' . '</dt>
		<dd>
			<a href="' . $__templater->func('link', array('members/referrals', $__vars['user'], ), true) . '" class="fauxBlockLink-linkRow u-concealed" data-xf-click="overlay">' . $__templater->filter($__vars['user']['siropu_rs_referral_count'], array(array('number', array()),), true) . '</a>
		</dd>
	</dl>
';
	}
	$__finalCompiled .= '
';
	if ($__vars['xf']['options']['siropuReferralSystemDisplayReferrer'] AND $__vars['user']['siropu_rs_referrer_id']) {
		$__finalCompiled .= '
	<dl class="pairs pairs--rows pairs--rows--centered menu-fauxLinkRow">
		<dt>' . 'Referrer' . '</dt>
		<dd>
			' . $__templater->func('username_link', array($__vars['user']['SRS_Referrer'], true, array(
			'class' => 'fauxBlockLink-linkRow u-concealed',
			'notooltip' => 'true',
		))) . '
		</dd>
	</dl>
';
	}
	$__finalCompiled .= '
' . '

';
	if ($__templater->method($__vars['xf']['visitor'], 'hasPermission', array('fs_thread_scoring_system', 'can_view', ))) {
		$__finalCompiled .= '
	<dl class="pairs pairs--rows pairs--rows--centered menu-fauxLinkRow">
		<dt>' . 'Total Points' . '</dt>
		<dd>
			' . $__templater->func('number', array($__vars['user']['total_score'], $__vars['xf']['options']['fs_thread_scoring_system_decimals'], ), true) . '
		</dd>
	</dl>
';
	}
	$__finalCompiled .= '
	<dl class="pairs pairs--rows pairs--rows--centered menu-fauxLinkRow">
		<dt>' . 'Question Expert' . '</dt>
		<dd>
			' . $__templater->filter($__vars['user']['question_count'], array(array('number', array()),), true) . '
		</dd>
	</dl>
	<dl class="pairs pairs--rows pairs--rows--centered menu-fauxLinkRow">
		<dt>' . 'Answer Expert' . '</dt>
		<dd>
			' . $__templater->filter($__vars['user']['answer_count'], array(array('number', array()),), true) . '
		</dd>
	</dl>
';
	if (($__vars['user']['user_id'] == $__vars['xf']['visitor']['user_id']) OR $__vars['xf']['visitor']['is_admin']) {
		$__finalCompiled .= '
	<dl class="pairs pairs--rows pairs--rows--centered menu-fauxLinkRow">
		<dt>' . 'Amount' . '</dt>
		<dd>
			' . '$' . $__templater->escape($__vars['user']['deposit_amount']) . '
		</dd>
	</dl>
';
	}
	$__finalCompiled .= '
	';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewWarnings', array()) AND $__vars['user']['warning_points']) {
		$__finalCompiled .= '
		<dl class="pairs pairs--rows pairs--rows--centered fauxBlockLink">
			<dt>' . 'Warnings' . '</dt>
			<dd>
				<a href="' . ((($__vars['context'] == 'tooltip') AND $__templater->method($__vars['user'], 'canViewFullProfile', array())) ? ($__templater->func('link', array('members', $__vars['user'], ), true) . '#warnings') : $__templater->func('link', array('members/warnings', $__vars['user'], ), true)) . '" data-xf-click="' . (($__vars['context'] == 'tooltip') ? '' : 'overlay') . '" class="fauxBlockLink-linkRow u-concealed">
					' . $__templater->filter($__vars['user']['warning_points'], array(array('number', array()),), true) . ' / ' . $__templater->filter($__vars['user']['warning_count'], array(array('number', array()),), true) . '
				</a>
			</dd>
		</dl>
	';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'member_action_buttons' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'user' => '!',
		'context' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . '
	';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
			' . '
			';
	if ($__templater->method($__vars['xf']['visitor'], 'canFollowUser', array($__vars['user'], ))) {
		$__compilerTemp1 .= '
				' . $__templater->button('
					' . ($__templater->method($__vars['xf']['visitor'], 'isFollowing', array($__vars['user'], )) ? 'Unfollow' : 'Follow') . '
				', array(
			'href' => $__templater->func('link', array('members/follow', $__vars['user'], ), false),
			'class' => 'button--link',
			'data-xf-click' => 'switch',
			'data-sk-follow' => 'Follow',
			'data-sk-unfollow' => 'Unfollow',
		), '', array(
		)) . '
			';
	}
	$__compilerTemp1 .= '
			';
	if ($__templater->method($__vars['xf']['visitor'], 'canIgnoreUser', array($__vars['user'], ))) {
		$__compilerTemp1 .= '
				<a href="' . $__templater->func('link', array('members/ignore', $__vars['user'], ), true) . '"
					class="button button--link"
					data-xf-click="switch"
					data-sk-ignore="' . 'Ignore' . '"
					data-sk-unignore="' . 'Unignore' . '">
					' . ($__templater->method($__vars['xf']['visitor'], 'isIgnoring', array($__vars['user'], )) ? 'Unignore' : 'Ignore') . '
				</a>
			';
	}
	$__compilerTemp1 .= '
			' . '
		';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
		' . '
		<div class="buttonGroup">
		' . $__compilerTemp1 . '
		</div>
	';
	}
	$__finalCompiled .= '

	' . '

	';
	$__compilerTemp2 = '';
	$__compilerTemp2 .= '
			' . '
			';
	if ($__templater->method($__vars['xf']['visitor'], 'canStartConversationWith', array($__vars['user'], ))) {
		$__compilerTemp2 .= '
				' . $__templater->button('
					' . 'Start conversation' . '
				', array(
			'href' => $__templater->func('link', array('conversations/add', null, array('to' => $__vars['user']['username'], ), ), false),
			'class' => 'button--link',
		), '', array(
		)) . '
			';
	}
	$__compilerTemp2 .= '
			';
	if ($__templater->method($__vars['xf']['visitor'], 'canSearch', array()) AND ($__vars['context'] != 'tooltip')) {
		$__compilerTemp2 .= '
				<div class="buttonGroup-buttonWrapper">
					' . $__templater->button('Find', array(
			'class' => 'button--link menuTrigger',
			'data-xf-click' => 'menu',
			'aria-expanded' => 'false',
			'aria-haspopup' => 'true',
		), '', array(
		)) . '
					<div class="menu" data-menu="menu" aria-hidden="true">
						<div class="menu-content">
							<h4 class="menu-header">' . 'Find content' . '</h4>
							' . '
							<a href="' . $__templater->func('link', array('search/member', null, array('user_id' => $__vars['user']['user_id'], ), ), true) . '" rel="nofollow" class="menu-linkRow">' . 'Find all content by ' . $__templater->escape($__vars['user']['username']) . '' . '</a>
							<a href="' . $__templater->func('link', array('search/member', null, array('user_id' => $__vars['user']['user_id'], 'content' => 'thread', ), ), true) . '" rel="nofollow" class="menu-linkRow">' . 'Find all threads by ' . $__templater->escape($__vars['user']['username']) . '' . '</a>
						';
		$__vars['questionForumIds'] = $__vars['xf']['options']['fs_questionAnswerForum'];
		$__compilerTemp2 .= '
<a href="' . $__templater->func('link', array('search/member', null, array('user_id' => $__vars['user']['user_id'], 'content' => 'thread', 'thread_type' => 'question', 'qa_nodes' => array($__vars['questionForumIds'], ), ), ), true) . '" rel="nofollow" class="menu-linkRow">' . 'Find all questions by ' . $__templater->escape($__vars['user']['username']) . '' . '</a>
<a href="' . $__templater->func('link', array('search/member', null, array('user_id' => $__vars['user']['user_id'], 'content' => 'fs_answer', ), ), true) . '" rel="nofollow" class="menu-linkRow">' . 'Find all answers by ' . $__templater->escape($__vars['user']['username']) . '' . '</a>
<a href="' . $__templater->func('link', array('search/member', null, array('user_id' => $__vars['user']['user_id'], 'content' => 'thread', 'thread_type' => 'article', ), ), true) . '" rel="nofollow" class="menu-linkRow">' . 'Find all articles by ' . $__templater->escape($__vars['user']['username']) . '' . '</a>
	' . '
						</div>
					</div>
				</div>
			';
	}
	$__compilerTemp2 .= '
			';
	if ($__templater->method($__vars['xf']['visitor'], 'canViewDbtechEcommerceLicenses', array())) {
		$__compilerTemp2 .= '
				' . $__templater->button('
					' . 'View licenses' . '
				', array(
			'href' => $__templater->func('link', array('dbtech-ecommerce/licenses', $__vars['user'], ), false),
			'class' => 'button--link',
		), '', array(
		)) . '
			';
	}
	$__compilerTemp2 .= '
			' . '
';
	if ($__templater->func('property', array('af_pr_gift_profile', ), false) AND $__templater->method($__vars['xf']['visitor'], 'canGiftUserUpgrade', array($__vars['user'], ))) {
		$__compilerTemp2 .= '
	' . $__templater->button('<i class="fa fa-gift" aria-hidden="true"></i> ' . 'Gift Upgrade', array(
			'class' => 'button--link button--icon',
			'href' => $__templater->func('link', array('purchase/gift-upgrade', null, array('userId' => $__vars['user']['user_id'], ), ), false),
			'overlay' => 'true',
		), '', array(
		)) . '
';
	}
	$__compilerTemp2 .= '
		';
	if (strlen(trim($__compilerTemp2)) > 0) {
		$__finalCompiled .= '
		<div class="buttonGroup">
		' . $__compilerTemp2 . '
		</div>
		' . '
	';
	}
	$__finalCompiled .= '
	' . '
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