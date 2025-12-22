<?php
// FROM HASH: 6bdcdcad7453dd8a8b479fd0157819ed
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('widget_EWRporta_countdown.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => '8wayrun/porta/countdown.js',
	));
	$__finalCompiled .= '

<div class="block porta-countdown"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '
		data-xf-init="porta-countdown" data-datetime="' . $__templater->escape($__vars['options']['datetime']) . '">
	<div class="block-container">
		<h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
		<div class="block-body">
			<div class="unit days full">
				<div class="poll">000</div>
				<div class="text">' . 'Days' . '</div>
			</div>
			<div class="unit hour">
				<div class="poll">00</div>
				<div class="text">' . 'Hours' . '</div>
			</div>
			<div class="unit mins">
				<div class="poll">00</div>
				<div class="text">' . 'minutes' . '</div>
			</div>
			<div class="unit secs">
				<div class="poll">00</div>
				<div class="text">' . 'Seconds' . '</div>
			</div>
			
			';
	if ($__vars['options']['active']) {
		$__finalCompiled .= '
				<div class="unit active full">
					' . $__templater->filter($__vars['options']['active'], array(array('RAW', array()),), true) . '
				</div>
			';
	}
	$__finalCompiled .= '
			';
	if ($__vars['options']['inactive']) {
		$__finalCompiled .= '
				<div class="unit inactive full">
					' . $__templater->filter($__vars['options']['inactive'], array(array('RAW', array()),), true) . '
				</div>
			';
	}
	$__finalCompiled .= '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);