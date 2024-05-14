<?php
// FROM HASH: 7d7c0666fbaee9545a7f35e833ff6b3b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Owner-page post for ' . $__templater->escape($__vars['profilePost']['OwnerPage']['title']) . '');
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

' . $__templater->callMacro('lightbox_macros', 'setup', array(
		'canViewAttachments' => $__templater->method($__vars['profilePost'], 'canViewAttachments', array()),
	), $__vars) . '

<div class="block" data-xf-init="lightbox ' . ($__vars['canInlineMod'] ? 'inline-mod' : '') . '" data-type="bh_ownerPage_post" data-href="' . $__templater->func('link', array('inline-mod', ), true) . '">
	<div class="block-container">
		<div class="block-body">
			' . $__templater->callMacro('bh_owner_page_post_macros', 'profile_post', array(
		'attachmentData' => $__vars['profilePostAttachData'][$__vars['profilePost']['post_id']],
		'profilePost' => $__vars['profilePost'],
		'showTargetUser' => $__vars['showTargetUser'],
		'allowInlineMod' => $__vars['allowInlineMod'],
	), $__vars) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);