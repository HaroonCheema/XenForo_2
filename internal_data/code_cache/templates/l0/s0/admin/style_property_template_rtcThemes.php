<?php
// FROM HASH: 89839a1f674c0093c04e34c401139103
return array(
'macros' => array('theme_settings' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'theme' => array(),
		'formBaseKey' => '!',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	';
	$__vars['indexes'] = array('primary_color', 'surface_color', 'top_left', 'top_right', 'bottom_left', 'bottom_right', 'bubble', 'bubble_details', 'visitor_bubble', 'visitor_bubble_details', 'highlighted_message', );
	$__finalCompiled .= '
	';
	$__vars['defaultValues'] = array('pattern' => 'styles/default/bs/real_time_chat/pattern.svg', );
	$__finalCompiled .= '
	<div class="theme-settings">
		';
	if ($__templater->isTraversable($__vars['indexes'])) {
		foreach ($__vars['indexes'] AS $__vars['index']) {
			$__finalCompiled .= '
			<div style="margin-bottom: 4px;">' . $__templater->func('phrase_dynamic', array(('rtc_theme_setting.' . $__vars['index']) . ':', ), true) . '</div>
			<div class="inputGroup inputGroup--joined" data-xf-init="color-picker" style="margin-bottom: 5px;">
				' . $__templater->formTextBox(array(
				'name' => $__vars['formBaseKey'] . '[' . $__vars['index'] . ']',
				'value' => ($__vars['theme'][$__vars['index']] ?: $__vars['defaultValues'][$__vars['index']]),
			)) . '
				<div class="inputGroup-text" style="width: 30px;padding: 0;">
					<span class="colorPickerBox js-colorPickerTrigger" style="height: 100%; border: none; display: flex; align-items: center; justify-content: center;"></span>
				</div>
			</div>
		';
		}
	}
	$__finalCompiled .= '
		
		<div style="margin-bottom: 4px;">' . 'Pattern' . $__vars['xf']['language']['label_separator'] . '</div>
		' . $__templater->formTextBox(array(
		'name' => $__vars['formBaseKey'] . '[pattern]',
		'value' => ($__vars['theme']['pattern'] ?: $__vars['defaultValues']['pattern']),
	)) . '
	</div>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '<div class="themes-wrapper cssPropertyWrapper" data-toggle-wrapper="1">
	<h3 class="block-header block-header--separated">
		<span class="collapseTrigger collapseTrigger--block ' . ($__vars['isActive'] ? 'is-active' : '') . '"
			  data-xf-click="toggle"
			  data-target="< :up :next"
			  data-xf-init="toggle-storage"
			  data-storage-key="sp-' . $__templater->escape($__vars['property']['property_name']) . '">

			' . $__templater->callMacro(null, 'style_property_macros::customization_hint', array(
		'state' => $__vars['customizationState'],
		'submitName' => $__vars['submitName'],
		'property' => $__vars['property'],
	), $__vars) . '

			<span class="u-anchorTarget" id="sp-' . $__templater->escape($__vars['property']['property_name']) . '"></span><span>' . $__templater->escape($__vars['property']['title']) . '</span>
			';
	if ($__vars['property']['description']) {
		$__finalCompiled .= '<span class="block-desc">' . $__templater->escape($__vars['property']['description']) . '</span>';
	}
	$__finalCompiled .= '
		</span>
	</h3>
	<div class="block-body block-body--collapsible ' . ($__vars['isActive'] ? 'is-active' : '') . '">
		';
	$__vars['themes'] = $__templater->func('array_values', array($__vars['property']['property_value'], ), false);
	$__finalCompiled .= '

		<div class="block-row">
			';
	$__compilerTemp1 = '';
	$__compilerTemp1 .= '
						';
	if ($__vars['customizationState'] == 'custom') {
		$__compilerTemp1 .= '
							<span class="cssPropertyRevert" data-xf-init="tooltip" title="' . $__templater->filter('Revert customizations made in this style', array(array('for_attr', array()),), true) . '">
								' . $__templater->callMacro(null, 'style_property_macros::revert_code', array(
			'submitName' => $__vars['submitName'],
			'property' => $__vars['property'],
			'label' => 'Revert customized value',
			'container' => '< .block-row',
		), $__vars) . '
							</span>
						';
	}
	$__compilerTemp1 .= '
						';
	if ($__vars['definitionEditable']) {
		$__compilerTemp1 .= '
							<span class="u-pullRight">
								' . $__templater->button('', array(
			'href' => $__templater->func('link', array('style-properties/edit', $__vars['property'], ), false),
			'class' => 'button--link button--small',
			'icon' => 'edit',
		), '', array(
		)) . '
							</span>
						';
	}
	$__compilerTemp1 .= '
						';
	if ($__vars['xf']['development']) {
		$__compilerTemp1 .= '<div class="u-muted">' . $__templater->escape($__vars['property']['property_name']) . ' ' . $__templater->filter($__vars['property']['display_order'], array(array('parens', array()),), true) . '</div>';
	}
	$__compilerTemp1 .= '
					';
	if (strlen(trim($__compilerTemp1)) > 0) {
		$__finalCompiled .= '
				<div class="cssPropertyDescription">
					' . $__compilerTemp1 . '
				</div>
			';
	}
	$__finalCompiled .= '
			
			<ul class="listPlain inputGroup-container" style="display: flex; gap: 10px 20px; flex-wrap: wrap; row-gap: 30px;">
				';
	if ($__templater->isTraversable($__vars['themes'])) {
		foreach ($__vars['themes'] AS $__vars['counter'] => $__vars['theme']) {
			if (!$__templater->test($__templater->func('rtc_array_filter', array($__vars['theme'], ), false), 'empty', array())) {
				$__finalCompiled .= '
					<li class="inputGroup" style="gap: 5px; flex-wrap: wrap; margin-top: 0;">
						' . $__templater->callMacro(null, 'theme_settings', array(
					'theme' => $__vars['theme'],
					'formBaseKey' => $__vars['formBaseKey'] . '[' . $__vars['counter'] . ']',
				), $__vars) . '
					</li>
				';
			}
		}
	}
	$__finalCompiled .= '

				';
	$__vars['nextCounter'] = ($__templater->func('count', array($__vars['themes'], ), false) + 1);
	$__finalCompiled .= '

				<li class="inputGroup" style="gap: 5px; flex-wrap: wrap; margin-top: 0;" data-xf-init="field-adder" data-increment-format="' . $__templater->escape($__vars['formBaseKey']) . '[{counter}]">
					' . $__templater->callMacro(null, 'theme_settings', array(
		'formBaseKey' => $__vars['formBaseKey'] . '[' . $__vars['nextCounter'] . ']',
	), $__vars) . '
				</li>
			</ul>
		</div>
	</div>
</div>

';
	return $__finalCompiled;
}
);