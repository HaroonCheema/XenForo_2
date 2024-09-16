<?php
// FROM HASH: 8bd4265cf2761cb6d3386229b9ec2886
return array(
'macros' => array('fontawesome' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'label' => '!',
		'prefix' => '!',
		'groupClass' => '',
		'values' => array(),
		'defaultValues' => array(),
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '
	<dl class="inputLabelPair briviumFontAwesome ' . $__templater->escape($__vars['groupClass']) . '">
		<dt><label>' . $__templater->filter($__vars['label'], array(array('raw', array()),), true) . '</label></dt>
		<dd>
			<button class="btn btn-default"
				data-xf-init="brivium-icon-picker"
				data-config="' . $__templater->filter(array('icon' => ($__vars['values']['class'] ? $__vars['values']['class'] : $__vars['defaultValues']['class']), ), array(array('json', array()),), true) . '"></button>
			<input type="hidden" class="icon" name="' . $__templater->escape($__vars['prefix']) . '[class]" value="' . ($__vars['values']['class'] ? $__templater->escape($__vars['values']['class']) : $__templater->escape($__vars['defaultValues']['class'])) . '" />
			<input type="hidden" class="content" name="' . $__templater->escape($__vars['prefix']) . '[content]" value="' . ($__vars['values']['content'] ? $__templater->escape($__vars['values']['content']) : $__templater->escape($__vars['defaultValues']['content'])) . '" />
			<input type="hidden" class="fontFamily" name="' . $__templater->escape($__vars['prefix']) . '[fontFamily]" value="' . ($__vars['values']['fontFamily'] ? $__templater->escape($__vars['values']['fontFamily']) : $__templater->escape($__vars['defaultValues']['fontFamily'])) . '" />
		</dd>
	</dl>
';
	return $__finalCompiled;
}
)),
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->includeCss('BRATR_icon_rating_option_bootstrap_iconpicker.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('BRATR_option_template_font_awesome.less');
	$__finalCompiled .= '
';
	$__templater->includeCss('BRATR_bootstrap.css');
	$__finalCompiled .= '

';
	$__templater->includeJs(array(
		'src' => 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
	));
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'brivium/AdvancedThreadRating/vendor/Iconpicker/bootstrap-iconpicker.bundle.min.js',
	));
	$__finalCompiled .= '
';
	$__templater->includeJs(array(
		'src' => 'brivium/AdvancedThreadRating/icon-picker.js',
		'min' => '1',
	));
	$__finalCompiled .= '

' . $__templater->formRow('
	<div>
		' . $__templater->callMacro(null, 'fontawesome', array(
		'label' => 'Full Icon',
		'prefix' => $__vars['inputName'] . '[fullIcon]',
		'groupClass' => 'br-full',
		'values' => $__vars['option']['option_value']['fullIcon'],
		'defaultValues' => array('class' => 'fas fa-star', 'content' => '\\f005', ),
	), $__vars) . '

		' . $__templater->callMacro(null, 'fontawesome', array(
		'label' => 'Half Icon',
		'prefix' => $__vars['inputName'] . '[halfIcon]',
		'groupClass' => 'br-half',
		'values' => $__vars['option']['option_value']['halfIcon'],
		'defaultValues' => array('class' => 'fas fa-star-half-alt', 'content' => '\\f5c0', ),
	), $__vars) . '

		' . $__templater->callMacro(null, 'fontawesome', array(
		'label' => 'Disabled Icon',
		'prefix' => $__vars['inputName'] . '[disableIcon]',
		'groupClass' => 'br-empty',
		'values' => $__vars['option']['option_value']['disableIcon'],
		'defaultValues' => array('class' => 'far fa-star', 'content' => '\\f005', ),
	), $__vars) . '
	</div>
', array(
		'rowtype' => 'input',
		'label' => $__templater->escape($__vars['option']['title']),
		'hint' => $__templater->escape($__vars['hintHtml']),
		'explain' => $__templater->escape($__vars['explainHtml']),
		'html' => $__templater->escape($__vars['listedHtml']),
	)) . '

';
	return $__finalCompiled;
}
);