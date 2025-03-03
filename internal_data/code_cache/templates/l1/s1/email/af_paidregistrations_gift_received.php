<?php
// FROM HASH: aac3c06552d5e2a630e64c8ecbb10819
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<mail:subject>' . 'You\'ve been gifted an account upgrade!' . '</mail:subject>

' . '<p>' . $__templater->escape($__vars['xf']['toUser']['username']) . ',</p>

<p>You\'ve been gifted an account upgrade (' . $__templater->escape($__vars['upgrade']['title']) . ') by ' . ($__vars['anonymous'] ? 'Anonymous' : (((('<a href="' . $__templater->escape($__vars['fromLink'])) . '">') . $__templater->escape($__vars['fromUsername'])) . '</a>')) . ', it\'s been successfully applied to your account.</p>

Click <a href="' . $__templater->func('link', array('canonical:account/upgrades', ), true) . '">here</a> to return the favor.' . '

<p><a href="' . $__templater->func('link', array('canonical:account/upgrades', ), true) . '" class="button">' . 'Manage your account upgrades' . '</a></p>

';
	if ($__templater->method($__vars['xf']['toUser'], 'canUseContactForm', array())) {
		$__finalCompiled .= '
    <p>' . 'If you have any questions, please <a href="' . $__templater->func('link', array('canonical:misc/contact', ), true) . '">contact us</a>.' . '</p>
';
	}
	return $__finalCompiled;
}
);