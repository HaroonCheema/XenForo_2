<?php
// FROM HASH: e510843b6e5e025a119d223ca0a0d82a
return array(
'macros' => array('sidenav' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'pageSelected' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block-body">
		<a href="' . $__templater->func('link', array('ads-manager', ), true) . '" class="blockLink ' . (($__vars['pageSelected'] == '') ? 'is-selected' : '') . '">' . 'Overview' . '</a>
		';
	if ($__vars['xf']['visitor']['user_id']) {
		$__finalCompiled .= '
			<a href="' . $__templater->func('link', array('ads-manager/ads', ), true) . '" class="blockLink ' . (($__vars['pageSelected'] == 'ads') ? 'is-selected' : '') . '">' . 'Your ads' . '</a>
			<a href="' . $__templater->func('link', array('ads-manager/invoices', ), true) . '" class="blockLink ' . (($__vars['pageSelected'] == 'invoices') ? 'is-selected' : '') . '">' . 'Your invoices' . '</a>
		';
	}
	$__finalCompiled .= '
		<a href="' . $__templater->func('link', array('ads-manager/packages', ), true) . '" class="blockLink ' . (($__vars['pageSelected'] == 'packages') ? 'is-selected' : '') . '">' . 'Create ad' . '</a>
		';
	if ($__vars['xf']['options']['siropuAdsManagerAdvertisersPage']['enabled']) {
		$__finalCompiled .= '
			<a href="' . $__templater->func('link', array('ads-manager/advertisers', ), true) . '" class="blockLink ' . (($__vars['pageSelected'] == 'advertisers') ? 'is-selected' : '') . '">' . 'Advertisers' . '</a>
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
	$__templater->inlineCss('
	.dataList-mainRow
	{
		white-space: initial;
		max-height: initial;
	}
');
	$__finalCompiled .= '

';
	if ($__vars['xf']['options']['siropuAdsManagerAccountSection']) {
		$__finalCompiled .= '
	';
		$__templater->wrapTemplate('account_wrapper', $__vars);
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
	';
		$__templater->modifySideNavHtml(null, '
		<div class="block">
			<div class="block-container">
				<h2 class="block-header">' . 'Ads Manager' . '</h2>
				' . $__templater->callMacro(null, 'sidenav', array(
			'pageSelected' => $__vars['pageSelected'],
		), $__vars) . '
			</div>
		</div>	
	', 'replace');
		$__finalCompiled .= '
	';
		$__templater->setPageParam('sideNavTitle', 'Ads Manager');
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

' . $__templater->filter($__vars['innerContent'], array(array('raw', array()),), true) . '

';
	return $__finalCompiled;
}
);