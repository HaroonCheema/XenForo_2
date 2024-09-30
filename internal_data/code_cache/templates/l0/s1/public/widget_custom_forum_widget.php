<?php
// FROM HASH: dca3896b0dbd434d806fc4f526572b23
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	if (!$__templater->test($__vars['threads'], 'empty', array())) {
		$__finalCompiled .= '
	';
		$__templater->includeCss('fs_custom_widget_list.less');
		$__finalCompiled .= '
	';
		$__templater->includeCss('fs_lightslider.less');
		$__finalCompiled .= '

	';
		$__templater->includeJs(array(
			'src' => 'vendor/lightslider/lightslider.js',
			'min' => '1',
		));
		$__finalCompiled .= '
	';
		$__templater->includeJs(array(
			'src' => 'CustomWidget/slider.js',
			'min' => '1',
		));
		$__finalCompiled .= '

	' . $__templater->func('dump', array($__templater->filter($__vars['options']['slider'], array(array('json', array()),), false), ), true) . '

	<div class="block" ' . $__templater->func('widget_data', array($__vars['widget'], ), true) . '>
		<div class="block-container">
			<h3 class="block-minorHeader">
				<a href="' . $__templater->escape($__vars['link']) . '" rel="nofollow">' . $__templater->escape($__vars['title']) . '</a>
			</h3>
			<div class="block-body block-row">
				<div class="itemList itemList--slider"
					 data-xf-init="item-slider"
					 data-xf-item-slider="' . $__templater->filter($__vars['options']['slider'], array(array('json', array()),), true) . '">

					';
		if ($__templater->isTraversable($__vars['threads'])) {
			foreach ($__vars['threads'] AS $__vars['thread']) {
				$__finalCompiled .= '
						<div class="itemList-item itemList-item--slider">
							<a href="' . $__templater->func('link', array('threads/post', $__vars['thread'], array('post_id' => $__vars['thread']['last_post_id'], 'isClicked' => 2, ), ), true) . '">
								<span class="xfmgThumbnail xfmgThumbnail--image xfmgThumbnail--fluid">
									<img class=\'xfmgThumbnail-image\' src="' . ($__templater->func('count', array($__vars['thread']['FirstPost']['Attachments'], ), false) ? $__templater->func('link', array('full:attachments', $__templater->method($__vars['thread']['FirstPost']['Attachments'], 'first', array()), ), true) : $__templater->func('base_url', array('styles/FS/CustomWidgetImage/no_image.png', true, ), true)) . '" alt=\'' . $__templater->escape($__vars['thread']['title']) . '\' style="width: ' . $__templater->escape($__vars['xf']['options']['fs_custom_thread_image_dimensions']['width']) . 'px; height: ' . $__templater->escape($__vars['xf']['options']['fs_custom_thread_image_dimensions']['height']) . 'px;"/>
									<span class=\'xfmgThumbnail-icon\'></span>
								</span>
							</a>

							';
				if ($__templater->method($__vars['thread'], 'isUnread', array())) {
					$__finalCompiled .= '
								<a href="' . $__templater->func('link', array('threads/unread', $__vars['thread'], array('post_id' => $__vars['thread']['last_post_id'], 'isClicked' => 2, ), ), true) . '">' . $__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']) . '</a>
								';
				} else {
					$__finalCompiled .= '
								<a href="' . $__templater->func('link', array('threads/post', $__vars['thread'], array('post_id' => $__vars['thread']['last_post_id'], 'isClicked' => 2, ), ), true) . '">' . $__templater->func('prefix', array('thread', $__vars['thread'], ), true) . $__templater->escape($__vars['thread']['title']) . '</a>
							';
				}
				$__finalCompiled .= '

							<div class="contentRow-minor contentRow-minor--hideLinks">
								<ul class="listInline listInline--bullet">
									<li>' . 'Clicks: ' . $__templater->escape($__vars['thread']['click_count']) . '' . '</li>
									<li>' . 'Views: ' . $__templater->escape($__vars['thread']['view_count']) . '' . '</li>
								</ul>
							</div>

						</div>
					';
			}
		}
		$__finalCompiled .= '
				</div>
			</div>
		</div>
	</div>
';
	}
	return $__finalCompiled;
}
);