<?php
// FROM HASH: 06c0a94f313fc18e1450c4f770e032d2
return array(
'macros' => array('sideBar_brand' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->modifySidebarHtml('infoSidebar', '
		<div class="block">
			<div class="block-container">
				<div class="sideBar_ad">
					' . $__templater->includeTemplate('bh_ad_brandList_sidebar', $__vars) . '
				</div>
			</div>
		</div>
	', 'replace');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'sideBar_itemlist' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->modifySidebarHtml('infoSidebar', '
		<div class="block">
			<div class="block-container">
				<div class="sideBar_ad">
					' . $__templater->includeTemplate('bh_ad_itemList_sidebar', $__vars) . '
				</div>
			</div>
		</div>
	', 'replace');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'sideBar_itemdetail' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->modifySidebarHtml('infoSidebar', '
		<div class="block">
			<div class="block-container">
				<div class="sideBar_ad">
					' . $__templater->includeTemplate('bh_ad_itemView_sidebar', $__vars) . '
				</div>
			</div>
		</div>
	', 'replace');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'sideBar_pageside' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__templater->modifySidebarHtml('infoSidebar', '
		<div class="block">
			<div class="block-container">
				<div class="sideBar_ad">
					' . $__templater->includeTemplate('bh_ad_ownerPage_sidebar', $__vars) . '
				</div>
			</div>
		</div>
	', 'replace');
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
),
'center_itemdetail1' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="center_ad">
				' . $__templater->includeTemplate('bh_ad_userReviw_above', $__vars) . '
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
),
'center_itemdetail2' => array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<div class="block">
		<div class="block-container">
			<div class="center_ad">
				' . $__templater->includeTemplate('bh_ad_userReviw_below', $__vars) . '
			</div>
		</div>
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

' . '


' . '

' . '

' . '

';
	return $__finalCompiled;
}
);