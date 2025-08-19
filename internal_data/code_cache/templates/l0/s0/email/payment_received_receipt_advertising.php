<?php
// FROM HASH: c68f0d02a07cae85239a85a4dffb3e4d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'Receipt for your advertising at ' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '' . '</mail:subject>

<p>' . 'Thank you for purchasing advertising at <a href="' . $__templater->func('link', array('canonical:index', ), true) . '">' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '</a>.' . '</p>

<p><a href="' . $__templater->func('link', array('canonical:ads-manager/ads', ), true) . '" class="button">' . 'Manage your ads' . '</a></p>

';
	if ($__templater->method($__vars['xf']['toUser'], 'canUseContactForm', array())) {
		$__finalCompiled .= '
	<p>' . 'Thank you for your purchase. If you have any questions, please <a href="' . $__templater->func('link', array('canonical:misc/contact', ), true) . '">contact us</a>.' . '</p>
';
	} else {
		$__finalCompiled .= '
	<p>' . 'Thank you for your purchase.' . '</p>
';
	}
	return $__finalCompiled;
}
);