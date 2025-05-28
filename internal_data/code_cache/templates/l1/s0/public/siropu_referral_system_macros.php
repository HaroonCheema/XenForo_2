<?php
// FROM HASH: 03750ae4515bc3380d2ead5aa23fab87
return array(
'macros' => array('referral_tools_block_footer' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'faq' => true,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block-footer block-footer-split">
		<span class="block-footer-counter">
			<a href="' . $__templater->func('link', array('account/referral-tools', ), true) . '" data-xf-click="overlay">' . $__templater->fontAwesome('fa-cog', array(
	)) . ' ' . 'Tools' . '</a>
		</span>
		';
	if ($__vars['faq']) {
		$__finalCompiled .= '
			<span class="block-footer-controls">
				<a href="' . $__templater->func('link', array('account/referral-faq', ), true) . '" data-xf-click="overlay">' . $__templater->fontAwesome('fa-question-circle', array(
		)) . ' ' . 'What is this?' . '</a>
			</span>
		';
	}
	$__finalCompiled .= '
	</div>
';
	return $__finalCompiled;
}
),
'copy_to_clipboard' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'type' => '!',
		'tool' => null,
		'pageLink' => false,
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<button class="siropuCopyReferralLink button button--link" data-xf-init="copy-to-clipboard" data-copy-text="' . $__templater->func('siropu_rs_referral_link', array($__vars['type'], $__vars['tool'], $__vars['pageLink'], ), true) . '" style="font-size: 10px; padding: 2px 5px;">' . 'Copy link' . '</button>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

';
	return $__finalCompiled;
}
);