<?php
// FROM HASH: ea87a4b6c0241e056245b1d03f58c90a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('xc_hide_links_medias_to_guests_bb_code_hide.less');
	$__finalCompiled .= '
	
<div class="messageHide messageHide--' . $__templater->escape($__vars['tag']) . '">
	' . $__templater->filter($__vars['errorPhrase'], array(array('raw', array()),), true) . '
</div>';
	return $__finalCompiled;
}
);