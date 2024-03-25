<?php
// FROM HASH: 6ddb0f4f49cb050508c0081c9533c2c1
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block-container">
	<div class="block-body">
		<div class="structItemContainer">
			<div class="structItemContainer-group js-threadList thread-grid">
				';
	if (!$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '
					';
		if ($__templater->isTraversable($__vars['threads'])) {
			foreach ($__vars['threads'] AS $__vars['thread']) {
				$__finalCompiled .= '
						' . $__templater->callMacro(null, ($__vars['templateOverrides']['thread_list_macro'] ?: 'welcome_banner_thread_list_macros::item'), $__templater->combineMacroArgumentAttributes(null, array(
					'thread' => $__vars['thread'],
					'forum' => $__vars['thread']['Forum'],
				)), $__vars) . '
					';
			}
		}
		$__finalCompiled .= '
				';
	}
	$__finalCompiled .= '
			</div>
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);