<?php
// FROM HASH: 327ae2e50afc8d4b4474986a7c9e352f
return array(
'macros' => array('set_wallpaper_form' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'message' => '!',
		'filter' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
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
	$__vars['author'] = $__templater->preEscaped('
		' . $__templater->func('username_link', array($__vars['message']['User'], true, array(
	))) . '
	');
	$__finalCompiled .= '
	
	';
	$__vars['formId'] = $__templater->func('unique_id', array(), false);
	$__finalCompiled .= '
	
	';
	$__vars['room'] = $__vars['message']['Room'];
	$__vars['themes'] = $__templater->func('property', array('rtcThemes', ), false);
	$__compilerTemp1 = '';
	if ($__templater->isTraversable($__vars['themes'])) {
		foreach ($__vars['themes'] AS $__vars['index'] => $__vars['theme']) {
			$__compilerTemp1 .= '
								';
			$__vars['roomTheme'] = $__templater->func('rtc_room_theme', array($__vars['index'], ), false);
			$__compilerTemp1 .= '
								<div class="theme-container js-theme ' . (($__vars['room']['wallpaper']['options']['theme_index'] === $__vars['index']) ? ' selected' : '') . '"
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
	if ($__templater->method($__vars['room'], 'canDeleteWallpaper', array())) {
		$__compilerTemp2[] = array(
			'name' => 'delete_wallpaper',
			'_type' => 'option',
		);
	}
	if ($__templater->method($__vars['room'], 'canSetWallpaper', array())) {
		$__compilerTemp2[] = array(
			'name' => 'for_room',
			'_type' => 'option',
		);
	}
	if ($__templater->method($__vars['room'], 'canResetWallpaper', array())) {
		$__compilerTemp2[] = array(
			'name' => 'reset_wallpaper',
			'_type' => 'option',
		);
	}
	if ($__templater->method($__vars['room'], 'canResetRoomWallpaper', array())) {
		$__compilerTemp2[] = array(
			'name' => 'reset_room_wallpaper',
			'_type' => 'option',
		);
	}
	$__vars['form'] = $__templater->preEscaped('
		' . '' . '
		' . $__templater->form('
			<div class="form-header">
				' . 'Select theme' . '
			</div>
			<div class="form-body">
				<div class="space-line h-scroller themes-list-container" data-xf-init="h-scroller">
					' . '' . '
					<div class="hScroller-scroll">
						<div class="themes-list">
							' . $__compilerTemp1 . '
						</div>
					</div>
					' . $__templater->formHiddenVal('theme_index', $__vars['room']['wallpaper']['options']['theme_index'], array(
		'class' => 'js-themeIndex',
	)) . '
				</div>
				
				' . $__templater->formCheckBox(array(
		'listclass' => 'image-manage js-imageManage',
		'style' => (($__vars['room']['wallpaper']['type'] === 'member') ? '' : 'display:none;'),
	), array(array(
		'name' => 'blurred',
		'checked' => $__vars['room']['wallpaper']['blurred'],
		'label' => 'Blur background',
		'_type' => 'option',
	))) . '
				
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
		', array(
		'action' => $__templater->func('link', array('chat/messages/wallpaper', $__vars['message'], ), false),
		'id' => $__vars['formId'],
		'class' => 'chat-message-form chat-message-form--wallpaper',
		'data-xf-init' => 'rtc-wallpaper-form',
		'ajax' => 'true',
		'data-redirect' => 'off',
	)) . '
	');
	$__finalCompiled .= '
	
	';
	$__compilerTemp3 = '';
	if ($__templater->method($__vars['room'], 'canSetWallpaper', array())) {
		$__compilerTemp3 .= '
				' . $__templater->button('Set for room', array(
			'data-xf-click' => 'element-value-setter',
			'data-value' => '1',
			'data-selector' => '< .js-message | input[name=\'for_room\']',
			'type' => 'submit',
			'form' => $__vars['formId'],
		), '', array(
		)) . '
			';
	}
	$__compilerTemp4 = '';
	$__compilerTemp5 = '';
	$__compilerTemp5 .= '
					';
	if ($__templater->method($__vars['room'], 'canDeleteWallpaper', array())) {
		$__compilerTemp5 .= '
						' . $__templater->button('Delete wallpaper', array(
			'data-xf-click' => 'element-value-setter',
			'data-value' => '1',
			'data-selector' => '< .js-message | input[name=\'delete_wallpaper\']',
			'type' => 'submit',
			'form' => $__vars['formId'],
		), '', array(
		)) . '
					';
	}
	$__compilerTemp5 .= '
					';
	if ($__templater->method($__vars['room'], 'canResetWallpaper', array())) {
		$__compilerTemp5 .= '
						' . $__templater->button('Reset to defaults', array(
			'class' => 'js-resetWallpaper',
			'data-xf-click' => 'element-value-setter',
			'data-value' => '1',
			'data-selector' => '< .js-message | input[name=\'reset_wallpaper\']',
			'type' => 'submit',
			'form' => $__vars['formId'],
		), '', array(
		)) . '
					';
	}
	$__compilerTemp5 .= '
				';
	if (strlen(trim($__compilerTemp5)) > 0) {
		$__compilerTemp4 .= '
			<div class="button-group">
				' . $__compilerTemp5 . '
			</div>
		';
	}
	$__compilerTemp6 = '';
	if ($__templater->method($__vars['room'], 'canResetRoomWallpaper', array())) {
		$__compilerTemp6 .= '
			' . $__templater->button('Reset room wallpaper', array(
			'class' => 'js-resetWallpaper',
			'data-xf-click' => 'element-value-setter',
			'data-value' => '1',
			'data-selector' => '< .js-message | input[name=\'reset_room_wallpaper\']',
			'type' => 'submit',
			'form' => $__vars['formId'],
		), '', array(
		)) . '
		';
	}
	$__vars['actions'] = $__templater->preEscaped('
		' . $__templater->button('Choose image', array(
		'class' => 'js-uploadButton',
		'data-reset' => 'Reset image',
	), '', array(
	)) . '
		<div class="button-group">
			' . $__templater->button('Update', array(
		'type' => 'submit',
		'form' => $__vars['formId'],
	), '', array(
	)) . '
			' . $__compilerTemp3 . '
		</div>
		' . $__compilerTemp4 . '
		' . $__compilerTemp6 . '
	');
	$__finalCompiled .= '
	
	' . $__templater->callMacro(null, 'rtc_message_macros::type_bubble', array(
		'message' => $__vars['message'],
		'text' => $__vars['form'],
		'filter' => $__vars['filter'],
		'actions' => $__vars['actions'],
		'form' => true,
	), $__vars) . '
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';

	return $__finalCompiled;
}
);