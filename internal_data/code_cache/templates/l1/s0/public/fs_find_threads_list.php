<?php
// FROM HASH: a9a5beb1d8cd6e9bfc100003086db293
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '

	';
		if ($__vars['canInlineMod']) {
			$__finalCompiled .= '
		';
			$__templater->includeJs(array(
				'src' => 'xf/inline_mod.js',
				'min' => '1',
			));
			$__finalCompiled .= '
	';
		}
		$__finalCompiled .= '

	<div class="block" data-xf-init="' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '" data-type="thread" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">
		<div class="block-outer">
			' . '
	
			';
		if ($__vars['canInlineMod']) {
			$__finalCompiled .= '
				<div class="block-outer-opposite">
					<div class="buttonGroup">
						' . $__templater->callMacro('inline_mod_macros', 'button', array(), $__vars) . '
					</div>
				</div>
			';
		}
		$__finalCompiled .= '
		</div>

		<div class="block-container">
			<div class="block-body">
				<div class="structItemContainer">
					';
		if ($__templater->isTraversable($__vars['threads'])) {
			foreach ($__vars['threads'] AS $__vars['thread']) {
				$__finalCompiled .= '
						';
				$__vars['extra'] = '';
				$__finalCompiled .= '
						' . $__templater->callMacro('thread_list_macros', 'item', array(
					'thread' => $__vars['thread'],
					'allowEdit' => false,
				), $__vars) . '
					';
			}
		}
		$__finalCompiled .= '
				</div>
			</div>
		</div>
		' . '
	</div>
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'There are no threads to display.' . '</div>
';
	}
	return $__finalCompiled;
}
);