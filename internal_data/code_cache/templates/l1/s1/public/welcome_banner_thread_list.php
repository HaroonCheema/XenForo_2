<?php
// FROM HASH: dde05ab8ee0638fecad121c1eb61a80e
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<style>
	.structItem:nth-child(even) {
		background-color: transparent !important;
	}

	.structItem:nth-child(even):hover {
		background-color: #272727 !important;
	}
</style>

<div class="block-container">
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