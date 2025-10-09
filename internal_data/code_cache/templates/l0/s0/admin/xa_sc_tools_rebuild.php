<?php
// FROM HASH: bf04606b2f7fce0f6afaf7be1ed9c991
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Showcase: ' . 'Rebuild categories',
		'job' => 'XenAddons\\Showcase:Category',
	), $__vars) . '
' . '

' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Showcase: ' . 'Rebuild items',
		'job' => 'XenAddons\\Showcase:Item',
	), $__vars) . '
' . '

' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Showcase: ' . 'Rebuild item location data',
		'job' => 'XenAddons\\Showcase:ItemLocationData',
	), $__vars) . '
' . '

' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Showcase: ' . 'Rebuild item updates',
		'job' => 'XenAddons\\Showcase:ItemUpdate',
	), $__vars) . '
' . '

' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Showcase: ' . 'Rebuild reviews',
		'job' => 'XenAddons\\Showcase:Review',
	), $__vars) . '
' . '

' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Showcase: ' . 'Rebuild user counts',
		'job' => 'XenAddons\\Showcase:UserItemCount',
	), $__vars) . '
' . '

';
	$__vars['scItemMdBody'] = $__templater->preEscaped('
	' . $__templater->formCheckBoxRow(array(
		'name' => 'options[types]',
		'listclass' => 'listColumns',
	), array(array(
		'value' => 'attachments',
		'label' => 'Attachments',
		'selected' => true,
		'_type' => 'option',
	)), array(
	)) . '
');
	$__finalCompiled .= '
' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Showcase: ' . 'Rebuild item embed metadata',
		'body' => $__vars['scItemMdBody'],
		'job' => 'XenAddons\\Showcase:ScItemEmbedMetadata',
	), $__vars) . '
' . '

';
	$__vars['scItemUpdateMdBody'] = $__templater->preEscaped('
	' . $__templater->formCheckBoxRow(array(
		'name' => 'options[types]',
		'listclass' => 'listColumns',
	), array(array(
		'value' => 'attachments',
		'label' => 'Attachments',
		'selected' => true,
		'_type' => 'option',
	)), array(
	)) . '
');
	$__finalCompiled .= '
' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Showcase: ' . 'Rebuild item update embed metadata',
		'body' => $__vars['scItemUpdateMdBody'],
		'job' => 'XenAddons\\Showcase:ScItemUpdateEmbedMetadata',
	), $__vars) . '
' . '

';
	$__vars['scCommentMdBody'] = $__templater->preEscaped('
	' . $__templater->formCheckBoxRow(array(
		'name' => 'options[types]',
		'listclass' => 'listColumns',
	), array(array(
		'value' => 'attachments',
		'label' => 'Attachments',
		'selected' => true,
		'_type' => 'option',
	)), array(
	)) . '
');
	$__finalCompiled .= '
' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Showcase: ' . 'Rebuild comment embed metadata',
		'body' => $__vars['scCommentMdBody'],
		'job' => 'XenAddons\\Showcase:ScCommentEmbedMetadata',
	), $__vars) . '
' . '

';
	$__vars['scReviewMdBody'] = $__templater->preEscaped('
	' . $__templater->formCheckBoxRow(array(
		'name' => 'options[types]',
		'listclass' => 'listColumns',
	), array(array(
		'value' => 'attachments',
		'label' => 'Attachments',
		'selected' => true,
		'_type' => 'option',
	)), array(
	)) . '
');
	$__finalCompiled .= '
' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Showcase: ' . 'Rebuild review embed metadata',
		'body' => $__vars['scReviewMdBody'],
		'job' => 'XenAddons\\Showcase:ScReviewEmbedMetadata',
	), $__vars) . '
';
	return $__finalCompiled;
}
);