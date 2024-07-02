<?php
// FROM HASH: 10bd1b16135b494e0809be8c5380661f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Conversation participants');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<ol class="block-body">
			';
	if ($__templater->isTraversable($__vars['conversation']['Recipients'])) {
		foreach ($__vars['conversation']['Recipients'] AS $__vars['recipient']) {
			$__finalCompiled .= '
				<li class="block-row">
					' . $__templater->callMacro(null, 'member_list_macros::item', array(
				'user' => $__vars['recipient']['User'],
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