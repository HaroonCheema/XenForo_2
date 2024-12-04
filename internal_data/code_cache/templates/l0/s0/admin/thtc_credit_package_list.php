<?php
// FROM HASH: b4812e51194b151b9a93caeabf21b285
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('
	' . 'Credit packages' . '
');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('
		' . 'Add credit package' . '
	', array(
		'icon' => 'add',
		'href' => $__templater->func('link', array('thtc-credit-package/add', ), false),
	), '', array(
	)) . '
');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['creditPackages'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['creditPackages'])) {
			foreach ($__vars['creditPackages'] AS $__vars['creditPackage']) {
				$__compilerTemp1 .= '
						' . $__templater->dataRow(array(
					'label' => $__templater->escape($__vars['creditPackage']['title']),
					'hint' => $__templater->escape($__vars['creditPackage']['cost_phrase']) . ' - ' . '' . $__templater->escape($__vars['creditPackage']['credits']) . ' credits',
					'href' => $__templater->func('link', array('thtc-credit-package/edit', $__vars['creditPackage'], ), false),
					'delete' => $__templater->func('link', array('thtc-credit-package/delete', $__vars['creditPackage'], ), false),
				), array(array(
					'name' => 'can_purchase[' . $__vars['creditPackage']['credit_package_id'] . ']',
					'selected' => $__vars['creditPackage']['can_purchase'],
					'class' => 'dataList-cell--separated',
					'submit' => 'true',
					'tooltip' => 'Enable / disable \'' . $__vars['upgrade']['title'] . '\'',
					'_type' => 'toggle',
					'html' => '',
				),
				array(
					'class' => 'dataList-cell--action',
					'_type' => 'popup',
					'html' => '
								<div class="menu" data-menu="menu" aria-hidden="true">
									<div class="menu-content">
										<h3 class="menu-header">' . 'Actions' . '</h3>
										<a href="' . $__templater->func('link', array('thtc-credit-package/purchase-log', $__vars['creditPackage'], ), true) . '" class="menu-linkRow">' . 'Purchase log' . '</a>
										<a href="' . $__templater->func('link', array('thtc-credit-package/manual', $__vars['creditPackage'], ), true) . '" class="menu-linkRow">' . 'Manually give to user' . '</a>
									</div>
								</div>
							',
				))) . '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
		<div class="block-container">
			<div class="block-body">
				' . $__templater->dataList('
					' . $__compilerTemp1 . '
				', array(
		)) . '
			</div>
			<div class="block-footer">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['creditPackages'], ), true) . '</span>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('thtc-credit-package/toggle', ), false),
			'class' => 'block',
			'ajax' => 'true',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No items have been created yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);