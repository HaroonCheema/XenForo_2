<?php
// FROM HASH: 28f2f3f142b03a1af3f83a281140ae74
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Invoice details' . $__vars['xf']['language']['label_separator'] . ' #' . $__templater->escape($__vars['invoice']['invoice_id']));
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['invoice']['recurring']) {
		$__compilerTemp1 .= '
					' . $__vars['xf']['language']['parenthesis_open'] . 'Subscription' . $__vars['xf']['language']['parenthesis_close'] . '
				';
	}
	$__compilerTemp2 = '';
	if ($__vars['invoice']['Ad']) {
		$__compilerTemp2 .= '
				' . $__templater->formRow('
					<a href="' . $__templater->func('link', array('ads-manager/ads/edit', $__vars['invoice']['Ad'], ), true) . '">' . $__templater->escape($__vars['invoice']['Ad']['name']) . '</a>
				', array(
			'label' => 'Ad',
		)) . '
			';
	}
	$__compilerTemp3 = '';
	if (!$__templater->test($__vars['invoices'], 'empty', array())) {
		$__compilerTemp3 .= '
				';
		$__compilerTemp4 = '';
		if ($__templater->isTraversable($__vars['invoices'])) {
			foreach ($__vars['invoices'] AS $__vars['invoice']) {
				$__compilerTemp4 .= '
							<li><a href="' . $__templater->func('link', array('ads-manager/invoices/details', $__vars['invoice'], ), true) . '" data-xf-click="overlay">#' . $__templater->escape($__vars['invoice']['invoice_id']) . '</a>  - ' . $__templater->filter($__vars['invoice']['cost_amount'], array(array('currency', array($__vars['invoice']['cost_currency'], )),), true) . '</li>
						';
			}
		}
		$__compilerTemp3 .= $__templater->formRow('
					<ul class="listPlain">
						' . $__compilerTemp4 . '
					</ul>
				', array(
			'label' => 'Invoices',
			'hint' => 'Mass pay',
		)) . '
			';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				' . $__templater->filter($__vars['invoice']['cost_amount'], array(array('currency', array($__vars['invoice']['cost_currency'], )),), true) . '
				' . $__compilerTemp1 . '
			', array(
		'label' => 'Amount',
	)) . '

			' . $__templater->formRow('
				' . $__templater->func('username_link', array($__vars['invoice']['User'], true, array(
		'defaultname' => $__vars['invoice']['username'],
	))) . '
			', array(
		'label' => 'Advertiser',
	)) . '

			' . $__compilerTemp2 . '

			<hr class="formRowSep" />

			' . $__compilerTemp3 . '
		</div>
	</div>
', array(
		'class' => 'block',
	));
	return $__finalCompiled;
}
);