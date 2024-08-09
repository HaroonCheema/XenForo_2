<?php
// FROM HASH: bdf95a23346188af8b6b72d69b522d34
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<li class="clearAllLink">
    <a href="' . $__templater->func('link', array('forums', $__vars['forum'], ), true) . '" class="filterBar-filterToggle" data-xf-init="tooltip" title="' . $__templater->filter('Remove all filters', array(array('for_attr', array()),), true) . '">
        ' . 'Clear all' . '
    </a>
</li>
';
	return $__finalCompiled;
}
);