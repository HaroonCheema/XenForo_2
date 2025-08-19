<?php
// FROM HASH: a699f68acb73bf541c69e1d94e27a433
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Discounts');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body">
			';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['package']['discount'])) {
		foreach ($__vars['package']['discount'] AS $__vars['purchase'] => $__vars['discount']) {
			$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
			), array(array(
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['purchase']) . ' ' . $__templater->escape($__templater->method($__vars['package'], 'getCostPerPhrase', array($__vars['purchase'], ))),
			),
			array(
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['discount']) . '%',
			))) . '
				';
		}
	}
	$__finalCompiled .= $__templater->dataList('
				<thead>
					' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => 'Purchase',
	),
	array(
		'_type' => 'cell',
		'html' => 'Discount',
	))) . '
				</thead>
				' . $__compilerTemp1 . '
			', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);