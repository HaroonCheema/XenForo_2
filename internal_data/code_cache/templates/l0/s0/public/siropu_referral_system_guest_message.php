<?php
// FROM HASH: 43346f5883af1975eb3a946d18020d9d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="blockMessage blockMessage--success">
	' . $__templater->fontAwesome('fa-info-circle', array(
	)) . '
	' . 'Welcome! You have been invited by <b>' . $__templater->escape($__vars['user']['username']) . '</b> to join our community. Please click <a href="' . $__templater->func('link', array('register', ), true) . '" data-xf-click="overlay">here</a> to register.' . '
</div>';
	return $__finalCompiled;
}
);