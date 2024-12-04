<?php
// FROM HASH: 02380c10494f1cc6c96a9e853acfb427
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Restore User\'s Purchase Log');
	$__finalCompiled .= '
' . $__templater->form('
    <div class="block-container">
        <div class="block-body">
            ' . $__templater->formInfoRow('
                <div class="blockMessage blockMessage--important">
                    <strong>' . 'Note' . $__vars['xf']['language']['label_separator'] . '</strong> ' . 'Are You Sure To Restore This User Purchase Log' . '
                </div>
            ', array(
	)) . '
            ' . $__templater->formInfoRow('
                <strong>' . $__templater->escape($__vars['deletedLog']['User']['username']) . '</strong>
            ', array(
		'label' => 'user_to_delete',
		'style' => 'text-align: center;',
	)) . '
        </div>
        ' . $__templater->formSubmitRow(array(
		'icon' => 'delete',
		'sticky' => 'true',
	), array(
	)) . '
    </div>
    ' . $__templater->func('redirect_input', array(null, null, true)) . '
', array(
		'action' => $__templater->func('link', array('delete-purchase-log/restore-purchase-log', $__vars['deletedLog'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);