<?php
// FROM HASH: 7e6fdbb36c584f5e3e66012298bd6a78
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block">
	<div class="block-container">
		<h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
		<ol class="block-body">
			';
	if ($__templater->isTraversable($__vars['featuredThreads'])) {
		foreach ($__vars['featuredThreads'] AS $__vars['thread']) {
			$__finalCompiled .= '
				<li class="block-row">
					' . $__templater->callMacro('thread_list_macros', 'item_new_threads', array(
				'thread' => $__vars['thread'],
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