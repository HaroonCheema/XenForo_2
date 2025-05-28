<?php
// FROM HASH: b5a6ec3e195b8528a72be666ae8e175f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="block">
	<div class="block-container">
		<h3 class="block-minorHeader">' . $__templater->escape($__vars['title']) . '</h3>
		';
	if ($__vars['options']['compact']) {
		$__finalCompiled .= '
			<div class="block-body block-row">
				';
		if ($__templater->isTraversable($__vars['topReferrers'])) {
			foreach ($__vars['topReferrers'] AS $__vars['user']) {
				$__finalCompiled .= '
					<dl class="pairs pairs--justified">
						<dt>
							' . $__templater->func('avatar', array($__vars['user'], 'xxs', false, array(
					'itemprop' => 'image',
				))) . '
							' . $__templater->func('username_link', array($__vars['user'], true, array(
				))) . '
						</dt>
						<dd class="contentRow-minor contentRow-minor--hideLinks">
							<a href="' . $__templater->func('link', array('members/referrals', $__vars['user'], array('type' => $__vars['options']['type'], ), ), true) . '" class="u-concealed" data-xf-click="overlay">' . $__templater->escape($__vars['user']['siropu_rs_referral_count']) . '</a>
						</dd>
					</dl>
				';
			}
		}
		$__finalCompiled .= '
			</div>
		';
	} else {
		$__finalCompiled .= '
			<ul class="block-body">
				';
		if ($__templater->isTraversable($__vars['topReferrers'])) {
			foreach ($__vars['topReferrers'] AS $__vars['user']) {
				$__finalCompiled .= '
					<li class="block-row">
						<div class="contentRow">
							<div class="contentRow-figure">
								' . $__templater->func('avatar', array($__vars['user'], 'xs', false, array(
				))) . '
							</div>
							<div class="contentRow-main contentRow-main--close">
								' . $__templater->func('username_link', array($__vars['user'], true, array(
				))) . '
								<div class="contentRow-minor">
									' . 'Referrals' . $__vars['xf']['language']['label_separator'] . ' <a href="' . $__templater->func('link', array('members/referrals', $__vars['user'], array('type' => $__vars['options']['type'], ), ), true) . '" class="u-concealed" data-xf-click="overlay">' . $__templater->escape($__vars['user']['siropu_rs_referral_count']) . '</a>
								</div>
							</div>
						</div>
					</li>
				';
			}
		}
		$__finalCompiled .= '
			</ul>
		';
	}
	$__finalCompiled .= '
	</div>
</div>';
	return $__finalCompiled;
}
);