<?php
// FROM HASH: 3b28e6e4d3a9e664232fbf08ebe8a474
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__vars['pruneTagsRebuildBody'] = $__templater->preEscaped('
	' . $__templater->formNumberBoxRow(array(
		'name' => 'options[min_usage]',
		'value' => '1',
		'step' => '1',
		'min' => '0',
		'size' => '20',
		'inputclass' => 'number',
	), array(
		'label' => 'Remove tags with this usage count and fewer',
	)) . '
	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[delete_permanent]',
		'value' => '1',
		'label' => 'Delete permanent tags',
		'_type' => 'option',
	)), array(
	)) . '
	' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[delete_synonyms]',
		'value' => '1',
		'label' => 'Delete tags with synonyms',
		'_type' => 'option',
	)), array(
	)) . '
');
	$__finalCompiled .= '

' . $__templater->callMacro('tools_rebuild', 'rebuild_job', array(
		'header' => 'Prune low usage tags',
		'body' => $__vars['pruneTagsRebuildBody'],
		'job' => 'AVForums\\TagEssentials:TagPrune',
	), $__vars) . '
';
	return $__finalCompiled;
}
);