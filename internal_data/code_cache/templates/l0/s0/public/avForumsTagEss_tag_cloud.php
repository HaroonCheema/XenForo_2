<?php
// FROM HASH: dd0115178e207b02711357432a6a6211
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['tagCloud'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__templater->includeCss('tag.less');
		$__finalCompiled .= '

	<div class="block" ' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
		<div class="block-container">
			<h3 class="block-minorHeader">' . ($__templater->escape($__vars['title']) ?: 'avForumsTagEss_tags_cloud') . '</h3>
			<div class="block-body block-row tagCloud">
				';
		if ($__templater->isTraversable($__vars['tagCloud'])) {
			foreach ($__vars['tagCloud'] AS $__vars['cloudEntry']) {
				$__finalCompiled .= '
					';
				if ($__vars['forum']) {
					$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('forums', $__vars['forum'], array('tags' => $__vars['cloudEntry']['tag']['tag'], ), ), true) . '" class="tagCloud-tag tagCloud-tagLevel' . $__templater->escape($__vars['cloudEntry']['level']) . '">' . $__templater->escape($__vars['cloudEntry']['tag']['tag']) . '</a>
					';
				} else {
					$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('tags', $__vars['cloudEntry']['tag'], ), true) . '" class="tagCloud-tag tagCloud-tagLevel' . $__templater->escape($__vars['cloudEntry']['level']) . '">' . $__templater->escape($__vars['cloudEntry']['tag']['tag']) . '</a>
					';
				}
				$__finalCompiled .= '
				';
			}
		}
		$__finalCompiled .= '
			</div>
		</div>
	</div>
';
	}
	return $__finalCompiled;
}
);