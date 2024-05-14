<?php
// FROM HASH: 480382882f214f0a9c3a3324ae86325f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' reacted to owner page <a ' . (('href="' . $__templater->func('link', array('owners', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>' . ($__templater->func('prefix', array('thread', $__vars['content']['item_title'], ), true) . $__templater->escape($__vars['content']['Item']['item_title'])) . '</a> with ' . $__templater->filter($__templater->func('alert_reaction', array($__vars['extra']['reaction_id'], ), false), array(array('preescaped', array()),), true) . '';
	return $__finalCompiled;
}
);