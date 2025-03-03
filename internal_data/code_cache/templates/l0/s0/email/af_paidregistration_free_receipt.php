<?php
// FROM HASH: ca668481b256eca479c4226c94002941
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'af_paidregistrations_yourFreeRegistrationLink' . '</mail:subject>

<p>' . 'Thank you for purchasing an account upgrade at <a href="' . $__templater->func('link', array('canonical:index', ), true) . '">' . $__templater->escape($__vars['xf']['options']['boardTitle']) . '</a>.' . '</p>

' . '<p>If you weren\'t already redirected to a registration form, please use <a href="' . $__templater->func('link', array('canonical:register', null, array('prk' => $__vars['purchaseRequest']['request_key'], '_xfRedirect' => $__vars['redirectUrl'], ), ), true) . '">this link</a> to register with the user upgrade you purchased.</p>

<p>Note: After you register, please allow up to an hour for the upgrade to be applied to your account.</p>

<p>If you have any questions, please <a href="' . $__templater->func('link', array('canonical:misc/contact', ), true) . '">contact us</a>.</p>';
	return $__finalCompiled;
}
);