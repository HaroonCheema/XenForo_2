<?php
// FROM HASH: c8875ab55db5c1ad022b95d3b146e1a0
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Choose User Upgrade');
	$__finalCompiled .= '

';
	$__compilerTemp1 = array(array(
		'_type' => 'option',
	)
,array(
		'value' => '-1',
		'label' => $__templater->escape($__vars['xf']['options']['af_paidregistrations_freeTitle']),
		'_type' => 'option',
	));
	if ($__templater->isTraversable($__vars['upgrades'])) {
		foreach ($__vars['upgrades'] AS $__vars['user_upgrade_id'] => $__vars['upgrade']) {
			$__compilerTemp1[] = array(
				'value' => $__vars['user_upgrade_id'],
				'label' => $__templater->escape($__vars['upgrade']['title']) . ' (' . $__templater->escape($__vars['upgrade']['cost_phrase']) . ($__vars['upgrade']['length_unit'] ? '' : (' ' . 'Permanent')) . ')',
				'_type' => 'option',
			);
		}
	}
	$__finalCompiled .= $__templater->form('
    <div class="block-container">
        <div class="block-body">
            ' . $__templater->formSelectRow(array(
		'name' => 'user_upgrade_id',
	), $__compilerTemp1, array(
		'label' => 'User Upgrade',
	)) . '
        </div>
        ' . $__templater->formSubmitRow(array(
		'submit' => 'Proceed' . $__vars['xf']['language']['ellipsis'],
	), array(
	)) . '
    </div>
', array(
		'action' => $__templater->func('link', array('paid-registrations/add', ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);