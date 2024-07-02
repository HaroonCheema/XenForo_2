<?php
// FROM HASH: 9b479b5d9572e9ca60fab94e680a14c3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro(null, 'helper_attach_upload::uploaded_files_list', array(
		'attachments' => $__vars['attachmentData']['attachments'],
	), $__vars);
	return $__finalCompiled;
}
);