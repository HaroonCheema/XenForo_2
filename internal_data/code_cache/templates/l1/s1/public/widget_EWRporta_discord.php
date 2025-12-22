<?php
// FROM HASH: b03a2b9751e734c55c50e0ff2a8bcc60
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['html'] = $__templater->preEscaped('
	<iframe src="https://discord.com/widget?id=' . $__templater->escape($__vars['options']['server']) . '&theme=' . $__templater->func('property', array('styleType', ), true) . '"
		width="100%" height="' . $__templater->escape($__vars['options']['height']) . '" allowtransparency="true" frameborder="0"></iframe>
');
	$__finalCompiled .= '

';
	if (!$__vars['options']['advanced_mode']) {
		$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
			<div class="block-body block-row">
				' . $__templater->escape($__vars['html']) . '
			</div>
		</div>
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="block">
		' . $__templater->escape($__vars['html']) . '
	</div>
';
	}
	return $__finalCompiled;
}
);