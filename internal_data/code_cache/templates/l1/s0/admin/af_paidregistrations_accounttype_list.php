<?php
// FROM HASH: 420378c559ae5f62e5089491fd6ff849
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Account Types');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
    ' . $__templater->button('Add Account Type', array(
		'href' => $__templater->func('link', array('paid-registrations/add', ), false),
		'icon' => 'add',
		'overlay' => 'true',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	$__vars['first'] = $__templater->filter($__vars['accountTypeRows'], array(array('first', array()),array('first', array()),), false);
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['accountTypeRows'] AND (!$__vars['first']['version'])) {
		$__compilerTemp1 .= '
        <div class="block-outer">
            <div class="">
                <div class="inputGroup inputGroup--inline inputGroup--joined">
                    ' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'labelclass' => 'inputGroup-text',
			'checked' => 'checked',
			'disabled' => 'true',
			'class' => '',
			'label' => 'Always show "' . $__templater->escape($__vars['xf']['options']['af_paidregistrations_freeTitle']) . '" account type (hide by&nbsp;<a href="https://www.addonflare.com/xenforo-2-addons/paid-registrations.9/" target="_blank">upgrading to full version</a>)',
			'_type' => 'option',
		))) . '
                </div>
            </div>
        </div>
    ';
	}
	$__vars['totals'] = '0';
	$__compilerTemp2 = '';
	if ($__templater->isTraversable($__vars['accountTypeRows'])) {
		foreach ($__vars['accountTypeRows'] AS $__vars['row'] => $__vars['accountTypeRow']) {
			$__compilerTemp2 .= '
            <div class="block-body">
                ';
			$__compilerTemp3 = '';
			if ($__templater->isTraversable($__vars['accountTypeRow'])) {
				foreach ($__vars['accountTypeRow'] AS $__vars['accountType']) {
					$__compilerTemp3 .= '
                        ';
					$__compilerTemp4 = array(array(
						'name' => 'active[' . $__vars['accountType']['account_type_id'] . ']',
						'selected' => $__vars['accountType']['active'],
						'class' => 'dataList-cell--separated',
						'submit' => 'true',
						'tooltip' => 'Enable / disable \'' . $__vars['accountType']['title'] . '\'',
						'_type' => 'toggle',
						'html' => '',
					));
					if ($__vars['accountType']['for_deletion']) {
						$__compilerTemp4[] = array(
							'href' => $__templater->func('link', array('paid-registrations/delete', $__vars['accountType'], ), false),
							'tooltip' => 'Delete',
							'_type' => 'delete',
							'html' => '',
						);
					}
					$__compilerTemp3 .= $__templater->dataRow(array(
						'label' => $__templater->escape($__vars['accountType']['title']),
						'href' => $__templater->func('link', array('paid-registrations/edit', $__vars['accountType'], ), false),
						'rowclass' => '',
						'hint' => '',
						'explain' => ($__templater->escape($__vars['accountType']['UserUpgrade']['cost_phrase']) ?: 'Free'),
					), $__compilerTemp4) . '
                    ';
				}
			}
			$__compilerTemp2 .= $__templater->dataList('
                    ' . $__templater->dataRow(array(
				'rowtype' => 'subsection',
				'rowclass' => 'dataList-row--noHover',
			), array(array(
				'colspan' => '3',
				'_type' => 'cell',
				'html' => 'Row #' . $__templater->escape($__vars['row']),
			))) . '
                    ' . $__compilerTemp3 . '
                ', array(
			)) . '
            </div>
            ';
			$__vars['totals'] = ($__vars['totals'] + $__templater->func('count', array($__vars['accountTypeRow'], ), false));
			$__compilerTemp2 .= '
        ';
		}
	}
	$__finalCompiled .= $__templater->form('
    ' . $__compilerTemp1 . '
    <div class="block-container">
        ' . '' . '
        ' . $__compilerTemp2 . '

        <div class="block-footer">
            <span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['totals'], ), true) . '</span>
        </div>
    </div>
', array(
		'action' => $__templater->func('link', array('paid-registrations/toggle', ), false),
		'ajax' => 'true',
		'class' => 'block',
	));
	return $__finalCompiled;
}
);