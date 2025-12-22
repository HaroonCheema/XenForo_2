<?php
// FROM HASH: a45294a521be7f9800a4da421da2b760
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
	<div class="block-container">
		<h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
		<div class="block-body block-row">
			';
	if ($__templater->isTraversable($__vars['categories'])) {
		foreach ($__vars['categories'] AS $__vars['category']) {
			$__finalCompiled .= '
				<dl class="pairs pairs--justified">
					<dt><a href="' . $__templater->func('link', array('ewr-porta/categories', $__vars['category'], ), true) . '">' . $__templater->escape($__vars['category']['category_name']) . '</a></dt>
					<dd><a href="' . $__templater->func('link', array('ewr-porta/categories', $__vars['category'], ), true) . '">' . $__templater->filter($__vars['category']['count'], array(array('NUMBER', array()),), true) . '</a></dd>
				</dl>
			';
		}
	}
	$__finalCompiled .= '
		</div>
	</div>
</div>';
	return $__finalCompiled;
}
);