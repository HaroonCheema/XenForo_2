<?php
// FROM HASH: e146a6e691591c53be06aba9ee0fc7d9
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Confirm action');
	$__finalCompiled .= '

' . $__templater->form('
    <div class="block-container">
        <div class="block-body">
            ' . $__templater->formInfoRow('
                ' . 'Please confirm that you want to delete the following' . $__vars['xf']['language']['label_separator'] . '
                <strong><a href="' . $__templater->func('link', array('forum-stats/edit', $__vars['forumStat'], ), true) . '">' . $__templater->escape($__vars['forumStat']['title']) . '</a></strong>
            ', array(
		'rowtype' => 'confirm',
	)) . '
        </div>
        ' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
	), array(
		'rowtype' => 'simple',
	)) . '
    </div>
', array(
		'action' => $__templater->func('link', array('forum-stats/delete', $__vars['forumStat'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);