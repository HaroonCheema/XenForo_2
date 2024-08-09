<?php
// FROM HASH: ef45047e04f7330b53ebac9a325d1d39
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('altf_active_filter.less');
	$__finalCompiled .= '
';
	if ($__vars['xf']['options']['altf_auto_reload']) {
		$__finalCompiled .= '
    ';
		$__templater->includeJs(array(
			'src' => 'AL/FilterFramework/filter_reload.js',
			'min' => '0',
		));
		$__finalCompiled .= '
    <li style="display: none" data-xf-init="activeFilterContainer" data-reload-target=".block[data-type=\'thread\']"></li>
';
	}
	$__finalCompiled .= '
';
	return $__finalCompiled;
}
);