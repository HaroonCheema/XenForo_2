<?php
// FROM HASH: 08f441692320cb7e06b7a0e154d2fb06
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Ads Manager');
	$__finalCompiled .= '

<div class="blockMessage">
	' . 'Welcome to Ads Manager!' . '
</div>

<div class="iconicLinks">
	<ul class="iconicLinks-list">
		<li>
			<a href="' . $__templater->func('link', array('ads-manager/ads', ), true) . '">
				<div class="iconicLinks-icon"><i class="fa fa-fw fa-list" aria-hidden="true"></i></div>
				<div class="iconicLinks-title">' . 'Ads' . '</div>
			</a>
		</li>
		<li>
			<a href="' . $__templater->func('link', array('ads-manager/packages', ), true) . '">
				<div class="iconicLinks-icon"><i class="fa fa-fw fa-list" aria-hidden="true"></i></div>
				<div class="iconicLinks-title">' . 'Packages' . '</div>
			</a>
		</li>
		<li>
			<a href="' . $__templater->func('link', array('ads-manager/positions', ), true) . '">
				<div class="iconicLinks-icon"><i class="fa fa-fw fa-list" aria-hidden="true"></i></div>
				<div class="iconicLinks-title">' . 'Positions' . '</div>
			</a>
		</li>
		<li>
			<a href="' . $__templater->func('link', array('ads-manager/promo-codes', ), true) . '">
				<div class="iconicLinks-icon"><i class="fa fa-fw fa-list" aria-hidden="true"></i></div>
				<div class="iconicLinks-title">' . 'Promo codes' . '</div>
			</a>
		</li>
		<li>
			<a href="' . $__templater->func('link', array('ads-manager/invoices', ), true) . '">
				<div class="iconicLinks-icon"><i class="fa fa-fw fa-list" aria-hidden="true"></i></div>
				<div class="iconicLinks-title">' . 'Invoices' . '</div>
			</a>
		</li>
	</ul>
</div>';
	return $__finalCompiled;
}
);