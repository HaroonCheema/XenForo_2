<?php
// FROM HASH: 6c111a1d5433c4cb7b8cc2e0498ba569
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-container">
	<div class="block-body">
		<h2>
			hello
		</h2>
		';
	$__compilerTemp1 = 1;
	if ($__templater->isTraversable($__compilerTemp1)) {
		foreach ($__compilerTemp1 AS $__vars['val']) {
			$__finalCompiled .= '
			<!-- Output the current number -->
			<div>' . $__templater->escape($__vars['val']) . '</div>
		';
		}
	}
	$__finalCompiled .= '
	</div>
</div>';
	return $__finalCompiled;
}
);