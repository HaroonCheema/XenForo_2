<?php
// FROM HASH: 7123feccbbf66d9a3922521c48a6ac25
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['html'] = $__templater->preEscaped('
	<a class="twitter-timeline" href="https://twitter.com/search?q=' . $__templater->escape($__vars['options']['search']) . '"
			data-widget-id="' . $__templater->escape($__vars['options']['widget_id']) . '"
			data-related="' . $__templater->escape($__vars['options']['related']) . '"
			data-height="' . $__templater->escape($__vars['options']['height']) . '"
			data-chrome="' . $__templater->escape($__vars['options']['chrome']) . '"
			data-theme="' . $__templater->func('property', array('styleType', ), true) . '"
			data-dnt="true">
		' . $__templater->escape($__vars['options']['search']) . '
	</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
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