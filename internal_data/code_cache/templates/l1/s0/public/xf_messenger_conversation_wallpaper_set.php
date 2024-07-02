<?php
// FROM HASH: c30b77790522bc4c167b001f4dbf9b94
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->pageParams['pageTitle'] = $__templater->preEscaped('Set wallpaper');
	$__finalCompiled .= '

';
	$__templater->breadcrumb($__templater->preEscaped('Conversations'), $__templater->func('link', array('conversations', ), false), array(
	));
	$__finalCompiled .= '
';
	$__templater->breadcrumb($__templater->preEscaped($__templater->escape($__vars['conversation']['title'])), $__templater->func('link', array('conversations', $__vars['conversation'], ), false), array(
	));
	$__finalCompiled .= '

';
	$__templater->includeCss('rtc_message_type_wallpaper.less');
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'bs/real_time_chat/wallpaper-form.js',
		'min' => '1',
	));
	$__finalCompiled .= '

';
	$__vars['themes'] = $__templater->func('property', array('rtcThemes', ), false);
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['themes'])) {
		foreach ($__vars['themes'] AS $__vars['index'] => $__vars['theme']) {
			$__compilerTemp1 .= '
								';
			$__vars['roomTheme'] = $__templater->func('rtc_room_theme', array($__vars['index'], ), false);
			$__compilerTemp1 .= '
								<div class="theme-container js-theme ' . (($__vars['conversation']['wallpaper']['options']['theme_index'] === $__vars['index']) ? ' selected' : '') . '"
									 data-xf-click=""
									 data-theme-index="' . $__templater->escape($__vars['index']) . '"
									 data-theme="' . $__templater->filter($__vars['roomTheme'], array(array('json', array()),), true) . '">
									<canvas class="theme-canvas" 
											data-xf-init="chat-canvas-gradient"
											data-colors="' . $__templater->filter($__vars['roomTheme']['config']['background_colors'], array(array('json', array()),), true) . '"></canvas>
									<canvas class="theme-pattern" 
											data-xf-init="chat-canvas-pattern"
											data-url="' . $__templater->escape($__vars['roomTheme']['config']['pattern']) . '"></canvas>
								</div>
							';
		}
	}
	$__compilerTemp2 = array();
	if ($__templater->method($__vars['conversation'], 'canDeleteWallpaper', array())) {
		$__compilerTemp2[] = array(
			'name' => 'delete_wallpaper',
			'_type' => 'option',
		);
	}
	if ($__templater->method($__vars['conversation'], 'canSetWallpaper', array())) {
		$__compilerTemp2[] = array(
			'name' => 'for_room',
			'_type' => 'option',
		);
	}
	if ($__templater->method($__vars['conversation'], 'canResetWallpaper', array())) {
		$__compilerTemp2[] = array(
			'name' => 'reset_wallpaper',
			'_type' => 'option',
		);
	}
	if ($__templater->method($__vars['conversation'], 'canResetRoomWallpaper', array())) {
		$__compilerTemp2[] = array(
			'name' => 'reset_room_wallpaper',
			'_type' => 'option',
		);
	}
	$__compilerTemp3 = '';
	if ($__templater->method($__vars['conversation'], 'canDeleteWallpaper', array())) {
		$__compilerTemp3 .= '
					' . $__templater->button('Delete wallpaper', array(
			'data-xf-click' => 'element-value-setter',
			'data-value' => '1',
			'data-selector' => '< form | input[name=\'delete_wallpaper\']',
			'type' => 'submit',
			'form' => $__vars['formId'],
		), '', array(
		)) . '
				';
	}
	$__compilerTemp4 = '';
	if ($__templater->method($__vars['conversation'], 'canResetWallpaper', array())) {
		$__compilerTemp4 .= '
					' . $__templater->button('Reset to defaults', array(
			'class' => 'js-resetWallpaper',
			'data-xf-click' => 'element-value-setter',
			'data-value' => '1',
			'data-selector' => '< form | input[name=\'reset_wallpaper\']',
			'type' => 'submit',
			'form' => $__vars['formId'],
		), '', array(
		)) . '
				';
	}
	$__compilerTemp5 = '';
	if ($__templater->method($__vars['conversation'], 'canResetRoomWallpaper', array())) {
		$__compilerTemp5 .= '
					' . $__templater->button('Reset conversation wallpaper', array(
			'class' => 'js-resetWallpaper',
			'data-xf-click' => 'element-value-setter',
			'data-value' => '1',
			'data-selector' => '< form | input[name=\'reset_room_wallpaper\']',
			'type' => 'submit',
			'form' => $__vars['formId'],
		), '', array(
		)) . '
				';
	}
	$__finalCompiled .= $__templater->form('
	<div class="block-container">
		<div class="block-body">
			' . $__templater->formRow('
				<div class="h-scroller themes-list-container" data-xf-init="h-scroller">
					' . '' . '
					<div class="hScroller-scroll">
						<div class="themes-list">
							' . $__compilerTemp1 . '
						</div>
					</div>
					' . $__templater->formHiddenVal('theme_index', $__vars['conversation']['wallpaper']['options']['theme_index'], array(
		'class' => 'js-themeIndex',
	)) . '
				</div>
			', array(
		'label' => 'Select theme',
		'rowtype' => 'input',
	)) . '

			' . $__templater->formCheckBoxRow(array(
	), array(array(
		'name' => 'blurred',
		'checked' => $__vars['conversation']['wallpaper']['blurred'],
		'label' => 'Blur background',
		'_type' => 'option',
	)), array(
		'rowclass' => 'image-manage js-imageManage',
	)) . '

			' . $__templater->formRow('
				' . $__templater->button('Choose image', array(
		'class' => 'js-uploadButton',
		'data-reset' => 'Reset image',
	), '', array(
	)) . '
			', array(
	)) . '

			<div style="display:none">
				' . $__templater->formUpload(array(
		'class' => 'js-uploadInput',
		'name' => 'wallpaper',
		'accept' => '.gif,.jpeg,.jpg,.jpe,.png',
	)) . '

				' . $__templater->formCheckBox(array(
	), $__compilerTemp2) . '
			</div>
		</div>
		' . $__templater->formSubmitRow(array(
	), array(
		'html' => '
				' . $__templater->button('Confirm', array(
		'class' => 'button--primary',
		'type' => 'submit',
		'form' => $__vars['formId'],
	), '', array(
	)) . '
				' . $__templater->button('Set for all', array(
		'data-xf-click' => 'element-value-setter',
		'data-value' => '1',
		'data-selector' => '< form | input[name=\'for_room\']',
		'type' => 'submit',
		'form' => $__vars['formId'],
	), '', array(
	)) . '
				' . $__compilerTemp3 . '
				' . $__compilerTemp4 . '
				' . $__compilerTemp5 . '
			',
	)) . '
	</div>
', array(
		'action' => $__templater->func('link', array('conversations/wallpaper', $__vars['conversation'], ), false),
		'class' => 'block chat-message-form chat-message-form--wallpaper',
		'ajax' => 'true',
		'data-xf-init' => 'rtc-wallpaper-form',
		'data-redirect' => 'off',
		'data-reset-complete' => 'on',
	));
	return $__finalCompiled;
}
);