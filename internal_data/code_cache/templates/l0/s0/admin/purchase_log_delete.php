<?php
// FROM HASH: ae100cc3b65aec36dd7f0d5758239105
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Delete User\'s Purchase Log');
	$__finalCompiled .= '
' . $__templater->form('
    <div class="block-container">
        <div class="block-body">
            ' . $__templater->formInfoRow('
                <div class="blockMessage blockMessage--important">
                    <strong>' . 'Note' . $__vars['xf']['language']['label_separator'] . '</strong> ' . 'Are You Sure To Delete this User Purchase Log?' . '
                </div>
            ', array(
	)) . '
            ' . $__templater->formInfoRow('
                <strong>' . $__templater->escape($__vars['creditPackage']['User']['username']) . '</strong>
            ', array(
		'label' => 'user_to_delete',
		'style' => 'text-align: center;',
	)) . '
            ' . $__templater->formTextBoxRow(array(
		'name' => 'reason',
		'required' => 'true',
	), array(
		'label' => 'Reason',
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
		'action' => $__templater->func('link', array('delete-purchase-log/delete-purchase', $__vars['creditPackage'], ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);