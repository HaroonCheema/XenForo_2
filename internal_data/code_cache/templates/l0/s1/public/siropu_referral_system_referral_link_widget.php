<?php
// FROM HASH: f716513a71a70c9a809db462d1ccd805
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block">
	<div class="block-container">
		<div class="block-body">
			<h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
			<div class="block-row">
				<p>
					<b>' . 'Your referral link' . '</b>: ' . $__templater->func('siropu_rs_referral_link', array('user', ), true) . '
					' . $__templater->callMacro('siropu_referral_system_macros', 'copy_to_clipboard', array(
		'type' => 'user',
	), $__vars) . '
				</p>
				';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
							' . $__templater->func('siropu_rs_referral_link', array('page', null, $__vars['options']['currentPageLink'], ), true) . '
						';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
					<p>
						<b>' . 'Current page referral link' . '</b>:
						' . $__compilerTemp1 . '
						' . $__templater->callMacro('siropu_referral_system_macros', 'copy_to_clipboard', array(
			'type' => 'page',
			'pageLink' => true,
		), $__vars) . '
					</p>
				';
	}
	$__finalCompiled .= '
			</div>
		</div>
		' . $__templater->callMacro('siropu_referral_system_macros', 'referral_tools_block_footer', array(), $__vars) . '
	</div>
</div>';
	return $__finalCompiled;
}
);