<?php
// FROM HASH: 8cf1666d12993274ae0ab2df72bb15a9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('fs_hide_links_medias_to_guests_bb_code_hide.less');
	$__finalCompiled .= '
	
<div class="messageHide messageHide--' . $__templater->escape($__vars['tag']) . '">
	' . $__templater->filter($__vars['errorPhrase'], array(array('raw', array()),), true) . '
</div>';
	return $__finalCompiled;
}
);