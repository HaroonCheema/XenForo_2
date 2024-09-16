<?php
// FROM HASH: 9c875078fbc6b5437586626c86ab87f2
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Rating Styles');
	$__finalCompiled .= '

';
	$__templater->pageParams['pageAction'] = $__templater->preEscaped('
	' . $__templater->button('Add New Style Rating', array(
		'href' => $__templater->func('link', array('bratr-style-rating/add', ), false),
		'icon' => 'add',
	), '', array(
	)) . '
');
	$__finalCompiled .= '

<style>
.dataList-mainRow{
	max-height: inherit;
}
</style>
';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['styleRatings'])) {
		foreach ($__vars['styleRatings'] AS $__vars['styleRating']) {
			$__compilerTemp1 .= '
					' . $__templater->dataRow(array(
			), array(array(
				'hash' => $__vars['styleRating']['style_rating_id'],
				'href' => $__templater->func('link', array('bratr-style-rating/edit', $__vars['styleRating'], ), false),
				'label' => $__templater->filter($__templater->method($__vars['styleRating'], 'getIconHtml', array()), array(array('raw', array()),), true),
				'_type' => 'main',
				'html' => '',
			),
			array(
				'name' => 'status',
				'type' => 'radio',
				'value' => $__vars['styleRating']['style_rating_id'],
				'selected' => $__vars['styleRating']['status'],
				'class' => 'dataList-cell--separated',
				'submit' => 'true',
				'_type' => 'toggle',
				'html' => '',
			),
			array(
				'href' => $__templater->func('link', array('bratr-style-rating/delete', $__vars['styleRating'], ), false),
				'_type' => 'delete',
				'html' => '',
			))) . '
				';
		}
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-outer">
		' . $__templater->callMacro('filter_macros', 'quick_filter', array(
		'key' => 'styleRatings',
		'class' => 'block-outer-opposite',
	), $__vars) . '
	</div>
	<div class="block-container">
		<div class="block-body">
			' . $__templater->dataList('
				' . $__templater->dataRow(array(
	), array(array(
		'hash' => '0',
		'href' => 'javascript:',
		'label' => 'User Xenforo Default',
		'_type' => 'main',
		'html' => '',
	),
	array(
		'name' => 'status',
		'type' => 'radio',
		'value' => '0',
		'selected' => $__vars['defaultStyle'],
		'class' => 'dataList-cell--separated',
		'submit' => 'true',
		'_type' => 'toggle',
		'html' => '',
	))) . '

				' . $__compilerTemp1 . '
			', array(
	)) . '
		</div>
		<div class="block-footer">
			<span class="block-footer-counter">' . $__templater->func('display_totals', array($__vars['styleRatings'], ), true) . '</span>
		</div>
	</div>
', array(
		'action' => $__templater->func('link', array('bratr-style-rating/toggle', ), false),
		'class' => 'block',
		'ajax' => 'true',
	));
	return $__finalCompiled;
}
);