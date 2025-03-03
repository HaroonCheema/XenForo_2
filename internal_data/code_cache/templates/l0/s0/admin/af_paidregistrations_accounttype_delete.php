<?php
// FROM HASH: c01a56092285254a394b4ab41c1aff4b
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
                ' . 'Account Type' . ': <strong><a href="' . $__templater->func('link', array('paid-registrations/edit', $__vars['accountType'], ), true) . '">' . $__templater->escape($__vars['accountType']['title']) . '</a></strong>
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
		'action' => $__templater->func('link', array('paid-registrations/delete', $__vars['accountType'], ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);