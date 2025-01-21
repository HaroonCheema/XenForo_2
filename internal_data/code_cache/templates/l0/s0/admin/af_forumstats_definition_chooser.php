<?php
// FROM HASH: 5e17726a250bc818b5b28dde5967b314
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Choose Type');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => '',
		'label' => 'Choose Type',
		'_type' => 'option',
	));
	$__compilerTemp1 = $__templater->mergeChoiceOptions($__compilerTemp1, $__vars['forumStatDefinitions']);
	$__finalCompiled .= $__templater->form('
    <div class="block-container">
        <div class="block-body">
            ' . $__templater->formSelectRow(array(
		'name' => 'type',
	), $__compilerTemp1, array(
		'label' => 'Type',
	)) . '
        </div>
        ' . $__templater->formSubmitRow(array(
		'submit' => 'Add Stat',
		'icon' => 'add',
	), array(
	)) . '
    </div>
', array(
		'action' => $__templater->func('link', array('forum-stats/add', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);