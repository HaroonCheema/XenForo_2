<?php
// FROM HASH: 68797b82999c68211b1baebe32692ba7
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Export ads');
	$__finalCompiled .= '

';
	if (!$__templater->test($__vars['ads'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['ads'])) {
			foreach ($__vars['ads'] AS $__vars['adType'] => $__vars['adList']) {
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
					'html' => $__templater->func('sam_type_phrase', array($__vars['adType'], ), true),
				))) . '
							';
				if ($__templater->isTraversable($__vars['adList'])) {
					foreach ($__vars['adList'] AS $__vars['ad']) {
						$__compilerTemp1 .= '
								';
						$__compilerTemp2 = '';
						if ($__vars['ad']['Package']) {
							$__compilerTemp2 .= '
											<div class="dataList-subRow">' . $__templater->escape($__vars['ad']['Package']['title']) . '</div>
										';
						}
						$__compilerTemp1 .= $__templater->dataRow(array(
						), array(array(
							'name' => 'export[]',
							'value' => $__vars['ad']['ad_id'],
							'_type' => 'toggle',
							'html' => '',
						),
						array(
							'href' => $__templater->func('link', array('ads-manager/ads/edit', $__vars['ad'], ), false),
							'_type' => 'cell',
							'html' => '
										<div class="dataList-mainRow">' . $__templater->escape($__vars['ad']['name']) . '</div>
										' . $__compilerTemp2 . '
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
				<span class="block-footer-select">' . $__templater->formCheckBox(array(
			'standalone' => 'true',
		), array(array(
			'check-all' => '.dataList',
			'label' => 'Select all',
			'_type' => 'option',
		))) . '</span>
				<span class="block-footer-controls">' . $__templater->button('', array(
			'type' => 'submit',
			'icon' => 'export',
		), '', array(
		)) . '</span>
			</div>
		</div>
	', array(
			'action' => $__templater->func('link', array('ads-manager/ads/mass-export', ), false),
			'class' => 'block',
		)) . '
';
	} else {
		$__finalCompiled .= '
	<div class="blockMessage">' . 'No ads have been created yet.' . '</div>
';
	}
	return $__finalCompiled;
}
);