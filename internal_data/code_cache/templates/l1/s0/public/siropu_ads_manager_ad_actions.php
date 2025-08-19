<?php
// FROM HASH: a4ed0400cc5f4e72293531d7a7b864eb
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->inlineCss('
.bbWrapper .samAdminActions
{
	margin: 0;
}
.bbWrapper .samAdminActions .button
{
	padding: 0 5px;
}
');
	$__finalCompiled .= '

<span class="samAdminActions">
	' . $__templater->button('
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
			<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/details', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'View details' . '</a>
			<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/edit', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Edit' . '</a>
			<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/delete', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Delete' . '</a>
			<hr class="menu-separator">
			<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/general-stats', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'General statistics' . '</a>
			<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/daily-stats', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Daily statistics' . '</a>
			<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/click-stats', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Click statistics' . '</a>
			<hr class="menu-separator">
			<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/clone', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Clone' . '</a>
			<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/embed', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Embed' . '</a>
			<a href="' . $__templater->func('link_type', array('admin', 'ads-manager/ads/export', $__vars['ad'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Export' . '</a>	
		</div>
	</div>
</span>';
	return $__finalCompiled;
}
);