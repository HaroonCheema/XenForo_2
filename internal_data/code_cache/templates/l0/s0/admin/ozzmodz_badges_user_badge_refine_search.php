<?php
// FROM HASH: eea87eb859fe830b170454c95a33b38f
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->inlineCss('
	.dateRangeInput > .inputGroup{
		width: calc(50% - 2px);
		float: left;
	}
');
	$__finalCompiled .= '

';
	$__compilerTemp1 = '';
	if ($__vars['badgeData']) {
		$__compilerTemp1 .= '
		<div class="menu-row">
			' . 'Badge' . $__vars['xf']['language']['label_separator'] . '
			<div class="u-inputSpacer">
				' . $__templater->callMacro('ozzmodz_badges_badge_macros', 'badge_chooser', array(
			'name' => 'badge_id',
			'value' => $__vars['conditions']['badge_id'],
			'badgeData' => $__vars['badgeData'],
			'multiple' => false,
			'showEmpty' => true,
			'row' => false,
		), $__vars) . '
			</div>
		</div>
	';
	}
	$__compilerTemp2 = array(array(
		'value' => '-1',
		'label' => 'Date presets' . $__vars['xf']['language']['label_separator'],
		'_type' => 'option',
	));
	$__compilerTemp2[] = array(
		'_type' => 'optgroup',
		'options' => array(),
	);
	end($__compilerTemp2); $__compilerTemp3 = key($__compilerTemp2);
	$__compilerTemp2[$__compilerTemp3]['options'] = $__templater->mergeChoiceOptions($__compilerTemp2[$__compilerTemp3]['options'], $__vars['datePresets']);
	$__compilerTemp2[$__compilerTemp3]['options'][] = array(
		'value' => '1995-01-01',
		'label' => 'All time',
		'_type' => 'option',
	);
	$__finalCompiled .= $__templater->form('
	
	<div class="menu-row">
		' . 'Username' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formTextBox(array(
		'name' => 'username',
		'type' => 'search',
		'value' => $__vars['conditions']['username'],
		'ac' => 'single',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
	)) . '
		</div>
	</div>
	
	<div class="menu-row">
		' . 'Awarded by' . $__vars['xf']['language']['label_separator'] . '
		<div class="u-inputSpacer">
			' . $__templater->formTextBox(array(
		'name' => 'awarded_username',
		'type' => 'search',
		'value' => $__vars['conditions']['awarded_username'],
		'ac' => 'single',
		'maxlength' => $__templater->func('max_length', array($__vars['xf']['visitor'], 'username', ), false),
	)) . '
		</div>
	</div>

	' . $__compilerTemp1 . '

	<div class="menu-row menu-row--separated">
		' . 'Date range' . $__vars['xf']['language']['label_separator'] . '
		<div class="inputGroup dateRangeInput u-inputSpacer inputGroup--auto">
			' . $__templater->formDateInput(array(
		'name' => 'start',
		'value' => ($__vars['conditions']['start'] ? $__templater->func('date', array($__vars['conditions']['start'], 'Y-m-d', ), false) : ''),
	)) . '
			<span class="inputGroup-splitter"></span>
			' . $__templater->formDateInput(array(
		'name' => 'end',
		'value' => ($__vars['conditions']['end'] ? $__templater->func('date', array($__vars['conditions']['end'], 'Y-m-d', ), false) : ''),
	)) . '
		</div>
		
		<div class="u-inputSpacer">
			' . $__templater->formSelect(array(
		'name' => 'date_preset',
		'class' => 'js-presetChange',
	), $__compilerTemp2) . '
		</div>

	</div>
	
	<div class="menu-footer">
		<span class="menu-footer-controls">
			' . $__templater->button('
				' . 'Refine search' . '
			', array(
		'type' => 'submit',
		'icon' => 'search',
		'class' => 'button--primary',
	), '', array(
	)) . '
		</span>
	</div>

', array(
		'action' => $__templater->func('link', array('ozzmodz-badges-user-badge', ), false),
	)) . '

';
	$__compilerTemp4 = '';
	if ($__vars['xf']['versionId'] >= 2030031) {
		$__compilerTemp4 .= '
		document.querySelectorAll(\'.js-presetChange\').forEach(element =>
		{
			XF.on(element, \'change\', function (e)
			{
				const ctrl = e.currentTarget,
					value = ctrl.value,
					form = ctrl.closest(\'form\')

				if (value == -1)
				{
					return
				}

				const startInput = form.querySelector(ctrl.getAttribute(\'data-start\') || \'input[name=start]\')
				if (startInput)
				{
					startInput.value = value
				}

				const endInput = form.querySelector(ctrl.getAttribute(\'data-end\') || \'input[name=end]\')
				if (endInput)
				{
					endInput.value = \'\'
				}

				form.submit()
			})
		})
	';
	} else {
		$__compilerTemp4 .= '
		$(function()
		{
			$(\'.js-presetChange\').change(function(e)
			{
				var $ctrl = $(this),
					value = $ctrl.val(),
					$form = $ctrl.closest(\'form\');

				if (value == -1)
				{
					return;
				}

				$form.find($ctrl.data(\'start\') || \'input[name=start]\').val(value);
				$form.find($ctrl.data(\'end\') || \'input[name=end]\').val(\'\');
				$form.submit();
			});
		});
	';
	}
	$__templater->inlineJs('
	' . $__compilerTemp4 . '
');
	return $__finalCompiled;
}
);