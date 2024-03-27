<?php
// FROM HASH: 987496e4e76fb52a6dbe45d06d63aaf4
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

	.block-container {
		background: #1d1d1d;
	}
</style>

<div class="" style="padding-top: 8px; margin-bottom: 7px;">
	<div class="block-body">
		<div class="structItemContainer">
			<h3 class="node-title" style="padding-left: 12.5px; padding-bottom: 4px;">
				' . 'EDITORIAL' . '
			</h3>
			<div class="structItemContainer-group js-threadList thread-grid" style="padding: 8px;">
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