<?php
// FROM HASH: 2f6e962303ee309c414204bddfdc6063
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Google Analytics');
	$__finalCompiled .= '

<div class="block">
	<div class="block-container">
		<div class="block-body block-row">
			' . $__templater->filter('<a href="https://analytics.google.com/" target="_blank">Google Analytics</a> allows you to track ad views and clicks, providing detailed information about the visitors who interact with the ads.

Statistics for ads can be found in your Google Analytics account under Behavior > Events. In order to make use of this feature, please make sure that you have set your <a href="' . $__templater->func('link', array('options/groups/seo/#googleAnalyticsWebPropertyId', ), false) . '">web property ID</a>.', array(array('raw', array()),), true) . '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);