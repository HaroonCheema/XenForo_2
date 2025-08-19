<?php
// FROM HASH: 6a94e52d6eb773abd8d78a5986234290
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Instructions');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body block-row">
			' . $__templater->filter('To use this position, copy the syntax below and paste it in the template or in the HTML widget where you want the ads to display.

<b>
	<blockquote>
		<code>&lt;xf:macro template="siropu_ads_manager_ad_macros" name="ad_unit" arg-position="' . $__vars['position']['position_id'] . '" /&gt;
		</code>
	</blockquote>
</b>', array(array('raw', array()),), true) . '
		</div>
		' . $__templater->formSubmitRow(array(
	), array(
		'html' => '
				' . $__templater->button('Okay', array(
		'href' => $__templater->func('link', array('ads-manager/positions', ), false),
		'icon' => 'confirm',
	), '', array(
	)) . '
				' . $__templater->button('Edit', array(
		'href' => $__templater->func('link', array('ads-manager/positions/edit', $__vars['position'], ), false),
		'icon' => 'edit',
	), '', array(
	)) . '
			',
	)) . '
	</div>
</div>';
	return $__finalCompiled;
}
);