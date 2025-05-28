<?php
// FROM HASH: 9b073467ac034b771c03cc42bf851540
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Your referrals');
	$__finalCompiled .= '

';
	$__templater->wrapTemplate('account_wrapper', $__vars);
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body block-row">
			<b>' . 'Your referral link' . '</b>: ' . $__templater->func('siropu_rs_referral_link', array('user', ), true) . '
			' . $__templater->callMacro('siropu_referral_system_macros', 'copy_to_clipboard', array(
		'type' => 'user',
	), $__vars) . '
		</div>
		' . $__templater->callMacro('siropu_referral_system_macros', 'referral_tools_block_footer', array(), $__vars) . '
	</div>
</div>

';
	if (!$__templater->test($__vars['referrals'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<ol class="block-body">
				';
		if ($__templater->isTraversable($__vars['referrals'])) {
			foreach ($__vars['referrals'] AS $__vars['referral']) {
				$__finalCompiled .= '
					<li class="block-row block-row--separated">
						' . $__templater->callMacro('member_list_macros', 'item', array(
					'user' => $__vars['referral'],
					'extraData' => $__templater->func('date_time', array($__vars['referral']['register_date'], ), false),
				), $__vars) . '
					</li>
				';
			}
		}
		$__finalCompiled .= '
			</ol>
		</div>

		' . $__templater->func('page_nav', array(array(
			'link' => 'account/referrals',
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'You do not have any referrals yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);