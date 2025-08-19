<?php
// FROM HASH: fa8e71f8549a642b320f5929ff1ff8d2
return array(
'macros' => array('options_menu' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'package' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->button('
		<i class="fa fa-cog" aria-hidden="true"></i>
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
			<a href="' . $__templater->func('link', array('ads-manager/packages/clone', $__vars['package'], ), true) . '" class="menu-linkRow" data-xf-click="overlay" data-cache="false">' . 'Clone' . '</a>
			';
	if ($__templater->method($__vars['package'], 'isEmbeddable', array())) {
		$__finalCompiled .= '
				<a href="' . $__templater->func('link', array('ads-manager/packages/embed', $__vars['package'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Embed' . '</a>
			';
	}
	$__finalCompiled .= '
			<a href="' . $__templater->func('link', array('ads-manager/packages/export', $__vars['package'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">' . 'Export' . '</a>
			';
	if ($__templater->method($__vars['package'], 'isEmbeddable', array()) AND (!$__templater->method($__vars['package'], 'isFree', array()))) {
		$__finalCompiled .= '
				<a href="' . $__templater->func('link', array('ads-manager/packages/manage-placeholder', $__vars['package'], ), true) . '" class="menu-linkRow" data-xf-click="overlay">	
					';
		if ($__templater->method($__vars['package'], 'hasPlaceholder', array())) {
			$__finalCompiled .= '
						' . 'Disable placeholder' . '
					';
		} else {
			$__finalCompiled .= '
						' . 'Enable placeholder' . '
					';
		}
		$__finalCompiled .= '
				</a>
			';
	}
	$__finalCompiled .= '
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'ads_options_menu' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'package' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	' . $__templater->button('
		<i class="fa fa-eye-slash" aria-hidden="true"></i>
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
			<a href="' . $__templater->func('link', array('ads-manager/packages/disable-ads', $__vars['package'], ), true) . '" class="menu-linkRow" data-xf-click="overlay" data-cache="false">' . 'Disable all ads' . '</a>
			<a href="' . $__templater->func('link', array('ads-manager/packages/enable-ads', $__vars['package'], ), true) . '" class="menu-linkRow" data-xf-click="overlay" data-cache="false">' . 'Enable all ads' . '</a>
		</div>
	</div>
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