<?php
// FROM HASH: a8dff46f20bb82f1daa140a1bca87b64
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block">
	<div class="block-container">
		<h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
		<ol class="block-body">
			';
	if ($__templater->isTraversable($__vars['advertisers'])) {
		foreach ($__vars['advertisers'] AS $__vars['advertiser']) {
			$__finalCompiled .= '
				<li class="block-row">
					<div class="contentRow">
						<div class="contentRow-figure">
							' . $__templater->func('avatar', array($__vars['advertiser'], 'xs', false, array(
			))) . '
						</div>
						<div class="contentRow-main contentRow-main--close">
							' . $__templater->func('username_link', array($__vars['advertiser'], true, array(
			))) . '
							<div class="contentRow-minor">
								' . $__templater->func('user_title', array($__vars['advertiser'], false, array(
			))) . '
							</div>
						</div>
					</div>
				</li>
			';
		}
	}
	$__finalCompiled .= '
		</ol>
	</div>
</div>';
	return $__finalCompiled;
}
);