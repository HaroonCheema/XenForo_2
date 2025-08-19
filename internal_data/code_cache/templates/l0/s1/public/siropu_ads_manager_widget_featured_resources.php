<?php
// FROM HASH: 0daac22a3227b2c2e587b03f3648a7f3
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block">
	<div class="block-container">
		<h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
		<ol class="block-body">
			';
	if ($__templater->isTraversable($__vars['featuredResources'])) {
		foreach ($__vars['featuredResources'] AS $__vars['resource']) {
			$__finalCompiled .= '
				<li class="block-row">
					' . $__templater->callMacro('xfrm_resource_list_macros', 'resource_simple', array(
				'allowInlineMod' => false,
				'resource' => $__vars['resource'],
			), $__vars) . '
				</li>
			';
		}
	}
	$__finalCompiled .= '
		</ol>
	</div>
</div>';
	return $__finalCompiled;
}
);