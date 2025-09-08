<?php
// FROM HASH: ca4b989b49d58050d08dc4e0b2fe6cde
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
                <strong><a href="' . $__templater->func('link', array('forum-istatistik/edit', $__vars['forumIstatistik'], ), true) . '">' . $__templater->escape($__vars['forumIstatistik']['title']) . '</a></strong>
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
		'action' => $__templater->func('link', array('forum-istatistik/liste/sil', $__vars['forumIstatistik'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);