<?php
// FROM HASH: e138782e187a616c1cfc167398038217
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->formRow('
	<div class="inputGroup">
		' . $__templater->formNumberBox(array(
		'name' => 'download_size_limit',
		'value' => ($__vars['userGroup']['download_size_limit'] ?: 0),
		'min' => '0',
	)) . '
		<span class="inputGroup-splitter"></span>
		<span class="inputGroup-text">' . 'GB' . '</span>
	</div>
	<div class="formRow-explain">' . 'Enter download size limit for users of this userGroup in gigaBytes (GB).  If 0 then Unlimited
(post-attachments File greater than this size will not be allowed to download.)' . '</div>
', array(
		'rowtype' => 'input',
		'label' => 'Download size limit',
	)) . '

' . $__templater->formRow('
	<div class="inputGroup">
		' . $__templater->formNumberBox(array(
		'name' => 'daily_download_size_limit',
		'value' => ($__vars['userGroup']['daily_download_size_limit'] ?: 0),
		'min' => '0',
	)) . '
		<span class="inputGroup-splitter"></span>
		<span class="inputGroup-text">' . 'GB' . '</span>
	</div>
	<div class="formRow-explain">' . 'Enter daily download size limit for users of this userGroup in gigaBytes (GB).  If 0 then Unlimited' . '</div>
', array(
		'rowtype' => 'input',
		'label' => 'Daily download size limit',
	)) . '

' . $__templater->formRow('
	<div class="inputGroup">
		' . $__templater->formNumberBox(array(
		'name' => 'weekly_download_size_limit',
		'value' => ($__vars['userGroup']['weekly_download_size_limit'] ?: 0),
		'min' => '0',
	)) . '
		<span class="inputGroup-splitter"></span>
		<span class="inputGroup-text">' . 'GB' . '</span>
	</div>
	<div class="formRow-explain">' . 'Enter weekly download size limit for users of this userGroup in gigaBytes (GB).  If 0 then Unlimited' . '</div>
', array(
		'rowtype' => 'input',
		'label' => 'Weekly download size limit',
	));
	return $__finalCompiled;
}
);