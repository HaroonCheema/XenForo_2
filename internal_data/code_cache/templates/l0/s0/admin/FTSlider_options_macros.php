<?php
// FROM HASH: 0e7a846edd6398be739726749d2f7a45
return array(
'macros' => array('option_form_block' => array(
'arguments' => function($__templater, array $__vars) { return array(
		'group' => '',
		'options' => '!',
		'containerBeforeHtml' => '',
	); },
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '

	';
	$__vars['hundred'] = '0';
	$__finalCompiled .= '

	';
	if (!$__templater->test($__vars['options'], 'empty', array())) {
		$__finalCompiled .= '
		';
		$__compilerTemp1 = '';
		if ($__templater->isTraversable($__vars['options'])) {
			foreach ($__vars['options'] AS $__vars['option']) {
				$__compilerTemp1 .= '
						';
				if ($__vars['option']['Relations']['FTSlider_Options']['display_order'] < 100) {
					$__compilerTemp1 .= '
							';
					if ($__vars['group']) {
						$__compilerTemp1 .= '
								';
						$__vars['curHundred'] = $__templater->func('floor', array($__vars['option']['Relations'][$__vars['group']['group_id']]['display_order'] / 100, ), false);
						$__compilerTemp1 .= '
								';
						if (($__vars['curHundred'] > $__vars['hundred'])) {
							$__compilerTemp1 .= '
									';
							$__vars['hundred'] = $__vars['curHundred'];
							$__compilerTemp1 .= '
									<hr class="formRowSep" />
								';
						}
						$__compilerTemp1 .= '
							';
					}
					$__compilerTemp1 .= '
							' . $__templater->callMacro('option_macros', 'option_row', array(
						'group' => $__vars['group'],
						'option' => $__vars['option'],
					), $__vars) . '
						';
				}
				$__compilerTemp1 .= '
					';
			}
		}
		$__compilerTemp2 = '';
		if ($__templater->isTraversable($__vars['options'])) {
			foreach ($__vars['options'] AS $__vars['option']) {
				$__compilerTemp2 .= '
						';
				if (($__vars['option']['Relations']['FTSlider_Options']['display_order'] >= 100) AND ($__vars['option']['Relations']['FTSlider_Options']['display_order'] < 200)) {
					$__compilerTemp2 .= '
							';
					if ($__vars['group']) {
						$__compilerTemp2 .= '
								';
						$__vars['curHundred'] = $__templater->func('floor', array($__vars['option']['Relations'][$__vars['group']['group_id']]['display_order'] / 100, ), false);
						$__compilerTemp2 .= '
								';
						if (($__vars['curHundred'] > $__vars['hundred'])) {
							$__compilerTemp2 .= '
									';
							$__vars['hundred'] = $__vars['curHundred'];
							$__compilerTemp2 .= '
									<hr class="formRowSep" />
								';
						}
						$__compilerTemp2 .= '
							';
					}
					$__compilerTemp2 .= '
							' . $__templater->callMacro('option_macros', 'option_row', array(
						'group' => $__vars['group'],
						'option' => $__vars['option'],
					), $__vars) . '
						';
				}
				$__compilerTemp2 .= '
					';
			}
		}
		$__compilerTemp3 = '';
		if ($__templater->isTraversable($__vars['options'])) {
			foreach ($__vars['options'] AS $__vars['option']) {
				$__compilerTemp3 .= '
						';
				if (($__vars['option']['Relations']['FTSlider_Options']['display_order'] >= 200) AND ($__vars['option']['Relations']['FTSlider_Options']['display_order'] < 300)) {
					$__compilerTemp3 .= '
							';
					if ($__vars['group']) {
						$__compilerTemp3 .= '
								';
						$__vars['curHundred'] = $__templater->func('floor', array($__vars['option']['Relations'][$__vars['group']['group_id']]['display_order'] / 100, ), false);
						$__compilerTemp3 .= '
								';
						if (($__vars['curHundred'] > $__vars['hundred'])) {
							$__compilerTemp3 .= '
									';
							$__vars['hundred'] = $__vars['curHundred'];
							$__compilerTemp3 .= '
									<hr class="formRowSep" />
								';
						}
						$__compilerTemp3 .= '
							';
					}
					$__compilerTemp3 .= '
							' . $__templater->callMacro('option_macros', 'option_row', array(
						'group' => $__vars['group'],
						'option' => $__vars['option'],
					), $__vars) . '
						';
				}
				$__compilerTemp3 .= '
					';
			}
		}
		$__compilerTemp4 = '';
		if ($__templater->isTraversable($__vars['options'])) {
			foreach ($__vars['options'] AS $__vars['option']) {
				$__compilerTemp4 .= '
						';
				if ($__vars['option']['Relations']['FTSlider_Options']['display_order'] >= 300) {
					$__compilerTemp4 .= '
							';
					if ($__vars['group']) {
						$__compilerTemp4 .= '
								';
						$__vars['curHundred'] = $__templater->func('floor', array($__vars['option']['Relations'][$__vars['group']['group_id']]['display_order'] / 100, ), false);
						$__compilerTemp4 .= '
								';
						if (($__vars['curHundred'] > $__vars['hundred'])) {
							$__compilerTemp4 .= '
									';
							$__vars['hundred'] = $__vars['curHundred'];
							$__compilerTemp4 .= '
									<hr class="formRowSep" />
								';
						}
						$__compilerTemp4 .= '
							';
					}
					$__compilerTemp4 .= '
							' . $__templater->callMacro('option_macros', 'option_row', array(
						'group' => $__vars['group'],
						'option' => $__vars['option'],
					), $__vars) . '
						';
				}
				$__compilerTemp4 .= '
					';
			}
		}
		$__finalCompiled .= $__templater->form('
			' . $__templater->filter($__vars['containerBeforeHtml'], array(array('raw', array()),), true) . '
			<div class="block-container">
				<h3 class="block-formSectionHeader">
					<span class="collapseTrigger collapseTrigger--block is-active" data-xf-click="toggle" data-target="< :up:next">
						' . 'General Options' . '
					</span>
				</h3>
				<div class="block-body block-body--collapsible is-active">
					' . $__compilerTemp1 . '
				</div>
				<h3 class="block-formSectionHeader">
					<span class="collapseTrigger collapseTrigger--block is-active" data-xf-click="toggle" data-target="< :up:next">
						' . 'Slider Options' . '
					</span>
				</h3>
				<div class="block-body block-body--collapsible is-active">
					' . $__compilerTemp2 . '
				</div>
				<h3 class="block-formSectionHeader">
					<span class="collapseTrigger collapseTrigger--block is-active" data-xf-click="toggle" data-target="< :up:next">
						' . 'Nodes Options' . '
					</span>
				</h3>               
				<div class="block-body block-body--collapsible is-active">
					' . $__compilerTemp3 . '
				</div>
				<h3 class="block-formSectionHeader">
					<span class="collapseTrigger collapseTrigger--block is-active" data-xf-click="toggle" data-target="< :up:next">
						' . 'Page Options' . '
					</span>
				</h3>               
				<div class="block-body block-body--collapsible is-active">
					' . $__compilerTemp4 . '
				</div>
				' . $__templater->formSubmitRow(array(
			'sticky' => 'true',
			'icon' => 'save',
		), array(
		)) . '
			</div>
		', array(
			'action' => $__templater->func('link', array('options/update', ), false),
			'ajax' => 'true',
			'class' => 'block',
		)) . '
	';
	}
	$__finalCompiled .= '
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