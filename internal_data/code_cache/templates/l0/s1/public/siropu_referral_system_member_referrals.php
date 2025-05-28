<?php
// FROM HASH: ba87c3ce2dc2dc9790de60f9a73d08a1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Members referred by ' . $__templater->escape($__vars['user']['username']) . '');
	$__finalCompiled .= '

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
			'link' => 'members/referrals',
			'page' => $__vars['page'],
			'total' => $__vars['total'],
			'data' => $__vars['user'],
			'wrapperclass' => 'block-outer block-outer--after',
			'perPage' => $__vars['perPage'],
		))) . '
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . '' . $__templater->escape($__vars['user']['username']) . ' doesn\'t have any referrals yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);