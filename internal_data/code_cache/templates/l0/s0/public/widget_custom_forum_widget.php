<?php
// FROM HASH: 713573b520bafd9e80f428f780ebc33b
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '
	<div class="block"' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
		<div class="block-container">
			<h3 class="block-minorHeader">
				<a href="' . $__templater->escape($__vars['link']) . '" rel="nofollow">' . $__templater->escape($__vars['title']) . '</a>
			</h3>
			<ul class="block-body">
				';
		if (!$__templater->test($__vars['threads'], 'empty', array())) {
			$__finalCompiled .= '
					';
			if ($__templater->isTraversable($__vars['threads'])) {
				foreach ($__vars['threads'] AS $__vars['thread']) {
					$__finalCompiled .= '
						<li class="block-row">
							<div class="contentRow">
								<div class="contentRow-figure">
									' . $__templater->func('avatar', array($__vars['thread']['LastPoster'], 'xxs', false, array(
						'defaultname' => $__vars['thread']['last_post_username'],
					))) . '
								</div>
								<div class="contentRow-main contentRow-main--close">
									';
					if ($__templater->method($__vars['thread'], 'isUnread', array())) {
						$__finalCompiled .= '
										<a href="' . $__templater->func('link', array('threads/unread', $__vars['thread'], ), true) . '">' . $__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']) . '</a>
										';
					} else {
						$__finalCompiled .= '
										<a href="' . $__templater->func('link', array('threads/post', $__vars['thread'], array('post_id' => $__vars['thread']['last_post_id'], 'isClicked' => 2, ), ), true) . '">' . $__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']) . '</a>
									';
					}
					$__finalCompiled .= '

									<div class="contentRow-minor contentRow-minor--hideLinks">
										<ul class="listInline listInline--bullet">
											<li>' . 'Latest: ' . $__templater->escape($__vars['thread']['last_post_cache']['username']) . '' . '</li>
											<li>' . $__templater->func('date_dynamic', array($__vars['thread']['last_post_date'], array(
					))) . '</li>
										</ul>

									</div>
									<div class="contentRow-minor contentRow-minor--hideLinks">
										<a href="' . $__templater->func('link', array('forums', $__vars['thread']['Forum'], ), true) . '">' . $__templater->escape($__vars['thread']['Forum']['title']) . '</a>
									</div>

									<div class="contentRow-minor contentRow-minor--hideLinks">
										<ul class="listInline listInline--bullet">
											<li>' . 'Clicks: ' . $__templater->escape($__vars['thread']['click_count']) . '' . '</li>
											<li>' . 'Views: ' . $__templater->escape($__vars['thread']['view_count']) . '' . '</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
					';
				}
			}
			$__finalCompiled .= '
					';
		} else {
			$__finalCompiled .= '
					<li class="block-row block-row--minor">
						' . 'No results found.' . '
					</li>
				';
		}
		$__finalCompiled .= '
			</ul>
		</div>
	</div>
';
	}
	return $__finalCompiled;
}
);