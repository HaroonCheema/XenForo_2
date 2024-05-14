<?php
// FROM HASH: 4611ffd0d588f9c6d0262bc6bd4ec20a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Ads');
	$__finalCompiled .= '
	
<div class="block-container">
	<div class="block-body">
		
		';
	$__vars['ads'] = array('brand List Sidebar' => 'bh_ad_brandList_sidebar', 'Item List Sidebar' => 'bh_ad_itemList_sidebar', 'Item view Sidebar' => 'bh_ad_itemView_sidebar', 'OwnerPage Sidebar' => 'bh_ad_ownerPage_sidebar', 'UserReviews Above (on Item View page)' => 'bh_ad_userReviw_above', 'UserReviews Below (on Item View page)' => 'bh_ad_userReviw_below', );
	$__finalCompiled .= '

		';
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['ads'])) {
		foreach ($__vars['ads'] AS $__vars['location'] => $__vars['ad']) {
			$__compilerTemp1 .= '
				' . $__templater->dataRow(array(
			), array(array(
				'_type' => 'cell',
				'html' => $__templater->escape($__vars['location']),
			),
			array(
				'href' => $__templater->func('link', array('bh-ads/edit', null, array('template_title' => $__vars['ad'], 'location_name' => $__vars['location'], ), ), false),
				'overlay' => 'true',
				'_type' => 'action',
				'html' => 'Edit Code',
			))) . '
			';
		}
	}
	$__finalCompiled .= $__templater->dataList('
			' . $__templater->dataRow(array(
		'rowtype' => 'header',
	), array(array(
		'_type' => 'cell',
		'html' => 'Location',
	),
	array(
		'class' => 'dataList-cell--min',
		'_type' => 'cell',
		'html' => '&nbsp;',
	))) . '
			' . $__compilerTemp1 . '
		', array(
		'data-xf-init' => 'responsive-data-list',
	)) . '
	</div>
</div>';
	return $__finalCompiled;
}
);