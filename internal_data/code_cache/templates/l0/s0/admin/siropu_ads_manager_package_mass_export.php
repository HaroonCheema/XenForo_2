<?php
// FROM HASH: 906a4142f77e7366115f1b4caae49e04
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Export packages');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['packages'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['packages'])) {
			foreach ($__vars['packages'] AS $__vars['type'] => $__vars['packageList']) {
				$__compilerTemp1 .= '
						<tbody class="dataList-rowGroup">
							' . $__templater->dataRow(array(
					'rowtype' => 'subsection',
					'rowclass' => 'dataList-row--noHover',
				), array(array(
					'_type' => 'cell',
					'html' => $__templater->formCheckBox(array(
					'standalone' => 'true',
				), array(array(
					'check-all' => '< .dataList-rowGroup',
					'_type' => 'option',
				))),
				),
				array(
					'_type' => 'cell',
					'html' => $__templater->func('sam_type_phrase', array($__vars['type'], ), true),
				))) . '
							';
				if ($__templater->isTraversable($__vars['packageList'])) {
					foreach ($__vars['packageList'] AS $__vars['package']) {
						$__compilerTemp1 .= '
								' . $__templater->dataRow(array(
						), array(array(
							'name' => 'export[]',
							'value' => $__vars['package']['package_id'],
							'_type' => 'toggle',
							'html' => '',
						),
						array(
							'href' => $__templater->func('link', array('ads-manager/packages/edit', $__vars['package'], ), false),
							'_type' => 'cell',
							'html' => '
										<div class="dataList-mainRow">' . $__templater->escape($__vars['package']['title']) . '</div>
									',
						))) . '
							';
					}
				}
				$__compilerTemp1 .= '
						</tbody>
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
			<div class="block-footer block-footer--split">
				<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['total'], ), true) . '</span>
				<span class="block-footer-select">
					' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'check-all' => '.dataList',
			'label' => 'Select all',
			'_type' => 'option',
		))) . '
					' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'name' => 'export_ads',
			'value' => '1',
			'checked' => 'true',
			'label' => 'Export ads',
			'_type' => 'option',
		))) . '
				</span>
				<span class="block-footer-controls">' . $__templater->button('', array(
			'type' => 'submit',
			'icon' => 'export',
		), '', array(
		)) . '</span>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('ads-manager/packages/mass-export', ), false),
			'class' => 'block',
		)) . '
';
	} else {
		$__finalCompiled .= '
	
';
	}
	return $__finalCompiled;
}
);