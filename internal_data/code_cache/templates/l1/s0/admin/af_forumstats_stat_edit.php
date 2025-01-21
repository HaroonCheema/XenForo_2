<?php
// FROM HASH: 9234a9bf90c3fb35ce6d3e69e7a66b52
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->method($__vars['forumStat'], 'isInsert', array())) {
		$__finalCompiled .= '
    ';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Add Stat');
		$__finalCompiled .= '
';
	} else {
		$__finalCompiled .= '
    ';
		$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Edit Stat' . ': ' . $__templater->escape($__vars['forumStat']['title']));
		$__finalCompiled .= '
';
	}
	$__finalCompiled .= '

';
	if ($__templater->method($__vars['forumStat'], 'isUpdate', array())) {
		$__templater->pageParams['pageAction'] = $__templater->preEscaped('
    ' . $__templater->button('', array(
			'href' => $__templater->func('link', array('forum-stats/delete', $__vars['forumStat'], ), false),
			'icon' => 'delete',
			'overlay' => 'true',
		), '', array(
		)) . '
');
	}
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'value' => '',
		'label' => 'Choose Position',
		'_type' => 'option',
	));
	$__compilerTemp1 = $__templater->mergeChoiceOptions($__compilerTemp1, $__vars['forumStat']['positions']);
	$__vars['options'] = $__templater->method($__vars['forumStat']['handler'], 'getOptions', array());
	$__finalCompiled .= $__templater->form('
    <div class="block-container">
        <div class="block-body">

            ' . $__templater->formRow('
                ' . $__templater->escape($__vars['forumStatDefinition']['title']) . '
                ' . $__templater->formHiddenVal('definition_id', $__vars['forumStatDefinition']['definition_id'], array(
	)) . '
            ', array(
		'label' => 'Type',
		'explain' => '',
	)) . '

            ' . $__templater->formTextBoxRow(array(
		'name' => 'custom_title',
		'value' => $__vars['forumStat']['custom_title'],
		'maxlength' => $__templater->func('max_length', array($__vars['forumStat'], 'custom_title', ), false),
	), array(
		'label' => 'Custom Title',
		'explain' => 'If empty, the type name from above will be used' . ' (' . $__templater->escape($__vars['forumStatDefinition']['title']) . ')',
	)) . '

            <hr class="formRowSep" />

            ' . $__templater->formSelectRow(array(
		'name' => 'position',
		'value' => $__vars['forumStat']['position'],
	), $__compilerTemp1, array(
		'label' => 'Position',
	)) . '

            ' . $__templater->callMacro('display_order_macros', 'row', array(
		'value' => ($__vars['forumStat']['display_order'] ?: 5),
		'step' => '5',
	), $__vars) . '

            ' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'active',
		'selected' => $__vars['forumStat']['active'],
		'label' => 'Yes',
		'_type' => 'option',
	)), array(
		'label' => 'Active',
	)) . '

            ' . $__templater->filter($__templater->method($__vars['forumStat'], 'renderOptions', array()), array(array('raw', array()),), true) . '

            <hr class="formRowSep" />

            ' . '' . '
            ' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'options[show_counter]',
		'selected' => $__vars['options']['show_counter'],
		'label' => 'Yes',
		'_type' => 'option',
	)), array(
		'label' => 'Show counter',
	)) . '
        </div>
        ' . $__templater->formSubmitRow(array(
		'sticky' => 'true',
		'icon' => 'save',
	), array(
	)) . '
    </div>
', array(
		'action' => $__templater->func('link', array('forum-stats/save', $__vars['forumStat'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);