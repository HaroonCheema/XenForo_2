<?php
// FROM HASH: a4b2e6ed0cf055189dfd98d2501e101b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped($__templater->escape($__vars['tag']['tag']));
	$__finalCompiled .= '

' . $__templater->callMacro('avForumsTagEss_macros', 'tag_view_header', array(
		'tag' => $__vars['tag'],
		'activePage' => 'topUsers',
	), $__vars) . '

';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['topUsers'])) {
		foreach ($__vars['topUsers'] AS $__vars['userId'] => $__vars['user']) {
			$__compilerTemp1 .= '
				<li class="block-row block-row--separated">
					' . $__templater->callMacro('member_list_macros', 'item', array(
				'user' => $__vars['user'],
				'extraData' => $__vars['extraDataRef'][$__vars['userId']],
				'extraDataBig' => true,
			), $__vars) . '
				</li>
			';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__compilerTemp1 . '
		</div>
	</div>
	' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array('tags/wiki', $__vars['tag'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);