<?php
// FROM HASH: 53ecbde731f41a159e26d5c7a6307869
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__templater->isTraversable($__vars['filters']['prefix_id'])) {
		foreach ($__vars['filters']['prefix_id'] AS $__vars['prefixId']) {
			$__finalCompiled .= '
	';
			$__vars['newFilters'] = $__vars['filters'];
			$__finalCompiled .= '
	';
			$__vars['newFilters']['prefix_id'] = $__templater->filter($__vars['newFilters']['prefix_id'], array(array('replaceValue', array($__vars['prefixId'], null, )),), false);
			$__finalCompiled .= '

	<li><a href="' . $__templater->func('link', array($__vars['baseLinkPath'], $__vars['container'], $__vars['newFilters'], ), true) . '"
		   class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove this filter', array(array('for_attr', array()),), true) . '">
		<span class="filterBar-filterToggle-label">' . 'Prefix' . $__vars['xf']['language']['label_separator'] . '</span>
		' . ($__vars['prefixId'] ? $__templater->func('prefix_title', array($__vars['prefixType'], $__vars['prefixId'], ), true) : $__vars['xf']['language']['parenthesis_open'] . 'None' . $__vars['xf']['language']['parenthesis_close']) . '</a></li>
';
		}
	}
	return $__finalCompiled;
}
);