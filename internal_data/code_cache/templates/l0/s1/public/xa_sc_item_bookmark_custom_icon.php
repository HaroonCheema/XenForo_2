<?php
// FROM HASH: 83764ca0ea52e68e0e16738c9a3253ee
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="contentRow-figure contentRow-figure--fixedBookmarkIcon">
	';
	if ($__vars['content']['cover_image_id']) {
		$__finalCompiled .= '
		<div class="contentRow-figureContainer">
			<a href="' . $__templater->func('link', array('showcase', $__vars['content'], ), true) . '">
				' . $__templater->func('sc_item_thumbnail', array($__vars['content'], ), true) . '
			</a>			
		</div>
	';
	} else if ($__vars['content']['Category']['content_image_url']) {
		$__finalCompiled .= '
		<div class="contentRow-figureContainer">
			<a href="' . $__templater->func('link', array('showcase', $__vars['content'], ), true) . '">
				' . $__templater->func('sc_category_icon', array($__vars['content'], ), true) . '
			</a>			
		</div>
	';
	} else {
		$__finalCompiled .= '
		' . $__templater->func('avatar', array($__vars['content']['User'], 's', false, array(
			'defaultname' => $__vars['content']['User']['username'],
		))) . '
	';
	}
	$__finalCompiled .= '
</div>';
	return $__finalCompiled;
}
);