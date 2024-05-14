<?php
// FROM HASH: f03d451b13875d76160a56e39507969f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('');
	$__finalCompiled .= '
<div class="block">
		<div class="block-container">
			<div class="block-body">
					<div class="block-header">
						<h3 class="block-minorHeader">' . '' . $__templater->escape($__vars['ownerPage']['User']['username']) . '\'s ' . $__templater->escape($__vars['item']['Brand']['brand_title']) . ' ' . $__templater->escape($__vars['item']['item_title']) . ' Topics' . '</h3>
						<div class="p-description">' . 'Here are the most recent ' . $__templater->escape($__vars['item']['item_title']) . ' topics from our community.' . '</div>
					</div>
					<div class="block-body block-row block-row--separated">
						<div class="block-body">
							';
	if (!$__templater->test($__vars['discussions'], 'empty', array())) {
		$__finalCompiled .= '
								<ol class="block-body">
									';
		if ($__templater->isTraversable($__vars['discussions'])) {
			foreach ($__vars['discussions'] AS $__vars['discussion']) {
				$__finalCompiled .= '
										' . $__templater->filter($__templater->method($__vars['discussion'], 'render', array(array('mod' => $__vars['activeModType'], ), )), array(array('raw', array()),), true) . '
									';
			}
		}
		$__finalCompiled .= '
								</ol>
								';
	} else {
		$__finalCompiled .= '
								<div class="blockMessage">' . 'No discussions tagged.' . '</div>
							';
	}
	$__finalCompiled .= '
						</div>
					</div>			
			</div>
		</div>
</div>';
	return $__finalCompiled;
}
);