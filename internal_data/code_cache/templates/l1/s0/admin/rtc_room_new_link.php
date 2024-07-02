<?php
// FROM HASH: 1d5cfc5a5c7e074c7f9d618b368e4156
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('New link for invite to the room ' . $__templater->escape($__vars['room']['tag']) . '');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formInfoRow('
				<a href="' . $__templater->escape($__vars['link']['url']) . '" target="_blank">
					<strong>' . $__templater->escape($__vars['link']['url']) . '</strong>
				</a>
			', array(
		'rowtype' => 'confirm',
	)) . '
		</div>
		' . $__templater->formSubmitRow(array(
		'icon' => 'confirm',
		'class' => 'js-overlayClose',
	), array(
		'rowtype' => 'simple',
	)) . '
	</div>
</div>';
	return $__finalCompiled;
}
);