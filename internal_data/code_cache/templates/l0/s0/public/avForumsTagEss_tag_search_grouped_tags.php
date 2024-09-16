<?php
// FROM HASH: 6c08179a9de021d6fa8eb426db19a15a
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if ($__vars['tagCloudGrouped']) {
		$__finalCompiled .= '
	';
		if ($__templater->isTraversable($__vars['tagCloudGrouped'])) {
			foreach ($__vars['tagCloudGrouped'] AS $__vars['tagCloudGroup']) {
				$__finalCompiled .= '
		<div class="block">
			<div class="block-container">
				<h3 class="block-header">' . ($__templater->escape($__vars['tagCloudGroup']['title']) ?: 'Popular tags') . '</h3>
				<div class="block-body block-row tagCloud">
					';
				if ($__templater->isTraversable($__vars['tagCloudGroup']['tags'])) {
					foreach ($__vars['tagCloudGroup']['tags'] AS $__vars['tagGroup']) {
						$__finalCompiled .= '
						<a href="' . $__templater->func('link', array('tags', $__vars['tagGroup']['tag'], ), true) . '" data-xf-init="preview-tooltip" data-preview-url="' . $__templater->func('link', array('tags/preview', $__vars['tagGroup']['tag'], ), true) . '" class="tagCloud-tag tagCloud-tagLevel' . $__templater->escape($__vars['tagGroup']['level']) . '">' . $__templater->escape($__vars['tagGroup']['tag']['tag']) . '</a>
					';
					}
				}
				$__finalCompiled .= '
				</div>
			</div>
		</div>
	';
			}
		}
		$__finalCompiled .= '
';
	}
	return $__finalCompiled;
}
);