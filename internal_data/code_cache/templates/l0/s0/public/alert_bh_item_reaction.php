<?php
// FROM HASH: 69a6babbfbd0094ac6d44c7ee3cb804a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '' . $__templater->func('username_link', array($__vars['user'], false, array('defaultname' => $__vars['alert']['username'], ), ), true) . ' reacted to <a ' . (('href="' . $__templater->func('link', array('bh-item', $__vars['content'], ), true)) . '" class="fauxBlockLink-blockLink"') . '>' . ($__templater->func('prefix', array('thread', $__vars['content']['item_title'], ), true) . $__templater->escape($__vars['content']['item_title'])) . '</a> with ' . $__templater->filter($__templater->func('alert_reaction', array($__vars['extra']['reaction_id'], ), false), array(array('preescaped', array()),), true) . '';
	return $__finalCompiled;
}
);